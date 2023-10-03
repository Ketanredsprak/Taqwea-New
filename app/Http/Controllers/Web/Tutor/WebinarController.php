<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CategoryRepository;
use App\Repositories\ClassRepository;
use App\Models\ClassWebinar;
use App\Repositories\ThreadRepository;
use Exception;
use Illuminate\Support\Facades\App;
use Share;
use Illuminate\Support\Facades\URL;

class WebinarController extends Controller
{
    protected $categoryRepository;
    protected $classRepository;
    protected $threadRepository;

    /**
     * Method __construct
     *
     * @param CategoryRepository $categoryRepository [explicite description]
     * @param ClassRepository    $classRepository    [explicite description]
     * @param ThreadRepository   $threadRepository   [explicite description]
     *
     * @return void
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        ClassRepository $classRepository,
        ThreadRepository $threadRepository
    ) {
        $this->categoryRepository = $categoryRepository;
        $this->classRepository = $classRepository;
        $this->threadRepository = $threadRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $params['currentPage'] = 'myWebinars';
        $params['classType'] = 'webinar';
        $params['title'] = trans('labels.my_webinars');
        return view('frontend.tutor.class.index', $params);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = $this->categoryRepository->getParentCategories();
        $data['title'] = trans('labels.my_webinars');
        $data['classType'] = 'webinar';
        return view('frontend.tutor.class.create', $data);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(ClassWebinar $webinar, Request $request)
    {
        $data['categories'] = $this->categoryRepository->getParentCategories();
        $data['class'] = $this->classRepository->getClass($webinar->id);
        $data['title'] = trans('labels.edit_webinar');
        $data['classType'] = 'webinar';
        return view('frontend.tutor.class.create', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug [explicite description]
     * 
     * @return ClassResource
     */
    public function show(string $slug)
    {
        try {
            $class = $this->classRepository->getClass($slug);
            if (!$class) {
                abort(404);
            }
            $params["class_id"] = $class->id;
            $data['is_chat'] = $this->threadRepository->getThread($params);
            $data['class'] = $this->classRepository->getClass($class->id);
            $data['title'] = trans('labels.webinar_detail');
            $data['classType'] = 'webinar';
            $lang = request()->get('lang') ?? config('app.locale');
            App::setLocale($lang);
            $data['shareUrl'] = URL::route('webinars/show', ['class' => $class->slug]);
            $typeLabel = __('labels.class');
            if ($class->class_type == ClassWebinar::TYPE_WEBINAR) {
                $typeLabel = __('labels.webinar');
            }
            $data['shareLinks'] = getShareLinks($data['shareUrl'], __('message.share_message_text', ['type' => $typeLabel]));
            $data['typeLabel'] = $typeLabel;

            return view('frontend.tutor.class.show', $data);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

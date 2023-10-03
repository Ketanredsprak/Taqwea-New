<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\ClassRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use App\Models\ClassWebinar;
use App\Repositories\TransactionRepository;
use App\Repositories\ThreadRepository;
use App\Repositories\CategorySubjectRepository;
use Illuminate\Http\Request;
use Exception;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\App;
use Share;
use Illuminate\Support\Facades\URL;


/**
 * Class for frontend webinar opration
 */
class WebinarController extends Controller
{
    protected $classRepository;

    protected $categoryRepository;

    protected $gradeRepository;

    protected $threadRepository;

    protected $subjectRepository;

    protected $transactionRepository;

    protected $categorySubjectRepository;

    /**
     * Method __construct
     *
     * @param ClassRepository           $classRepository       
     * @param CategoryRepository        $categoryRepository    
     * @param GradeRepository           $gradeRepository       
     * @param SubjectRepository         $subjectRepository     
     * @param TransactionRepository     $transactionRepository 
     * @param ThreadRepository          $threadRepository    
     * @param CategorySubjectRepository $categorySubjectRepository 
     * 
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository,
        CategoryRepository $categoryRepository,
        GradeRepository $gradeRepository,
        SubjectRepository $subjectRepository,
        TransactionRepository $transactionRepository,
        ThreadRepository $threadRepository,
        CategorySubjectRepository $categorySubjectRepository
    ) {
        $this->classRepository = $classRepository;
        $this->categoryRepository = $categoryRepository;
        $this->gradeRepository = $gradeRepository;
        $this->subjectRepository = $subjectRepository;
        $this->transactionRepository = $transactionRepository;
        $this->threadRepository = $threadRepository;
        $this->categorySubjectRepository = $categorySubjectRepository;
    }

    /**
     *  Show webinars
     * 
     * @return View
     */
    public function index(Request $request)
    {
        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            return redirect('/tutor/dashboard');
        }

        $data['maxPrice'] = $this->classRepository->getMaxPrice(['class_type' => 'webinar']);
        $data['education'] = $this->categoryRepository->getByHandle('education');
        $data['grades'] = $this->gradeRepository->getAll();
        $data['subjects'] = $this->subjectRepository->getAll();
        $data['category_subjects'] = $this->categorySubjectRepository
            ->getUniqueSubjects($request->all(), false);
        $data['class_type'] = 'webinar';
        $data['title'] = __('labels.webinars_list');
        $data['generalKnowledge'] = $this->categoryRepository
            ->getByHandle('general-knowledge');
        $data['language'] = $this->categoryRepository->getByHandle('language');
        return view('frontend.class.index', $data);
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request 
     * 
     * @return View
     */
    public function show(Request $request)
    {
        try {
            $class = $this->classRepository->getClass($request->class);
            if (!$class) {
                abort(404);
            }

            $params["class_id"] = $class->id;
            $isChat = $this->threadRepository->getThread($params);

            $class->is_booking = $this->checkBookingItems( 
                [
                'item_id' => $class->id,
                'item_type' => 'class'
                ]
            );
            $lang = request()->get('lang') ?? config('app.locale');
            App::setLocale($lang);
            $url = URL::route('classes/show', ['class' => $class->slug]);
            $typeLabel = __('labels.class');
            if ($class->class_type == ClassWebinar::TYPE_WEBINAR) {
                $typeLabel = __('labels.webinar');
            }
            $shareLinks = getShareLinks($url, __('message.share_message_text', ['type' => $typeLabel]));
            
            return view(
                'frontend.class.show',
                [
                    'class' => $class,
                    'isChat' => $isChat,
                    'type' => ClassWebinar::TYPE_WEBINAR,
                    'isBooked' => checkClassBlogBooked($class->id, 'class'),
                    'shareLinks' => $shareLinks,
                    'url' =>  $url,
                    'typeLabel' => $typeLabel,
                ]
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /** 
     * Method checkBookingItems 
     * 
     * @param $data 
     * 
     * @return Bool
     */
    public function checkBookingItems($data)
    {
        try {
            if (!Auth::check()) {
                return true;
            }
            $this->transactionRepository->checkBookingItems($data);
            return true;
        } catch (Exception $e) {
            return false;
        }
    }

}

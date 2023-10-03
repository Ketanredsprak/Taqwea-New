<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Repositories\BlogRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use Illuminate\Http\Request;
use App\Models\Blog;
use Exception;
use Illuminate\Support\Facades\Crypt;
use App\Models\User;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\Facades\App;

class BlogController extends Controller
{
    protected $blogRepository;
    protected $categoryRepository;
    protected $gradeRepository;
    protected $subjectRepository;

    /**
     * Method __construct
     * 
     * @param BlogRepository     $blogRepository 
     * @param CategoryRepository $categoryRepository [explicite description]
     * @param GradeRepository    $gradeRepository    [explicite description]
     * @param SubjectRepository  $subjectRepository  [explicite description]
     *
     * @return void
     */
    public function __construct(
        BlogRepository $blogRepository,
        CategoryRepository $categoryRepository,
        GradeRepository $gradeRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->blogRepository = $blogRepository;
        $this->categoryRepository = $categoryRepository;
        $this->gradeRepository = $gradeRepository;
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Show blog listing
     * 
     * @return View
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            return redirect('/tutor/dashboard');
        }
        $data['maxPrice'] = $this->blogRepository->getMaxPrice();
        $data['education'] = $this->categoryRepository->getByHandle('education');
        $data['generalKnowledge'] = $this->categoryRepository
            ->getByHandle('general-knowledge');
        $data['language'] = $this->categoryRepository->getByHandle('language');
        $data['grades'] = $this->gradeRepository->getAll();
        $data['categories'] = $this->categoryRepository->getParentCategories();
        $data['subjects'] = $this->subjectRepository->getAll();
        $data['tutor_id'] = '';
        if (@$_GET['tutor_id']) {
            $data['tutor_id'] = Crypt::decryptString(@$_GET['tutor_id']);
        }
        return view('frontend.blog.index', $data);
    }

    /**
     * Get list of blos
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return BlogResource
     */
    public function blogList(Request $request)
    {
        try {
            $params = [];
            if ($request->price) {
                $price = explode(',', $request->price);
                $params['min_price'] = $price[0];
                if ($price[1] <= 500) {
                    $params['max_price'] = $price[1];
                }
            }
            if ($request->category) {
                $params['category'] = explode(',', $request->category);
            }
            if ($request->level) {
                $params['level'] = explode(',', $request->level);
            }
            if ($request->grade) {
                $params['grade'] = explode(',', $request->grade);
            }
            if ($request->subject) {
                $params['subject'] = explode(',', $request->subject);
            }
            if ($request->tutor_id) {
                $params['tutor_id'] = $request->tutor_id;
            }
            if ($request->gk_level) {
                $params['gk_level'] = explode(',', $request->gk_level);
            }
            if ($request->language_level) {
                $params['language_level'] = explode(',', $request->language_level);
            }
            
            $params['status'] = Blog::ACTIVE;
            $blogs = $this->blogRepository->getBlogs($params);
            $html = view('frontend.blog.blog-list', ['blogs' => $blogs])->render();
            return $this->apiSuccessResponse($html, trans('message.blog_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $slug 
     * 
     * @return View
     */
    public function show(string $slug)
    {
        $blog = $this->blogRepository->getBlogBySlug($slug, '', true);
        $is_purchase = checkClassBlogBooked(@$blog->id, 'blog');
        if (!$blog || (!$is_purchase && $blog->deleted_at) ) {
            abort(404);
        }
        $lang = request()->get('lang') ?? config('app.locale');
        App::setLocale($lang);
        $url = URL::route('blog/show', ['blog' => $slug]);
        $shareLinks = getShareLinks($url, __('message.share_message_text', ['type' => __('labels.blog')]));

        return view('frontend.blog.show', ['blog' => $blog, 'shareLinks' => $shareLinks, 'url' =>  $url]);
    }

    /**
     * Method download
     * 
     * @param string $slug 
     * 
     * @return void
     */
    public function download($slug)
    {
        try {
            $blog = $this->blogRepository->getBlogBySlug($slug, '', true);
            if ($blog) {
                $is_purchase = checkClassBlogBooked(@$blog->id, 'blog');
                if (!$is_purchase) {
                    throw new Exception(__('error.please_purchase_blog'));
                }
                $filename_from_url = parse_url($blog->media_url);
                $ext = pathinfo($filename_from_url['path'], PATHINFO_EXTENSION);
                return $this->apiSuccessResponse(
                    [
                        "path" => $blog->media_url,
                        "extension" => $ext 
                    ], 
                    ''           
                );
            }
            
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

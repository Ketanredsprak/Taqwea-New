<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Tutor\AddBlogRequest;
use App\Http\Requests\Tutor\UpdateBlogRequest;
use App\Repositories\BlogRepository;
use App\Models\Blog;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\BlogResource;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\URL;

/**
 * Class is created for tutor blogs oprations 
 */
class BlogController extends Controller
{

    protected $blogRepository;
    protected $categoryRepository;

    /**
     * Method __construct
     * 
     * @param BlogRepository     $blogRepository 
     * @param CategoryRepository $categoryRepository [explicite description]
     *
     * @return void
     */
    public function __construct(
        BlogRepository $blogRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->blogRepository = $blogRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $data['currentPage'] = 'myBlog';
        return view('frontend.tutor.blog.index', $data);
    }

    /**
     * Get list of blogs
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return BlogResource
     */
    public function list(Request $request)
    {
        try {
            $blogs = $this->blogRepository->getBlogs();
            $html = view('frontend.tutor.blog.list', ['blogs' => $blogs])->render();
            return $this->apiSuccessResponse($html, trans('message.blog_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data['categories'] = $this->categoryRepository->getParentCategories();
        $data['currentPage'] = 'myBlog';
        return view('frontend.tutor.blog.create', $data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddBlogRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(AddBlogRequest $request)
    {
        try {
            $data = $request->all();
            $data['tutor_id'] = Auth::user()->id;
            if (empty(@$data['ar']['blog_title'])) {
                unset($data['ar']);
            }
            if ($request->hasFile('media')) {
                $data['mimeType'] = $request->file('media')->getMimeType();
            }
            $data = $this->blogRepository->createBlog($data);
            return $this->apiSuccessResponse($data, trans('message.blog_created'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param string $slug  
     * 
     * @return View
     */
    public function show(string $slug)
    {
        $blog = $this->blogRepository->getBlogBySlug($slug, '', false);
        if (!$blog) {
            abort(404);
        }
        $lang = request()->get('lang') ?? config('app.locale');
        App::setLocale($lang);
        $url = URL::route('blog/show', ['blog' => $slug]);
        $shareLinks = getShareLinks($url, __('message.share_message_text', ['type' => __('labels.blog')]));
        
        return view(
            'frontend.tutor.blog.show',
            [
                'blog' => $blog,
                'shareLinks' => $shareLinks,
                'url' =>  $url
            ]
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Blog $blog 
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit(Blog $blog)
    {
        $data['categories'] = $this->categoryRepository->getParentCategories();
        $data['currentPage'] = 'myBlog';
        $data['blog'] = $blog;
        return view('frontend.tutor.blog.edit', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBlogRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('media')) {
                $data['mimeType'] = $request->file('media')->getMimeType();
            }
            $blog = $this->blogRepository->getBlog($request->blog_id);
            $blog = $this->blogRepository->updateBlog($data, $blog->id);
            return $this->apiSuccessResponse($blog, trans('message.blog_updated'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy(Blog $blog)
    {
        try {
            $this->blogRepository->deleteBlog($blog->id);
            return $this->apiSuccessResponse([], trans('message.blog_deleted'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

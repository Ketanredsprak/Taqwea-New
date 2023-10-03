<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddBlogRequest;
use App\Http\Requests\Api\UpdateBlogRequest;
use App\Http\Resources\V1\BlogResource;
use App\Models\Blog;
use App\Repositories\BlogRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TransactionItemRepository;
use App\Http\Resources\V1\TransactionItemResource;
use App\Models\User;
class BlogController extends Controller
{
    protected $blogRepository;
    
    /**
     * Method __construct
     * 
     * @param BlogRepository            $blogRepository 
     * @param TransactionItemRepository $transactionItemRepository 
     *
     * @return void
     */
    public function __construct(
        BlogRepository $blogRepository,
        TransactionItemRepository $transactionItemRepository
    ) {
        $this->blogRepository = $blogRepository;
        $this->transactionItemRepository = $transactionItemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request 
     * 
     * @return BlogResource
     */
    public function index(Request $request)
    {
        try {
            $data = $request->all();
            $data['status'] = Blog::ACTIVE;
            $blogs = $this->blogRepository->getBlogs($data);
            return BlogResource::collection($blogs);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddBlogRequest $request 
     * 
     * @return BlogResource
     */
    public function store(AddBlogRequest $request)
    {
        try {
            $data = $request->all();
            $data['tutor_id'] = Auth::user()->id;
            if ($request->hasFile('media')) {
                $data['mimeType'] = $request->file('media')->getMimeType();
            }
            $blog = $this->blogRepository->createBlog($data);
            return new BlogResource($blog);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id  
     * 
     * @return BlogResource
     */
    public function show($id)
    {
        try {
            $is_purchase = checkClassBlogBooked(@$id, 'blog');
            $result = $this->blogRepository->getBlogBySlug('', $id, $is_purchase);
            return new BlogResource($result);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateBlogRequest $request 
     * @param Blog              $blog 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateBlogRequest $request, Blog $blog)
    {
        try {
            $data = $request->all();
            if ($request->hasFile('media')) {
                $data['mimeType'] = $request->file('media')->getMimeType();
            }
            $blog = $this->blogRepository->updateBlog($data, $blog->id);
            return new BlogResource($blog);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Blog $blog 
     * 
     * @return void
     */
    public function destroy(
        Blog $blog
    ) {
        try {
            $blog = $this->blogRepository->deleteBlog($blog->id);
            return $this->apiDeleteResponse();
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method purchased
     */

    public function purchased() 
    {
        try {
            $blogs = $this->transactionItemRepository->getBogs();
            return TransactionItemResource::collection($blogs);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method download
     * 
     * @param int $id  
     * 
     * @return void
     */
    public function download($id)
    {
        try {
            if ($id) {
                $is_purchase = checkClassBlogBooked(@$id, 'blog');
                $blog = $this->blogRepository->getBlogBySlug('', $id, $is_purchase);
               
                if (!$is_purchase && Auth::user()->user_type != User::TYPE_TUTOR) {
                    throw new Exception(__('error.please_purchase_blog'));
                }
               
                return $this->apiSuccessResponse(
                    [
                        "url" => $blog->media_url,
                    ], 
                    ''           
                );
            }
            
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

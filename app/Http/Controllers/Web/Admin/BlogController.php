<?php

namespace App\Http\Controllers\Web\Admin;

use Exception;
use App\Models\Blog;
use Illuminate\View\View;
use Illuminate\Http\Request;
use Illuminate\Http\JsonResponse;
use App\Http\Controllers\Controller;
use App\Repositories\BlogRepository;
use App\Http\Resources\V1\BlogResource;
use Illuminate\Support\Facades\Storage;
use App\Repositories\CategoryRepository;
use App\Repositories\TransactionItemRepository;
use App\Http\Resources\V1\TransactionItemResource;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;

class BlogController extends Controller
{
    protected $blogRepository;
    protected $transactionItemRepository;
    protected $categoryRepository;
    

    /**
     * Method __construct
     *
     * @param BlogRepository            $blogRepository
     * @param CategoryRepository        $categoryRepository
     * @param TransactionItemRepository $transactionItemRepository
     *
     * @return void
     */
    public function __construct(
        BlogRepository $blogRepository,
        TransactionItemRepository $transactionItemRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->blogRepository = $blogRepository;
        $this->transactionItemRepository = $transactionItemRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $data['categories'] = $this->categoryRepository->getParentCategories();
        return view('admin.blogs.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request
     *
     * @return View
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return JsonResponse
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param Blog $blog
     *
     * @return \Illuminate\Http\Response
     */
    public function show(Blog $blog)
    {
        return view(
            'admin.blogs.view',
            compact('blog')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request
     * @param int     $blog
     *
     * @return View
     */
    public function edit(Request $request, int $blog)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request
     * @param int     $blog
     *
     * @return JsonResponse
     */
    public function update(Request $request, int $blog)
    {
        try {
            $data = $request->all();
            $result = $this->blogRepository->updateBlog($data, $blog);
            return $this->apiSuccessResponse($result);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     *
     * @return JsonResponse
     */
    public function destroy($id)
    {
    }

    /**
     * Method list
     *
     * @param Request $request [explicite description]
     *
     * @return AnonymousResourceCollection
     */
    public function list(Request $request): AnonymousResourceCollection
    {
        $params = $request->all();
        $blogs = $this->blogRepository->getBlogs($params);
        return BlogResource::collection($blogs);
    }

    /**
     * Method purchased
     *
     * @return View
     */
    public function purchased()
    {
        return view('admin.blogs.purchase');
    }

    /**
     * Method purchaseList
     *
     * @param Request $request
     *
     * @return AnonymousResourceCollection
     */
    public function purchaseList(Request $request):AnonymousResourceCollection
    {
        try {
            $data = $request->all();
            $blogs = $this->transactionItemRepository->getBogs($data);
            return TransactionItemResource::collection($blogs);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function purchasedBlogDetail(int $id)
    {
        $blog = $this->blogRepository->where('id', $id)->withTrashed()->first();
        return view(
            'admin.blogs.purchased-view',
            compact('blog')
        );
    }

    /**
     * Method download
     *
     * @param int $id
     *
     * @return void
     */
    public function download(int $id)
    {
        try {
            $blog = $this->blogRepository->getBlogBySlug('', $id, true);
            if ($blog) {
                $filename_from_url = parse_url($blog->media_url);
                $ext = pathinfo($filename_from_url['path'], PATHINFO_EXTENSION);
                return redirect(
                    Storage::disk(\config('filesystems.private'))->temporaryUrl(
                        $blog->media,
                        now()->addSecond(10),
                        ['ResponseContentDisposition' => 'attachment']
                    )
                );
            }
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

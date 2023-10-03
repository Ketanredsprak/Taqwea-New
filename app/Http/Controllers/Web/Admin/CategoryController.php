<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateCategoryRequest;
use App\Http\Resources\V1\CategoryResource;
use App\Models\Category;
use App\Repositories\CategoryRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;
use App\Models\Demo;

class CategoryController extends Controller
{
    protected $categoryRepository;
    
    /**
     * Method __construct
     *
     * @param CategoryRepository $categoryRepository 
     * 
     * @return void
     */
    public function __construct(
        CategoryRepository $categoryRepository
    ) {
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $parent = $this->categoryRepository->getParentCategories();
        return view(
            'admin.categories.index',
            compact('parent')
        );
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
        $category = null;
        $handle = $request->get('handle');
        $parent = $this->categoryRepository
            ->getByHandle($handle);
        if ($handle == Category::HANDLE_LANGUAGE) {
            $view = view(
                'admin.categories._edit-language',
                compact('parent', 'category')
            );
        } else if ($handle == Category::HANDLE_GK) {
            $view = view(
                'admin.categories._edit-knowledge',
                compact('parent', 'category')
            );
        } else {
            $view = view(
                'admin.categories._edit-education',
                compact('parent', 'category')
            );
        }
        return $view;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UpdateCategoryRequest $request 
     * 
     * @return JsonResponse
     */
    public function store(UpdateCategoryRequest $request)
    {
        // dd($data = $request->all());
        try {
            $data = $request->all();
            $result = $this->categoryRepository->addCategory($data);
            return $this->apiSuccessResponse($result);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request 
     * @param int     $category 
     * 
     * @return View
     */
    public function edit(Request $request, int $category)
    {
        $handle = $request->get('handle');
        $parent = $this->categoryRepository
            ->getByHandle($handle);
        $category = $this->categoryRepository->getCategory($category);
        
        if ($handle == Category::HANDLE_LANGUAGE) {
            $view = view(
                'admin.categories._edit-language',
                compact('parent', 'category')
            );
        } else if ($handle == Category::HANDLE_GK) {
            $view = view(
                'admin.categories._edit-knowledge',
                compact('parent', 'category')
            );
        }
        return $view;
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateCategoryRequest $request 
     * @param int                   $category 
     * 
     * @return JsonResponse
     */
    public function update(UpdateCategoryRequest $request, int $category)
    {
        try {
            $data = $request->all();
            $result = $this->categoryRepository->updateCategory($data, $category);
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
        try {
            $this->categoryRepository->deleteCategory($id);
            return $this->apiDeleteResponse();
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }
    
    /**
     * Method childrens
     *
     * @param Category $category [explicite description]
     * @param Request  $request  [explicite description]
     *
     * @return CategoryResource
     */
    public function childrens(Category $category, Request $request)
    {
        $params = $request->all();
        $params['parent_id'] = $category->id;
        $results = $this->categoryRepository->getCategories($params);
        return CategoryResource::collection($results);
    }
}

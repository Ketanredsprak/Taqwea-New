<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Category;
use App\Repositories\CategoryGradeRepository;
use App\Repositories\CategorySubjectRepository;
use App\Http\Resources\V1\CategoryGradeResource;
use App\Http\Resources\V1\SubjectResource;
use App\Http\Resources\V1\CategoryResource;
use App\Repositories\CategoryRepository;
use Exception;

/**
 * Class for category opration
 */
class CategoryController extends Controller
{
    protected $categoryGradeRepository;
    protected $categorySubjectRepository;
    protected $categoryRepository;

    /**
     * Method __construct
     *
     * @param CategorySubjectRepository $categoryGradeRepository 
     * @param CategoryGradeRepository   $categorySubjectRepository   
     * @param CategoryRepository        $categoryRepository 
     *
     * @return void
     */
    public function __construct(
        CategoryGradeRepository $categoryGradeRepository,
        CategorySubjectRepository $categorySubjectRepository,
        CategoryRepository $categoryRepository
    ) {
        $this->categoryGradeRepository = $categoryGradeRepository;
        $this->categorySubjectRepository = $categorySubjectRepository;
        $this->categoryRepository = $categoryRepository;
    }

    /**
     * Get category grates
     *
     * @param Request $request 
     * 
     * @return Collection
     */
    public function grades(Request $request)
    {
        try {
            $params['category_id'] = explode(',', $request->category);
            $results = $this->categoryGradeRepository
                ->getGrades($params);
            return CategoryGradeResource::collection($results);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request 
     *   
     * @return \Illuminate\Http\Response
     */
    public function subjects(Request $request)
    {
        try {
            $params = $request->all();
            $params['category_id'] = explode(',', $request->category_id);
            $params['grade_id'] = '';
            if (!empty($request->grade_id)) {
                $params['grade_id'] = explode(',', $request->grade_id);
            }

            $results = $this->categorySubjectRepository
                ->getUniqueSubjects($params, false);
                
            return SubjectResource::collection($results);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
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

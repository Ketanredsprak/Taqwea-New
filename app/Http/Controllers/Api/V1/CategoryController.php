<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\CategoryGradeResource;
use App\Http\Resources\V1\CategoryResource;
use App\Http\Resources\V1\GradeResource;
use App\Http\Resources\V1\SubjectResource;
use App\Http\Resources\V1\FilterDataResource;
use App\Models\Category;
use App\Models\CategoryGrade;
use App\Repositories\CategoryGradeRepository;
use App\Repositories\GradeRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\CategorySubjectRepository;
use App\Repositories\SubjectRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;

class CategoryController extends Controller
{
    protected $categoryRepository;

    protected $categoryGradeRepository;

    protected $categorySubjectRepository;

    protected $gradeRepository;

    protected $subjectRepository;
    
    /**
     * Method __construct
     *
     * @param CategoryRepository        $categoryRepository 
     * @param CategoryGradeRepository   $categoryGradeRepository 
     * @param CategorySubjectRepository $categorySubjectRepository 
     * @param GradeRepository           $gradeRepository  
     * @param SubjectRepository         $subjectRepository  
     *
     * @return void
     */
    public function __construct(
        CategoryRepository $categoryRepository,
        CategoryGradeRepository $categoryGradeRepository,
        CategorySubjectRepository $categorySubjectRepository,
        GradeRepository $gradeRepository,
        SubjectRepository $subjectRepository
    ) {
        $this->middleware('jwtAuth')->except(
            [
                'index', 'show', 'grades', 'levels', 'languages', 'generalKnowledge',
                'subjects', 'gradesNew', 'allCategory'
            ]
        );
        $this->categoryRepository = $categoryRepository;
        $this->categoryGradeRepository = $categoryGradeRepository;
        $this->categorySubjectRepository = $categorySubjectRepository;
        $this->gradeRepository = $gradeRepository;
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $results = $this->categoryRepository->getCategories();
            return CategoryResource::collection($results);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request 
     * @param Category $category 
     *   
     * @return \Illuminate\Http\Response
     */
    public function levels(Request $request, Category $category)
    {
        try {
            $params['parent_id'] = $category->id;
            $results = $this->categoryRepository->getCategories($params);
            return CategoryResource::collection($results);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request 
     * 
     * @return Collection
     */
    public function grades(Request $request)
    {
        try {
            $params = $request->all();
            $results = $this->categoryGradeRepository
                ->getGrades($params);
            return CategoryGradeResource::collection($results);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request 
     * @param Category $category 
     *   
     * @return \Illuminate\Http\Response
     */
    public function languages(Request $request, Category $category)
    {
        try {
            $params['parent_id'] = $category->id;
            $results = $this->categoryRepository->getCategories($params);
            return CategoryResource::collection($results);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request  $request 
     * @param Category $category 
     *   
     * @return \Illuminate\Http\Response
     */
    public function generalKnowledge(Request $request, Category $category)
    {
        try {
            $params['parent_id'] = $category->id;
            $results = $this->categoryRepository->getCategories($params);
            return CategoryResource::collection($results);
        } catch(Exception $e) {
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
            $params['count'] = true;
            $results = $this->categorySubjectRepository->getUniqueSubjects($params);
            return SubjectResource::collection($results);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Method allCategory
     * 
     * @return \Illuminate\Http\Response
     */
    public function allCategory()
    {
        try {
           
            $params['all'] = true;
            $education = $this->categoryRepository->getByHandle('education');
            $category = getSubCategory($education->id);
            $subject = $this->subjectRepository->getAll();
            $grades = $this->gradeRepository->getAll();
            $general_Knowledge = $this->categoryRepository
                ->getByHandle('general-knowledge');
            $generalKnowledge = getSubCategory($general_Knowledge->id);
            $language_handle = $this->categoryRepository->getByHandle('language');
            $language = getSubCategory($language_handle->id);
            return new FilterDataResource([], $category, $subject, $grades, $generalKnowledge, $language);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
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
     * Update the specified resource in storage.
     *
     * @param Request $request 
     * @param int     $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

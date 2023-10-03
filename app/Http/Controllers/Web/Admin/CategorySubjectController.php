<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\UpdateSubjectRequest;
use App\Http\Resources\V1\CategorySubjectResource;
use App\Repositories\CategoryRepository;
use App\Repositories\CategorySubjectRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\CategoryGradeRepository;

use Exception;
use Illuminate\Http\Request;

class CategorySubjectController extends Controller
{
    protected $categorySubjectRepository;

    protected $categoryRepository;

    protected $subjectRepository;
    
    /**
     * Method __construct
     *
     * @param CategorySubjectRepository $categorySubjectRepository 
     * @param CategoryRepository        $categoryRepository 
     * @param SubjectRepository         $subjectRepository 
     * @param CategoryGradeRepository   $categoryGradeRepository 
     * 
     * @return void
     */
    public function __construct(
        CategorySubjectRepository $categorySubjectRepository,
        CategoryRepository $categoryRepository,
        SubjectRepository $subjectRepository,
        CategoryGradeRepository $categoryGradeRepository
    ) {
        $this->categorySubjectRepository = $categorySubjectRepository;
        $this->categoryRepository = $categoryRepository;
        $this->subjectRepository = $subjectRepository;
        $this->categoryGradeRepository = $categoryGradeRepository;
        
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request 
     * 
     * @return View
     */
    public function index(Request $request)
    {
        $params = $request->all();
        $results = $this->categorySubjectRepository
            ->getSubjects($params);
        return CategorySubjectResource::collection($results);
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
        $params['without_paginate'] = true;
        $subjects = $this->subjectRepository
            ->getSubjects($params);

        return view(
            'admin.category-subjects._assign-subject',
            compact('parent', 'category', 'subjects')
        );
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param UpdateSubjectRequest $request 
     * 
     * @return JsonResponse
     */
    public function store(UpdateSubjectRequest $request)
    {
        try {
            $data = $request->all();
            $result = $this->categorySubjectRepository->addSubjects($data);
            $message = trans('message.add_category_subject');
            return $this->apiSuccessResponse($result, $message);
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
     * @param int     $id 
     * 
     * @return View
     */
    public function edit(Request $request, int $id)
    {
        $params['without_paginate'] = true;
        $subjects = $this->subjectRepository
            ->getSubjects($params);
        
        $categorySubject = $this->categorySubjectRepository
            ->getById($id);

        return view(
            'admin.category-subjects._edit-assign-subject',
            compact('id', 'subjects', 'categorySubject')
        );
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateSubjectRequest $request 
     * @param int                  $category 
     * 
     * @return JsonResponse
     */
    public function update(UpdateSubjectRequest $request, int $category)
    {
        try {
            $this->categorySubjectRepository->deleteSubjects($category);
            $data = $request->all();
            $result = $this->categorySubjectRepository->addSubjects($data);
            $message = trans('message.update_category_subject');
            return $this->apiSuccessResponse($result, $message);
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
    public function destroy(int $id)
    {
        try {
            $this->categorySubjectRepository->deleteSubjects($id);
            return $this->apiDeleteResponse();
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }
}

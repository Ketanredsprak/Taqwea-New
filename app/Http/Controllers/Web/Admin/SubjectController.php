<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\AddSubjectRequest;
use App\Http\Resources\V1\SubjectResource;
use Illuminate\Http\Request;
use App\Repositories\SubjectRepository;
use Exception;
use Illuminate\Support\Facades\Log;
class SubjectController extends Controller
{
    protected $subjectRepository;

    /**
     * Function __construct
     * 
     * @param $subjectRepository 
     * 
     * @return void
     */
    public function __construct(SubjectRepository $subjectRepository)
    {
        $this->subjectRepository = $subjectRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subjects.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $subject = null;
        return view('admin.subjects.add-subject', compact('subject'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddSubjectRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(AddSubjectRequest $request)
    {
        try {
            $data = $request->all();
            $result = $this->subjectRepository->addSubject($data);
            if (!empty($result)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.add_subject')]
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
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
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $subject = $this->subjectRepository->getSubject($id);
            if (!empty($subject)) {
                return view('admin.subjects.add-subject', compact('subject'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddSubjectRequest $request 
     * @param int               $subject    
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(AddSubjectRequest $request, int $subject)
    {

        try {
            $data = $request->all();
            $result = $this->subjectRepository->updateSubject($data, $subject);
            if (!empty($result)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.update_subject')]
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
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
        try {
            $result = $this->subjectRepository->deleteSubject($id);
            if (!empty($result)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.delete_subject')]
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Function studentList
     *
     * @param Request $request [explicite description]
     * 
     * @return void
     */
    public function subjectList(Request $request)
    {
        $post = $request->all();
        $data = $this->subjectRepository->getSubjects($post);
        return SubjectResource::collection($data);
    }
}

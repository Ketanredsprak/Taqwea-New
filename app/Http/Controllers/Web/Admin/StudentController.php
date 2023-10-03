<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\StudentEditRequest;
use App\Http\Resources\V1\UserResource;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;

/**
 * StudentController class
 */
class StudentController extends Controller
{

    protected $userRepository;
    /**
     * Function __construct
     *
     * @param UserRepository $userRepository [explicite description]
     *
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.students.student-index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request
     *
     * @return Response
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
     * @return Response
     */
    public function show($id)
    {
        try {
            $result = $this->userRepository->findUser($id);
            if (!empty($result)) {
                return view('admin.students.student-view', compact('result'));
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id
     *
     * @return Response
     */
    public function edit($id)
    {
        try {
            $result = $this->userRepository->findUser($id);
            if (!empty($result)) {
                return view('admin.students.edit-student', compact('result'));
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param StudentEditRequest $request
     * @param int                $id
     *
     * @return Response
     */
    public function update(StudentEditRequest $request, $id)
    {
        try {
            $data = $request->all();
            dd($data);
            $result = $this->userRepository->updateUser($data, $id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.edit_student')
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
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
            $result = $this->userRepository->delete($id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.delete_student')
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
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
    public function studentList(Request $request)
    {
        $data = $this->userRepository->getUsers($request->all());
        return UserResource::collection($data);
    }

}

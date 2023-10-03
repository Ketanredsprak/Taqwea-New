<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClassRequestRepository;
use App\Repositories\TutorRequestRepositoty;
use App\Http\Resources\V1\ClassRequestResource;
use App\Http\Requests\Student\ClassRequestRequest;
use App\Models\ClassRequest;

class ClassRequestController extends Controller
{
    protected $classRequestRepository;
    protected $userRepository;
    protected $tutorRequestRepositoty;
    /**
     * Function __construct
     *
     * @param ClassRequestRepository $classRequestRepository [explicite description]
     * @param UserRepository     $userRepository
     * @param TutorRequestRepositoty     $tutorRequestRepositoty
     *
     * @return void
     */
    public function __construct(
        ClassRequestRepository $classRequestRepository,
        UserRepository $userRepository,
        TutorRequestRepositoty $tutorRequestRepositoty
    ) {
        $this->classRequestRepository = $classRequestRepository;
        $this->userRepository = $userRepository;
        $this->tutorRequestRepositoty = $tutorRequestRepositoty;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = $request->all();
            $userId = Auth::id();
            $classrequest = $this->classRequestRepository->getAll($userId);
            return ClassRequestResource::collection($classrequest);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRequestRequest $request)
    {
       
        try {
            $post = $request->all();
            $post['class'] = $post['class'] ?? null;
            $post['class_date'] = $post['class_date'] ?? null;
            // $post['request_time'] = Carbon::now();
            // $post['expired_time'] = Carbon::now()->addMinute('10');
            $timezone = $request->header('time-zone');
            $post['status'] = "Active";
            $post['user_id'] =  Auth::id();
            $post['class_duration'] = $post['class_duration'] * 60;

            $this->classRequestRepository->startTimeCheck($post,$timezone);

            // get tutor list
            $tutors = $this->userRepository
                ->getTutors($post);

            if ($tutors) {
                $result = $this->classRequestRepository->createClassRequest($post);
                if (!empty($result)) {
                    $result1 = $this->tutorRequestRepositoty->createTutorRequest($result, $tutors);
                    return ClassRequestResource::make($result);
                }
            } else {
                return response()->json(
                    ['success' => false, 'message' => "No Tutor Found"]
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
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $result = $this->classRequestRepository->getClassRequest($id);
            return ClassRequestResource::make($result);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use Exception;
use Carbon\Carbon;
use App\Models\ClassRequest;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Http\Resources\V1\QuoteResource;
use App\Repositories\ClassRequestRepository;
use App\Repositories\TutorRequestRepositoty;
use App\Http\Resources\V1\ClassRequestResource;
use App\Repositories\TutorClassRequestRepository;
use App\Repositories\ClassRequestDetailRepository;
use App\Repositories\TutorQuoteRepository;
use App\Http\Requests\Student\ClassRequestRequest;


class ClassRequestController extends Controller
{
    protected $classRequestRepository;
    protected $userRepository;
    protected $tutorRequestRepositoty;
    protected $tutorClassRequestRepository;
    protected $classRequestDetailRepository;
    protected $tutorQuoteRepository;
    /**
     * Function __construct
     *
     * @param ClassRequestRepository $classRequestRepository [explicite description]
     * @param UserRepository     $userRepository
     * @param TutorRequestRepositoty     $tutorRequestRepositoty
     * @param TutorClassRequestRepository $tutorClassRequestRepository [explicite description]
     * @param ClassRequestDetailRepository $classRequestDetailRepository [explicite description]
     * @param TutorQuoteRepository $tutorQuoteRepository [explicite description]
     *
     * @return void
     */
    public function __construct(
        ClassRequestRepository $classRequestRepository,
        UserRepository $userRepository,
        TutorRequestRepositoty $tutorRequestRepositoty,
        TutorClassRequestRepository $tutorClassRequestRepository,
        ClassRequestDetailRepository $classRequestDetailRepository,
        TutorQuoteRepository $tutorQuoteRepository
    ) {
        $this->classRequestRepository = $classRequestRepository;
        $this->userRepository = $userRepository;
        $this->tutorRequestRepositoty = $tutorRequestRepositoty;
        $this->tutorClassRequestRepository = $tutorClassRequestRepository;
        $this->classRequestDetailRepository = $classRequestDetailRepository;
        $this->tutorQuoteRepository = $tutorQuoteRepository;
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

            $this->classRequestRepository->startTimeCheck($post, $timezone);

            // get tutor list
            $tutors = $this->userRepository
                ->getTutors($post);

            if ($tutors) {
                $result = $this->classRequestRepository->createClassRequest($post);
                if (!empty($result)) {
                    $result1 = $this->tutorRequestRepositoty->createTutorRequest($result, $tutors);
                    $data =  ClassRequestResource::make($result);
                    return $this->apiSuccessResponse([$data], '200');
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

    public function classQuote($id)
    {
        try {
            $data = $this->tutorClassRequestRepository->getAll($id);
            return QuoteResource::collection($data);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }


    public function sendquote(QuoteRequest $request)
    {
        try {
            $post = $request->all();
            $post['tutor_id'] = Auth::id();
            $post['user_type'] =  Auth::user()->user_type;
            $post['status'] = "0";
            $result = $this->tutorQuoteRepository->createTutorRequest($post);
            if (!empty($result)) {
                return $this->apiSuccessResponse([], trans('message.price_send'));
            }
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }
    

    public function rejectClassQuote($id)
    {
        try {
            $post['status'] = 2;
            $post['reject_time'] = Carbon::now();
            $data = $this->tutorClassRequestRepository->tutorrequestreject($post, $id);
            return new QuoteResource($data);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    public function acceptClassQuote($id)
    {
        try {
            $post['status'] = 1;
            $data = $this->tutorClassRequestRepository->tutorRequestAccept($post, $id);
            return new QuoteResource($data);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    public function cancelrequest($id)
    {
        try {
            $post['status'] = "Cancel";
            $result = $this->classRequestRepository->cancelrequest($post, $id);
            return $result;
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    
    public function getTutorListForClassRequest($id)
    {
      
        //  
        try {
            $result = $this->classRequestRepository->getClassRequest($id);
            $result1 = $this->tutorQuoteRepository->getTutorListWithQuote($id);
            // return ClassRequestResource::make($result);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }

    }


    

}

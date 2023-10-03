<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ExtraHourResource;
use App\Http\Resources\V1\RaiseHandResource;
use Illuminate\Http\Request;
use App\Repositories\ClassBookingRepository;
use App\Repositories\ClassRepository;
use App\Models\ClassWebinar;
use App\Models\ExtraHourRequest;
use Session;
use App\Repositories\ClassTopicRepository;
use App\Models\RaiseHand;
use App\Models\Transaction;
use App\Repositories\ExtraHourRequestRepository;
use App\Repositories\RaiseHandRepository;
use App\Repositories\TransactionRepository;
use App\Services\AgoraService;
use Carbon\Carbon;
use Codiant\Agora\RtcTokenBuilder;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * ClassController
 */
class ClassController extends Controller
{

    protected $classBookingRepository;
   
    protected $classRepository;

    protected $classTopicRepository;

    protected $raiseHandRepository;

    protected $agoraService;

    protected $extraHourRequestRepository;

    protected $transactionRepository;

    /**
     * Method __construct
     * 
     * @param ClassBookingRepository     $classBookingRepository 
     * @param ClassTopicRepository       $classTopicRepository 
     * @param ClassRepository            $classRepository 
     * @param AgoraService               $agoraService        
     * @param RaiseHandRepository        $raiseHandRepository  
     * @param ExtraHourRequestRepository $extraHourRequestRepository      
     *
     * @return void
     */
    public function __construct(
        ClassBookingRepository $classBookingRepository,
        ClassTopicRepository   $classTopicRepository,
        ClassRepository   $classRepository,
        AgoraService $agoraService,
        RaiseHandRepository $raiseHandRepository,
        ExtraHourRequestRepository $extraHourRequestRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->classBookingRepository = $classBookingRepository;
        $this->classTopicRepository = $classTopicRepository;
        $this->classRepository = $classRepository;
        $this->agoraService = $agoraService;
        $this->raiseHandRepository = $raiseHandRepository;
        $this->extraHourRequestRepository = $extraHourRequestRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Method index
     * 
     * @return Views
     */
    public function index()
    {
        $params['currentPage'] = 'myClasses';
        $params['classType'] = 'class';
        $params['title'] = trans('labels.my_classes');
        return view('frontend.student.class.index', $params);
    }

    /**
     * Method list
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return Json
     */
    public function list(Request $request)
    {
        try {
            $data = [];
            $data['self'] = true;

            if ($request->type == 'upcoming') {
                $data['booking_status'] = 'upcoming';
            } else if ($request->type == 'past') {
                $data['booking_status'] = 'past';
            }

            $data['class_type'] = $request->class_type;
            $classes = $this->classBookingRepository->getBookings($data);

            $html = view(
                'frontend.student.class.class-list',
                [
                    'classes' => $classes,
                    'type' => $request->type
                ]
            )->render();
            return $this->apiSuccessResponse($html, trans('message.class_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    
    /**
     *  Method cancel booking
     * 
     * @param int $bookingId 
     * 
     * @return bool
     */
    public function cancelBooking($bookingId)
    {
        try {
            $userId = Auth::user()->id;
            $data = [
                'user_id' => $userId,
                'booking_id' => $bookingId,
                'user_type' => Auth::user()->user_type
            ];
            $this->classBookingRepository->cancelBooking($data);            
            return $this->apiSuccessResponse([], trans('message.booking_cancelled'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Function joinNow
     * 
     * @param string $slug 
     * 
     * @return view
     */
    public function joinNow(string $slug)
    {
        try{
            $class = $this->classRepository->getClass($slug);
            if (!$class) {
                abort(404);
            }
            $this->classRepository->canJoin($class);
            $data['title'] = __('labels.video_call');
            $data['video_layout'] = true;
            $data['class'] = $class;
            $booking = $this->classBookingRepository
                ->getStudentBookingByClassId($class->id);
            if (!$booking) {
                throw new Exception(__('error.class_booking_not_available'));
            }
            if ($booking->is_live) {
                throw new Exception(__('error.class_already_running'));
            }
            $data['booking'] = $booking;
            
            if (!$booking->is_joined) {
                $bookingData['is_joined'] = 1;
                $this->classBookingRepository->updateBooking(
                    $bookingData,
                    $booking->id
                );
            }
            $data['token'] = $this->agoraService->generateToken(
                'channel-'.$class->id,
                Auth::user()->id,
                RtcTokenBuilder::ROLE_PUBLISHER
            );
            $data['whiteBoardToken'] = $this->agoraService->generateWhiteBoardToken(
                'reader'
            );
            $extraHourRequest = $this->extraHourRequestRepository
                ->getRequest(
                    [
                        'student_id' => Auth::user()->id,
                        'class_id' => $class->id
                    ]
                );
            $data['extraHourRequest'] = $extraHourRequest;
            $AcceptedExtraHourRequest = $this->extraHourRequestRepository
                ->getRequest(
                    [
                        'class_id' => $class->id,
                        'status' => ExtraHourRequest::STATUS_ACCEPTED
                    ]
                );
            $data['endTime'] = $class->end_time;
            if ($extraHourRequest
                && $AcceptedExtraHourRequest
                && in_array(
                    $extraHourRequest->status,
                    [
                        ExtraHourRequest::STATUS_PENDING,
                        ExtraHourRequest::STATUS_REJECTED
                    ]
                )
                && $class->extra_duration
            ) {
                $data['endTime'] = Carbon::parse($class->end_time)
                    ->subMinutes($class->extra_duration);
            } 
            return view('frontend.student.class.join-now', $data);
        } catch(Exception $e) {
            session()->flash('error', $e->getMessage());
            $url = route('student.classes.index');
            if ($class->class_type == ClassWebinar::TYPE_WEBINAR) {
                $url = route('student.webinars.index');
            }
            return redirect($url);
        }
    }

    /**
     *  Method complete booking
     * 
     * @param int $bookingId 
     * 
     * @return bool
     */
    public function completeBooking($bookingId)
    {
        try {
            $userId = Auth::user()->id;
            $data = [
                'user_id' => $userId,
                'booking_id' => $bookingId
            ];
            $this->classBookingRepository->completeBooking($data);            
            return $this->apiSuccessResponse([], trans('message.call_ended'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     *  Method raise hand
     * 
     * @param Request $request 
     * 
     * @return bool
     */
    public function raiseHand(Request $request)
    {
        try {
            $post = $request->all();
            $studentId = Auth::user()->id;
            $data = [
                'student_id' => $studentId,
                'class_id' => $post['class_id'],
                'status' => RaiseHand::STATUS_PENDING
            ];
            $returnData = $this->raiseHandRepository->addRaiseHandRequest($data);  
            return new RaiseHandResource($returnData);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
    
    /**
     * Method updateExtraHourRequest
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function updateExtraHourRequest(Request $request)
    {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $extraHourRequest = $this->extraHourRequestRepository->updateRequest(
                $data
            );
            if (!empty($data['status'])
                && $data['status'] == ExtraHourRequest::STATUS_ACCEPTED
            ) {
                $checkoutData['payment_method'] = Transaction::STATUS_WALLET;
                $checkoutData['item_id'] = $extraHourRequest->class->id;
                $checkoutData['item_type'] = ClassWebinar::TYPE_CLASS;
                $this->transactionRepository->checkout($checkoutData, false);
                $this->classRepository->updateEndtime($extraHourRequest->class);
            }
            DB::commit();
            return new ExtraHourResource($extraHourRequest);
        } catch (Exception $e) {
            DB::rollBack();
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     *  Method updateRaiseHandRequest
     * 
     * @param Request $request 
     * @param int     $id 
     * 
     * @return bool
     */
    public function updateRaiseHandRequest(Request $request, int $id)
    {
        try {
            $data = [
                'status' => $request['status']                
            ];            
            $raiseHandRequest = $this->raiseHandRepository
                ->updateRaiseHandRequest($id, $data);
            return new RaiseHandResource($raiseHandRequest);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

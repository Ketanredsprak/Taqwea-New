<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\CreateBookingRequest;
use App\Http\Resources\V1\ClassBookingResource;
use App\Http\Resources\V1\TransactionResource;
use App\Models\ClassBooking;
use App\Models\Transaction;
use App\Repositories\ClassBookingRepository;
use App\Repositories\TransactionRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class BookingController extends Controller
{
    protected $classBookingRepository;
    protected $transactionRepository;
    
    /**
     * Method __construct
     * 
     * @param ClassBookingRepository $classBookingRepository 
     * @param TransactionRepository  $transactionRepository 
     *
     * @return void
     */
    public function __construct(
        ClassBookingRepository $classBookingRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->classBookingRepository = $classBookingRepository;
        $this->transactionRepository = $transactionRepository;
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
            $params = $request->all();
            $params['self'] = true;
            $bookings = $this->classBookingRepository->getBookings($params);
            return ClassBookingResource::collection($bookings);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param CreateBookingRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(CreateBookingRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            $data['item_id'] = (isset($data["class_id"]) && $data["class_id"] !=0 )
            ?$data["class_id"]:$data["blog_id"];
            
            $data['item_type'] = (isset($data["class_id"]) && $data["class_id"] !=0 )
            ?'class':'blog';
            $data["itemTotal"] = $data['booking_total'];
            $transaction = $this->transactionRepository->checkout($data);
            DB::commit();
            if ($data["payment_method"] == Transaction::STATUS_DIRECT_PAYMENT ) {
                return $this->apiSuccessResponse(
                    [
                        "checkout_url" =>
                        route(
                            'checkout.payNow',
                            ["checkoutId" => $transaction]
                        ).'?item=&card_type='.$data["card_type"]
                    ]
                );
            }
            return new TransactionResource($transaction);
        } catch (Exception $e) {
            DB::rollback();
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param ClassBooking $booking 
     * 
     * @return Response
     */
    public function show(ClassBooking $booking)
    {
        try {
            return new ClassBookingResource($booking);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request 
     * @param int     $id 
     * 
     * @return Response
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
     * @return Response
     */
    public function destroy($id)
    {
        //
    }
    
    /**
     * Method updateStatus
     *
     * @param Request $request 
     * @param int     $booking 
     * @param string  $action  
     * 
     * @return void
     */
    public function updateStatus(
        Request $request,
        int $booking,
        string $action
    ) {
        try {
            $booking = $this->classBookingRepository->updateBookingStatus(
                $booking,
                $action
            );
            return new ClassBookingResource($booking);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method Student list
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function studentList(int $id)
    {
        try {
            $post['class_id'] = $id;
            $post['confirm'] = 'confirm';
            $bookings = $this->classBookingRepository->getBookings($post);
            return ClassBookingResource::collection($bookings);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

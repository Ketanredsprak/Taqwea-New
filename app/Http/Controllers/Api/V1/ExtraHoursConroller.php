<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\ExtraHoursRequest;
use App\Http\Resources\V1\ClassResource;
use App\Http\Resources\V1\ExtraHourResource;
use App\Models\ClassWebinar;
use App\Models\ExtraHourRequest;
use App\Models\Transaction;
use App\Models\User;
use Exception;
use Illuminate\Http\Request;
use App\Repositories\ClassRepository;
use App\Repositories\ExtraHourRequestRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class ExtraHoursConroller extends Controller
{

    protected $classRepository;

    protected $transactionRepository;

    protected $extraHourRequestRepository;

    /**
     * Method __construct
     *
     * @param ClassRepository            $classRepository 
     * @param ExtraHourRequestRepository $extraHourRequestRepository 
     * @param TransactionRepository      $transactionRepository 
     * 
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository,
        ExtraHourRequestRepository $extraHourRequestRepository,
        TransactionRepository $transactionRepository
    ) {
        $this->classRepository = $classRepository;
        $this->extraHourRequestRepository = $extraHourRequestRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClassWebinar $class, Request $request)
    {
        try {
            $params['class_id'] = $class->id;
            if ($request->user->user_type == User::TYPE_STUDENT) {
                $params['student_id'] = $request->user->id;
            }
            $request = $this->extraHourRequestRepository->getRequest($params);
            return new ExtraHourResource($request);
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClassWebinar $class 
     * @param Request      $request 
     * 
     * @return Response
     */
    public function store(ClassWebinar $class, ExtraHoursRequest $request)
    {
        try {
            $data = $request->all();
            $data['extra_duration'] = $data['duration'] * 60;
            $class = $this->classRepository
                ->addExtraHour($class, $data);
            return new ClassResource($class);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClassWebinar     $class 
     * @param ExtraHourRequest $extra_hour 
     * @param Request          $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(
        ClassWebinar $class,
        ExtraHourRequest $extra_hour,
        Request $request
    ) {
        try{
            DB::beginTransaction();
            $data = $request->all();
            $data['class_id'] = $class->id;
            $data['student_id'] = $data['user']['id'];
            $extraHourRequest = $this->extraHourRequestRepository->updateRequest(
                $data
            );
            if ($extraHourRequest && !empty($data['status'])
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

}

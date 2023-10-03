<?php

namespace App\Http\Controllers\Web\Accountant;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RefundRequestResource;
use App\Models\ClassRefundRequest;
use Illuminate\Http\Request;
use App\Repositories\ClassRefundRequestRepository;
use App\Repositories\TransactionItemRepository;
use Illuminate\Support\Facades\DB;
use Exception;


/**
 * RefundRequestController class
 */
class RefundRequestController extends Controller
{

    protected $classRefundRequestRepository;
    protected $transactionItemRepository;
    /**
     * Function __construct
     * 
     * @param ClassRefundRequestRepository $classRefundRequestRepository 
     * @param TransactionItemRepository    $transactionItemRepository 
     * 
     * @return void
     */
    public function __construct(
        ClassRefundRequestRepository $classRefundRequestRepository,
        TransactionItemRepository $transactionItemRepository
    ) {
        $this->classRefundRequestRepository = $classRefundRequestRepository;
        $this->transactionItemRepository = $transactionItemRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('accountant.refund-request.index');
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
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            DB::beginTransaction();
            $post = $request->all();
            $this->classRefundRequestRepository
                ->refundAmount($post);
            $refund = $this->transactionItemRepository->classRefundRequest($post);
            if (!empty($refund)) {
                DB::commit();
                return response()->json(
                    ['success' => true, 'message' => trans('message.refund_amount')]
                );
            }
        } catch (Exception $ex) {
            DB::rollback();
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param Request $request 
     * @param int     $id  
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $id)
    {
        try {
            $data = $request->all();
            $student_details = $this->classRefundRequestRepository
                ->showStudentDetails($id, $data);
            if (!empty($student_details)) {
                return view(
                    'accountant.refund-request.__student-details',
                    compact('student_details')
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * @param int                      $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        try {
            $post = $request->all();
            $post['status'] = ClassRefundRequest::STATUS_CANCEL;
            $result = $this->classRefundRequestRepository
                ->update($post, $id);
            if (!empty($result)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.cancel_reason')]
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
        //
    }

    /**
     * Function RefundRequestList
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function refundRequestList(Request $request)
    {
        $post = $request->all();
        $refund_request = $this
            ->classRefundRequestRepository->refundRequestList($post);
        return RefundRequestResource::collection($refund_request);
    }
}

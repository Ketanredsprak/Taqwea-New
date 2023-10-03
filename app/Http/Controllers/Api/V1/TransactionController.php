<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TransactionRepository;
use App\Repositories\TutorPayoutRepository;
use App\Http\Resources\V1\TransactionResource;
use App\Http\Resources\V1\PayoutResource;
use Exception;

class TransactionController extends Controller
{
    protected $transactionRepository;

    protected $tutorPayoutRepository;

    /**
     * Method __construct
     * 
     * @param TransactionRepository $transactionRepository 
     *
     * @return void
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        TutorPayoutRepository $tutorPayoutRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->tutorPayoutRepository = $tutorPayoutRepository;
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
            $transaction = $this->transactionRepository->getTransactions($params);
            return TransactionResource::collection($transaction);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
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
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
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

    /**
     * Get payoutHistory of transaction
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function payoutHistory(Request $request)
    {
        try {
            $payout = $this->tutorPayoutRepository->getPayouts();
            return PayoutResource::collection($payout);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

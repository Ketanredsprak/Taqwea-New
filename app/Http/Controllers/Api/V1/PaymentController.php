<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PaymentMethodRepository;
use App\Http\Requests\Api\PaymentCartRequest;
use App\Http\Resources\V1\CardResource;
use App\Models\Transaction;
use Exception;

class PaymentController extends Controller
{
    protected $paymentMethodRepository;
    
    /**
     * Method __construct
     *
     * @param PaymentMethodRepository $paymentMethodRepository 
     * 
     * @return void
     */
    public function __construct(
        PaymentMethodRepository $paymentMethodRepository
    ) {
        $this->paymentMethodRepository = $paymentMethodRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param PaymentCartRequest $request 
     * 
     * @return CardResource
     */
    public function index(Request $request)
    {
        try {
            $data = $request->all();
            $result = $this->paymentMethodRepository->getCarts($data);
            return CardResource::collection($result);
        } catch (\Exception $e) {
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
     * @param PaymentCartRequest $request  
     * 
     * @return CardResource
     */
    public function store(PaymentCartRequest $request)
    {
        try {
            $data = $request->all();
            $data['gateway'] = isset($data["payment_gateway"])?
                $data["payment_gateway"]:Transaction::PAYMENT_GATEWAY_HYPERPAY;
            $result = $this->paymentMethodRepository->saveCard($data);
            return new CardResource($result);
        } catch (\Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
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
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request 
     * @param int     $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param Request $request 
     * @param int     $id 
     * 
     * @return Response
     */
    public function destroy(Request $request, $id)
    {
        try {
            $data = $request->all();
            $data['gateway'] = isset($data["payment_gateway"])?
                $data["payment_gateway"]:Transaction::PAYMENT_GATEWAY_HYPERPAY;
            $this->paymentMethodRepository->deleteCard($data, $id);
            return $this->apiDeleteResponse();
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\TopUpResource;
use App\Http\Resources\V1\TopUpPurchaseResource;
use App\Repositories\TopUpRepository;
use Exception;
use App\Repositories\TutorSubscriptionRepository;
use App\Repositories\TopupTutorRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\Transaction;
use Log;
use App\Http\Requests\Api\TopUpPurchaseRequest;

class TopUpController extends Controller
{
    protected $topUpRepository;

    protected $tutorSubscriptionRepository;

    protected $topupTutorRepository;

    /**
     * Method __construct
     * 
     * @param TopUpRepository             $topUpRepository 
     * @param TutorSubscriptionRepository $tutorSubscriptionRepository 
     * @param TopupTutorRepository        $topupTutorRepository        
     *
     * @return void
     */
    public function __construct(
        TopUpRepository $topUpRepository,
        TutorSubscriptionRepository $tutorSubscriptionRepository,
        TopupTutorRepository $topupTutorRepository
    ) {
        $this->topUpRepository = $topUpRepository;
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
        $this->topupTutorRepository = $topupTutorRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $topUp = $this->topUpRepository->getTopUp();
            return new TopUpResource($topUp);  
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
     * @param \Illuminate\Http\TopUpPurchaseRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        try {
            $params = $request->all();
            $params['user_id'] = Auth::user()->id;
            $subscription = $this->tutorSubscriptionRepository
                ->purchaseTopUp($params);

            if ($params["payment_method"] == Transaction::STATUS_DIRECT_PAYMENT ) {
                return $this->apiSuccessResponse(
                    [
                        "checkout_url" =>
                        route(
                            'checkout.payNow', ["checkoutId" => $subscription]
                        ).'?item=&card_type='.$params["card_type"]
                    ]
                );
            }
            return new TopUpPurchaseResource($subscription);
        } catch (Exception $e) {
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
     * Method purchasedList
     * 
     * @param Request $request 
     */
    public function purchased(Request $request)
    {
        try {
            $params = $request->all();
            $params['tutor_id'] = Auth::user()->id;
            $topPurchase = $this->topupTutorRepository
                ->getTopUp($params);
            return TopUpPurchaseResource::collection($topPurchase);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

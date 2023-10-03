<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\SubscriptionResource;
use App\Http\Resources\V1\SubscriptionPurchaseResource;
use App\Repositories\SubscriptionRepository;
use App\Repositories\TutorSubscriptionRepository;
use App\Models\Subscription;
use App\Models\Transaction;
use App\Http\Requests\Api\SubscriptionPurchaseRequest;
use Illuminate\Support\Facades\Auth;
use Exception;
class SubscriptionController extends Controller
{

    protected $subscriptionRepository;

    protected $tutorSubscriptionRepository;
    
    /**
     * Method __construct
     *
     * @param SubscriptionRepository      $subscriptionRepository  
     * @param TutorSubscriptionRepository $tutorSubscriptionRepository  
     * 
     * @return void
     */
    public function __construct(
        SubscriptionRepository $subscriptionRepository,
        TutorSubscriptionRepository $tutorSubscriptionRepository
    ) {
        $this->subscriptionRepository = $subscriptionRepository;
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
    }

    /**
     * Method index
     *
     * @param Request $request 
     * 
     * @return SubscriptionResource
     */
    public function index(Request $request)
    {
       
        try {
            $params = $request->all();
            $params['status'] = Subscription::ACTIVE;
            $subscription = $this->subscriptionRepository
                ->getSubscriptions($params);
            return SubscriptionResource::collection($subscription);
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
     * @param SubscriptionPurchaseRequest $request 
     * 
     * @return SubscriptionPurchaseResource
     */
    public function store(SubscriptionPurchaseRequest $request)
    {
        try {
            $params = $request->all();
            $params['user_id'] = Auth::user()->id;
            $subscription = $this->tutorSubscriptionRepository
                ->purchasePlan($params);
            if ($params["payment_method"] == Transaction::STATUS_DIRECT_PAYMENT ) {
                return $this->apiSuccessResponse(
                    [
                        "checkout_url" =>
                        route(
                            'checkout.payNow', ["checkoutId" => $subscription]
                        ).'?item=subscription&card_type='.$params["card_type"]
                    ]
                );
            }
            return new SubscriptionPurchaseResource($subscription);
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
            $subscription = $this->tutorSubscriptionRepository
                ->getSubscriptions($params);
            return SubscriptionPurchaseResource::collection($subscription);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

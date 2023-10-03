<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TutorSubscriptionRepository;
use App\Repositories\SubscriptionRepository;
use Exception;
use App\Models\Subscription;

/**
 * SubscriptionController
 */
class SubscriptionController extends Controller
{
    protected $tutorSubscriptionRepository;
    protected $subscriptionRepository;

    /**
     * Function __construct
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
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
        $this->subscriptionRepository = $subscriptionRepository;
    }

    /**
     * Function Index
     * 
     * @return void
     */
    public function index()
    {
        $data['status'] = Subscription::ACTIVE;
        $params["is_top_up"] = true;

        $activePlan = $this->tutorSubscriptionRepository->getSubscription($data);
        if ($activePlan && $activePlan->subscription->default_plan == "Yes") {
            $params["is_top_up"] = false;
        }
        $params['currentPage'] = 'subscription';
        $params['title'] = trans("labels.subscription");
        return view('frontend.tutor.subscription.index', $params);
    }

    /**
     * Function Purchase List
     * 
     * @param Request $request 
     * 
     * @return response
     */
    public function purchaseList(Request $request)
    {
        try {
            $subscriptions = $this->tutorSubscriptionRepository->getSubscriptions();
            $html = view(
                'frontend.tutor.subscription.__subscription-list',
                ['subscriptions' => $subscriptions]
            )->render();
            return $this->apiSuccessResponse(
                $html,
                trans('message.subscription_list')
            );
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }

    /**
     * Function Subscription Details
     * 
     * @param $id $id
     * 
     * @return response
     */
    public function subscriptionDetails($id)
    {
        try {
            $post['id'] = $id;
            $subscription = $this->tutorSubscriptionRepository
                ->getSubscription($post);
            $html = view(
                'frontend.tutor.subscription.__subscription-details',
                ['subscription' => $subscription]
            )->render();
            return $this->apiSuccessResponse(
                $html,
                trans('')
            );
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }

    /**
     * Function New Subscription Plan List
     * 
     * @param Request $request 
     * 
     * @return response
     */
    public function subscriptionPlanList(Request $request)
    {
        try {
            $params = $request->all();
            $params['status'] = Subscription::ACTIVE;
            
            $newSubscriptions = $this->subscriptionRepository
                ->getSubscriptions($params);
            $html = view(
                'frontend.tutor.subscription.subscription-plan-list',
                ['newSubscriptions' => $newSubscriptions]
            )->render();
            return $this->apiSuccessResponse(
                $html,
                trans('message.subscription_list')
            );
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }
}

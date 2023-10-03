<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\SubscriptionResource;
use App\Http\Resources\V1\TutorSubscriptionResource;
use Illuminate\Http\Request;
use App\Repositories\SubscriptionRepository;
use App\Repositories\TutorSubscriptionRepository;
use Exception;

/**
 * SubscriptionController Class
 */
class SubscriptionController extends Controller
{
    protected $subscriptionRepository;

    protected $tutorSubscriptionRepository;

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
        $this->subscriptionRepository = $subscriptionRepository;
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('admin.subscription.index');
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
     * @param Request $request 
     * 
     * @return Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return Response
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
        try {
            $subscription = $this->subscriptionRepository->find($id);
            if (!empty($subscription)) {
                return view(
                    'admin.subscription.__edit-subscription',
                    compact('subscription')
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                [
                    'success' => false,
                    'message' => $ex->getMessage()
                ]
            );
        }
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
        try {
            $data = $request->all();
            $result = $this->subscriptionRepository->updateSubscription($data, $id);
            return $this->apiSuccessResponse(
                $result,
                trans('message.update_subscription')
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
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
     * Function Subscription List
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function subscriptionList(Request $request)
    {
        $subscription = $this->subscriptionRepository
            ->getSubscriptions($request->all());
        return SubscriptionResource::collection($subscription);
    }

    /**
     * Function Running Subscription 
     * 
     * @return view 
     */
    public function runningSubscription()
    {
        return view('admin.subscription.running-subscription');
    }

    /**
     * Function Running Subscription List
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function runningSubscriptionList(Request $request)
    {
        $post = $request->all();
        $subscription = $this->tutorSubscriptionRepository->getSubscriptions($post);
        return TutorSubscriptionResource::collection($subscription);
    }
}

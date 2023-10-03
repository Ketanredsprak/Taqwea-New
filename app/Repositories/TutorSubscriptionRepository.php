<?php

namespace App\Repositories;

use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Container\Container as Application;
use App\Models\TutorSubscription;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;
use App\Models\User;
use App\Models\Subscription;
use App\Services\PaymentService;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\TopUpRepository;
use App\Repositories\TopupTutorRepository;
use Carbon\Carbon;
use App\Services\TopUpService;
use App\Services\SubscriptionService;
use Log;

/**
 * TutorSubscriptionRepository 
 */
class TutorSubscriptionRepository extends BaseRepository
{

    protected $subscriptionRepository;

    protected $transactionRepository;

    protected $paymentService;

    protected $paymentMethodRepository;

    protected $walletRepository;

    protected $tutorRepository;

    protected $subscriptionAmount;

    protected $topUpRepository;

    protected $topupTutorRepository;

    protected $topUpService;

    protected $subscriptionService;

    /**
     * Method __construct
     *
     * @param Application             $app                                       
     * @param SubscriptionRepository  $subscriptionRepository  
     * @param TransactionRepository   $transactionRepository   
     * @param PaymentService          $paymentService                       
     * @param PaymentMethodRepository $paymentMethodRepository 
     * @param WalletRepository        $walletRepository        
     * @param TutorRepository         $tutorRepository         
     * @param TopUpRepository         $topUpRepository                    
     * @param TopupTutorRepository    $topupTutorRepository               
     * @param TopUpService            $topUpService               
     * @param SubscriptionService     $subscriptionService               
     * 
     * @return void
     */
    public function __construct(
        Application $app,
        SubscriptionRepository $subscriptionRepository,
        TransactionRepository $transactionRepository,
        PaymentService $paymentService,
        PaymentMethodRepository $paymentMethodRepository,
        WalletRepository $walletRepository,
        TutorRepository $tutorRepository,
        TopUpRepository $topUpRepository,
        TopupTutorRepository $topupTutorRepository,
        TopUpService $topUpService,
        SubscriptionService $subscriptionService
    ) {
        parent::__construct($app);
        $this->subscriptionRepository = $subscriptionRepository;
        $this->transactionRepository = $transactionRepository;
        $this->paymentService = $paymentService;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->walletRepository = $walletRepository;
        $this->tutorRepository = $tutorRepository;
        $this->topUpRepository = $topUpRepository;
        $this->topupTutorRepository = $topupTutorRepository;
        $this->topUpService = $topUpService;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return TutorSubscription::class;
    }

    /**
     * Boot up the repository, pushing criteria
     * 
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Method getSubscriptions
     * 
     * @param Array $params 
     * 
     * @return Object 
     */
    public function getSubscriptions(array $params = [])
    {
        $sortFields = [
            'id' => 'tutor_subscriptions.id',
            'subscription_name' => 'subscription_translations.subscription_name',
            'created_at' => 'tutor_subscriptions.created_at',
            'subscription_detail' => 'subscription_translations.subscription_description',
            'tutor_name' => 'user_translations.name',
            'transaction' => 'subscriptions.amount',
            'expiry_days' => 'end_date',
        ];
        $language = getUserLanguage($params);
        $limit = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->select('tutor_subscriptions.*');
        if (Auth::check() && Auth::user()->user_type == User::TYPE_ADMIN) {
            $query = $query->leftjoin(
                'subscriptions',
                'subscriptions.id',
                'tutor_subscriptions.subscription_id'
            )->leftjoin(
                'subscription_translations',
                'subscription_translations.subscription_id',
                'subscriptions.id'
            )->leftjoin(
                'users',
                'users.id',
                'tutor_subscriptions.user_id'
            )->leftjoin(
                'user_translations',
                'user_translations.user_id',
                'users.id'
            )->leftjoin(
                'transactions',
                'transactions.id',
                'tutor_subscriptions.transaction_id'
            )->groupBy('tutor_subscriptions.id');
        }
        if (Auth::check() && Auth::user()->user_type == User::TYPE_ADMIN) {
            $query->whereRaw(
                "if(user_translations.language IS NOT NULL,
            user_translations.language= '" . $language . "',
                true )"
            );
        }

        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            $query->where('user_id', Auth::user()->id);
        }

        if (isset($params['status'])) {
            $query->where('tutor_subscriptions.status', $params['status']);
        }

        if (!empty($params['from_date'])) {
            $query->whereDate('tutor_subscriptions.created_at', '>=', $params['from_date']);
        }

        if (!empty($params['to_date'])) {
            $query->whereDate('tutor_subscriptions.created_at', '<=', $params['to_date']);
        }

        if (!empty($params['search'])) {
            $query->where(
                function ($qry) use ($params) {
                    $qry->where('subscription_translations.subscription_name', 'like', "%" . $params['search'] . "%")
                        ->orWhere('user_translations.name', 'like', '%' .$params['search']. '%');
                }
            );
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }

        if (in_array($sort, ['subscription_name', 'subscription_description'])) {
            $query->orderByTranslation($sort, $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        return $query->paginate($limit);
    }

    /**
     * Method getSubscriptions
     * 
     * @param Array $params 
     * 
     * @return Object 
     */
    public function getSubscription(array $params = [])
    {
        $query = $this->select('tutor_subscriptions.*');
        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            $query->where('user_id', Auth::user()->id);
        }

        if (!empty($params["user_id"])) {
            $query->where('user_id', $params["user_id"]);
        }

        if (isset($params["status"]) && !empty($params["status"])) {
            $query->where('status', $params["status"]);
        }

        if (isset($params["transaction_id"]) && !empty($params["transaction_id"])) {
            $query->where('transaction_id', $params["transaction_id"]);
        }

        if (isset($params["id"]) && !empty($params["id"])) {
            $query->where('id', $params["id"]);
        }

        return $query->first();
    }

    /**
     * Method purchasePlan
     * 
     * @param array $data 
     * 
     * @return Object 
     */
    public function purchasePlan($data)
    {
        try {
            $data['walletAmount'] = 0;
            $plan = [];
            $paymentStatus = Transaction::STATUS_PENDING;
            if (isset($data['plan_id'])) {

                $subscription = $this->subscriptionRepository
                    ->getSubscription($data['plan_id']);

                if (!$subscription) {
                    throw new Exception(trans('error.subscription_plan_not_found'));
                }
                if ($subscription->default_plan == 'Yes') {
                    $paymentStatus = Transaction::STATUS_SUCCESS;
                }
                $this->subscriptionAmount['amount'] = $subscription['amount'];

                $this->getSubscriptionTotal();
                $data['transaction_id'] = getExternalId();
                if (Auth::check()) {
                    $data['user'] = Auth::user();
                }

                $data['user_id'] = $data['user']->id;
                $data['amount'] = $this->subscriptionAmount['total'];

                // Pay py wallet
                if (isset($data['payment_method'])
                    && $data['payment_method'] == Transaction::STATUS_WALLET
                ) {

                    if (isset($data['subscription_type'])
                        && $data['subscription_type'] !=  Subscription::RECURRING
                    ) {
                        $walletCheck = $this->transactionRepository
                            ->checkWalletAmount($data['amount']);

                        if ($walletCheck === false) {
                            throw new Exception(
                                trans('error.wallet_insufficient_balance')
                            );
                        }
                    }

                    $data['walletAmount'] = $data['amount'];
                    $data['payment_mode'] = Transaction::STATUS_WALLET;
                    $paymentStatus = Transaction::STATUS_SUCCESS;
                }

                $data['transaction_type'] = Transaction::STATUS_SUBSCRIPTION;
                $data['amount'] = $this->subscriptionAmount['amount'];
                $data['total_amount'] = $this->subscriptionAmount['total'];
                $data['vat'] = $this->subscriptionAmount['vat'];
                $data['transaction_fees']
                    = $this->subscriptionAmount['transactionFees'];

                $data['status'] = $paymentStatus;
                

                // Save transaction data
                $transaction = $this->transactionRepository
                    ->createTransaction($data);
                if (isset($data["card_type"])) {
                    $transaction->card_type = $data["card_type"];
                    $transaction->save();
                }
               

                //Create new tutor subscription plan
                $plan =  $this->subscription($data, $subscription, $transaction);
                // wallet entry
                $this->wallet($data, $transaction);

                if (isset($data['payment_method'])
                    && ($data['payment_method'] == Transaction::STATUS_DIRECT_PAYMENT
                    || $data['payment_method'] == Transaction::NEW_CARD)
                ) {
                    
                    $checkoutId = $this->paymentService
                        ->generateCheckoutId($transaction);
                    $transaction->checkout_id = $checkoutId;
                    $transaction->save();
                    return $checkoutId;
                }

                // //RECURRING Payment for
                // if (isset($data['gateway']) && isset($data['payment_method'])
                //     && $data['payment_method'] == Transaction::RECURRING_PAYMENT
                // ) {
                //     $data['merchantTransactionId'] = $transaction->id;
                //     $response = $this->paymentService->recurringPayment($data);
                // }

                if (isset($response) && !empty($response)) {
                    $transaction->external_id
                        = $response["transaction_id"];
                    $transaction->status = $response['status'];
                    $transaction->response_data
                        = $response['response_data'];
                    $transaction->payment_mode
                        = Transaction::STATUS_DIRECT_PAYMENT;
                    $transaction->save();
                    
                    // Update card details
                    $plan->card_type = $data['card_type'];
                    $plan->card_id = $data['card_id'];
                    
                }

                //Get the active plan
                $conditionData = [
                    "status" => TutorSubscription::ACTIVE,
                    "user_id" => $data['user']->id
                ];
                $activePlan =  $this->getSubscription($conditionData);

                // Update status inactive old plan
                if (!empty($activePlan)) {
                    $updateData = ["status" => TutorSubscription::INACTIVE];
                    $this->updatePlan($updateData, $activePlan->id);
                }

                $this->subscriptionService
                    ->upgradeTutorPlan($plan, $data, $activePlan);
            }

            // Update status
            $plan->status = TutorSubscription::ACTIVE;
            $plan->save();
            return $plan;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Method createPlan
     * 
     * @param array $data 
     * 
     * @return Object
     */
    public function createPlan($data)
    {
        return $this->create($data);
    }

    /**
     * Method updatePlan
     * 
     * @param array $data 
     * @param int   $id 
     * 
     * @return Object
     */
    public function updatePlan($data, $id)
    {
        return $this->update($data, $id);
    }

    /**
     * Method saveCard
     * 
     * @param Array $response 
     * @param $data 
     * 
     * @return void
     */
    public function saveCard($response, $data)
    {

        if (isset($response['card_id']) && !empty($response['card_id'])) {
            $data['card_id'] = $response['card_id'];
            $data['brand'] = $response['card_type'];
            $data['card_number'] = $response['card_number'];
            return $this->paymentMethodRepository->saveCard($data, false);
        }
    }

    /**
     * Method wallet
     * 
     * @param Array       $data 
     * @param Transaction $transaction 
     * 
     * @return void
     */
    public function wallet($data, $transaction)
    {
        if ($data['walletAmount'] > 0) {
            $walletData = [
                'user_id' => $data['user_id'],
                'amount' => '-' . $data['walletAmount'],
                'type' => 'debit',
            ];
            $wallet = $this->walletRepository
                ->createWallet($walletData);
            $this->transactionRepository
                ->update(
                    [
                        'wallet_id' => $wallet->id
                    ],
                    $transaction->id
                );
        }
    }

    /**
     * Method subscription
     * 
     * @param array  $data 
     * @param object $subscription 
     * @param object $transaction 
     * 
     * @return Collection 
     */
    public function subscription($data, $subscription, $transaction)
    {

        $planData['user_id'] = $data['user_id'];
        $planData['blog'] = $subscription->blog;
        $planData['commission'] = $subscription->commission;
        $planData['blog_commission'] = $subscription->blog_commission;
        $planData['featured'] = $subscription->featured;
        $planData['webinar_hours'] = $subscription->webinar_hours;
        $planData['class_hours'] = $subscription->class_hours;
        $planData['allow_booking'] = $subscription->allow_booking;
        $planData['subscription_id'] = $subscription->id;
        $planData['transaction_id'] = $transaction->id;
        $planData['status'] = TutorSubscription::INACTIVE;

        if (isset($data["duration"]) && $data["duration"]) {
            $days = $data["duration"] * 30;
            $planData['start_date'] = Carbon::now();
            $planData['end_date']
                = Carbon::now()->addDay($days);

            $planData['plan_duration'] = $data['duration'];
        }
        return $this->createPlan($planData);
    }

    /**
     * Method getSubscriptionTotal
     * 
     * @return Void
     */
    public function getSubscriptionTotal()
    {
        $total = $this->subscriptionAmount['amount'];

        $this->subscriptionAmount['vat'] = $total
            * (getSetting('vat') / 100);

        $this->subscriptionAmount['transactionFees'] = ($total
            + $this->subscriptionAmount['vat']) * (getSetting('transaction_fee') / 100);

        $this->subscriptionAmount['total'] = ($total
            + $this->subscriptionAmount['vat']
            + $this->subscriptionAmount['transactionFees']);
    }

    /**
     * Method purchaseTopUp
     * 
     * @param array $data 
     * 
     * @return Object 
     */
    public function purchaseTopUp($data)
    {
        try {
            $data['walletAmount'] = 0;
            $classAmount = 0;
            $webinarAmount = 0;
            $blogAmount = 0;
            $isFeaturedAmount = 0;
            $transaction = [];
            $paymentStatus = Transaction::STATUS_PENDING;

            if (isset($data['top_up_id'])) {
                $topUp = $this->topUpRepository->getTopUp($data['top_up_id']);

                if (!$topUp) {
                    throw new Exception(trans('error.top_up_not_found'));
                }

                if ($data['class_hours']) {
                    $classAmount
                        = $topUp->class_per_hours_price * $data['class_hours'];
                }

                if ($data['webinar_hours']) {
                    $webinarAmount
                        = $topUp->webinar_per_hours_price * $data['webinar_hours'];
                }

                if ($data['blog_count']) {
                    $blogAmount
                        = $topUp->blog_per_hours_price * $data['blog_count'];
                }

                if ($data['is_featured']) {
                    $isFeaturedAmount
                        = $topUp->is_featured_price * $data['is_featured'];
                }

                $params['itemTotal']
                    = $classAmount + $webinarAmount + $blogAmount + $isFeaturedAmount;

                $this->subscriptionAmount['amount']
                    = $classAmount + $webinarAmount + $blogAmount + $isFeaturedAmount;

                $this->getSubscriptionTotal(); // calculate vat and transaction fees

                $data['transaction_id'] = getExternalId();
                if (Auth::check()) {
                    $data['user'] = Auth::user();
                }
                $data['user_id'] = $data['user']->id;
                $data['amount'] = $this->subscriptionAmount['total'];


                if (isset($data['payment_method'])
                    && $data['payment_method'] == Transaction::STATUS_WALLET
                ) {

                    $walletCheck = $this->transactionRepository
                        ->checkWalletAmount($data['amount']);

                    if ($walletCheck === false) {
                        throw new Exception(
                            trans('error.wallet_insufficient_balance')
                        );
                    }

                    $data['walletAmount'] = $data['amount'];
                    $data['payment_mode'] = Transaction::STATUS_WALLET;
                    $paymentStatus = Transaction::STATUS_SUCCESS;
                }

                $data['transaction_type'] = Transaction::TOP_UP;
                $data['amount'] = $this->subscriptionAmount['amount'];
                $data['total_amount'] = $this->subscriptionAmount['total'];
                $data['vat'] = $this->subscriptionAmount['vat'];
                $data['transaction_fees']
                    = $this->subscriptionAmount['transactionFees'];

                $data['status'] = $paymentStatus;

                // Save transaction 
                $transaction = $this->transactionRepository
                    ->createTransaction($data);
                if (@isset($data["card_type"])) {
                    $transaction->card_type = $data["card_type"];
                    $transaction->save();
                }
               

                // wallet entry
                $this->wallet($data, $transaction);

                // Create tutor top up
                $topUp = $this->createTutorTopUp($data, $transaction);

                if (
                    $data['payment_method'] == Transaction::STATUS_DIRECT_PAYMENT
                    || $data['payment_method'] == Transaction::NEW_CARD
                ) {
                    $checkoutId = $this->paymentService
                        ->generateCheckoutId($transaction);
                    $transaction->checkout_id = $checkoutId;
                    $transaction->save();
                    return $checkoutId;
                }
            }
            $this->topUpService->upgradeTutorTopUp($data);
            return $topUp;
        } catch (Exception $e) {
            throw $e;
        }
    }

    /**
     * Method createTutorTopUp
     * 
     * @param array  $params 
     * @param object $transaction 
     * 
     * @return void
     */
    public function createTutorTopUp($params, $transaction)
    {
        $data['transaction_id'] = $transaction->id;
        $data['tutor_id'] = $params["user"]->id;

        if ($params['class_hours']) {
            $data["class_per_hours"] = $params['class_hours'];
        }

        if ($params['webinar_hours']) {
            $data["webinar_per_hours"] = $params['webinar_hours'];
        }

        if ($params['blog_count']) {
            $data["blog"] = $params['blog_count'];
        }

        if ($params['is_featured']) {
            $data["is_featured_day"] = $params['is_featured'];
        }
        return $this->topupTutorRepository->createTopUp($data);
    }

    /**
     * Method getRecentUsers
     *
     * @param $subscription 
     * 
     * @return Collection
     */
    public function getRecentUsers(
        $subscription = false
    ) {
        $query = $this->where('status', TutorSubscription::ACTIVE);

        if ($subscription) {
            $query->with('tutor')
                ->whereHas(
                    'tutor',
                    function ($subQuery) {
                        $subQuery->where('user_type', 'tutor');
                    }
                );
            $query->with('transaction')
                ->whereHas(
                    'transaction',
                    function ($subQuery) {
                        $subQuery->where('status', 'success');
                    }
                );
        }

        return $query->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }
}

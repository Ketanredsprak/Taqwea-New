<?php

namespace App\Repositories;

use App\Models\RewardPoint;
use App\Models\Transaction;
use App\Models\ClassBooking;
use App\Models\ClassWebinar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use Exception;
use App\Models\Wallet;
use App\Models\TutorSubscription;
use App\Models\TransactionItem;
use App\Repositories\WalletRepository;
use App\Repositories\ClassRepository;
use App\Repositories\BlogRepository;
use App\Repositories\ClassBookingRepository;
use App\Repositories\TransactionItemRepository;
use App\Repositories\CartRepository;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\SubscriptionRepository;
use App\Services\PaymentService;
use App\Services\TopUpService;
use App\Services\SubscriptionService;
use App\Repositories\TopupTutorRepository;
use Log;
use app\Models\User;
use Carbon\Carbon;
use App\Events\BookingEvent;

/**
 * TransactionRepository
 */
class TransactionRepository extends BaseRepository
{
    protected $walletRepository;

    protected $classRepository;

    protected $blogRepository;

    protected $classBookingRepository;

    protected $transactionItemRepository;

    protected $cartRepository;

    protected $shoppingCart;

    protected $paymentService;

    protected $paymentMethodRepository;

    protected $topUpService;

    protected $TopupTutorRepository;

    protected $subscriptionService;

    protected $commission = 0;

    /**
     * Method __construct
     *
     * @param Application               $app
     * @param WalletRepository          $walletRepository
     * @param ClassRepository           $classRepository
     * @param BlogRepository            $blogRepository
     * @param ClassBookingRepository    $classBookingRepository
     * @param TransactionItemRepository $transactionItemRepository
     * @param CartRepository            $cartRepository
     * @param PaymentService            $paymentService
     * @param PaymentMethodRepository   $paymentMethodRepository
     * @param TopUpService              $topUpService
     * @param TopupTutorRepository      $topupTutorRepository
     * @param SubscriptionService       $subscriptionService
     *
     * @return void
     */
    public function __construct(
        Application $app,
        WalletRepository $walletRepository,
        ClassRepository $classRepository,
        BlogRepository $blogRepository,
        ClassBookingRepository $classBookingRepository,
        TransactionItemRepository $transactionItemRepository,
        CartRepository $cartRepository,
        PaymentService $paymentService,
        PaymentMethodRepository $paymentMethodRepository,
        TopUpService $topUpService,
        TopupTutorRepository $topupTutorRepository,
        SubscriptionService $subscriptionService
    ) {
        parent::__construct($app);
        $this->walletRepository = $walletRepository;
        $this->classRepository = $classRepository;
        $this->blogRepository = $blogRepository;
        $this->classBookingRepository = $classBookingRepository;
        $this->transactionItemRepository = $transactionItemRepository;
        $this->cartRepository = $cartRepository;
        $this->paymentService = $paymentService;
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->topUpService = $topUpService;
        $this->topupTutorRepository = $topupTutorRepository;
        $this->subscriptionService = $subscriptionService;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Transaction::class;
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
     * Create Method
     *
     * @param array $data
     *
     * @return Boolean
     */
    public function createTransaction($data)
    {
        try {
            DB::beginTransaction();

            $dataArray = [
                "external_id" => $data['transaction_id'],
                "user_id" => $data['user_id'],
                "amount" => $data['amount'],
                "total_amount" => $data['amount'],
                "payment_mode" => isset($data['payment_mode'])
                    ? $data['payment_mode'] : Transaction::STATUS_DIRECT_PAYMENT,
                "status" => isset($data['status'])
                    ? $data['status'] : Transaction::STATUS_SUCCESS,

                "transaction_type" => isset($data['transaction_type'])
                    ? $data['transaction_type'] : Transaction::STATUS_ADD_TO_WALLET,

                "response_data" => isset($data['response_data'])
                    ? $data['response_data'] : ''
            ];

            if (!empty($data["vat"])) {
                $dataArray["vat"] = $data["vat"];
            }

            if (!empty($data["class_id"])) {
                $dataArray["class_id"] = $data["class_id"];
            }

            if (!empty($data["transaction_fees"])) {
                $dataArray["transaction_fees"] = $data["transaction_fees"];
            }
            if (!empty($data["total_amount"])) {
                $dataArray["total_amount"] = $data["total_amount"];
            }


            if (isset($data['type']) && $data['type'] == "wallet") {
                $dataArray['total_amount'] = $data['amount'];
                $dataArray['wallet_amount'] = $data['amount'];
                $data['type'] = 'credit';
                $wallet = $this->walletRepository
                    ->createWallet($data);
                $dataArray['wallet_id'] = $wallet->id;
            }
            $transaction = $this->create($dataArray);
            DB::commit();
            if (isset($wallet) && !empty($wallet)) {
                return $wallet;
            }
            return $transaction;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Method checkout
     *
     * @param array $data
     *
     * @return ClassBooking
     */
    public function checkout($data, $checkWalletBalance = true)
    {
        $user = Auth::user();
        $success = Transaction::STATUS_PENDING;
        $successStatusItem = TransactionItem::STATUS_PENDING;
        $transactionType = Transaction::STATUS_BOOKING;
        if ($user->user_type == User::TYPE_STUDENT) {
            $available =  Wallet::availableBalance($user->id);

            /**
             * Check wallet negative balance
             *
             * @var int available
             */
            if ($available < 0) {
                throw new Exception(trans('error.wallet_negative_balance'));
            }
        }

        $data['walletAmount'] = 0;
        $bookingFrom = 'cart';
        if (@$data['item_id']) {
            $bookingFrom = 'direct';
            // If booking with book now (single item)
            $this->checkBookingItems($data, !$checkWalletBalance);
        } else {
            // If booking with cart
            $this->getCartItems();
        }

        $this->getBookingTotal();
        if ($data['payment_method'] == Transaction::STATUS_WALLET) {
            $walletCheck = $this->checkWalletAmount(
                $this->shoppingCart['bookingTotal']
            );
            if ($checkWalletBalance && $walletCheck === false) {
                throw new Exception(trans('error.wallet_insufficient_balance'));
            }
            $paymentMode = Transaction::STATUS_WALLET;
            $externalId = getExternalId();
            $data['walletAmount'] = $this->shoppingCart['bookingTotal'];
            $success = Transaction::STATUS_SUCCESS;
            $successStatusItem = TransactionItem::STATUS_CONFIRMED;
        }
        
        if (!$checkWalletBalance) {
            $transactionType = Transaction::STATUS_EXTRA_HOURS;
        }
        // Add transaction
        $transactionData = [
            'user_id' => $user->id,
            'total_amount' => $this->shoppingCart['bookingTotal'],
            'transaction_type' => $transactionType,
            'vat' => $this->shoppingCart['vat'],
            'transaction_fees' => $this->shoppingCart['transactionFees'],
            'wallet_amount' => $data['walletAmount'],
        ];

        if (!empty($externalId)) {
            $transactionData['external_id'] = $externalId;
        }

        if (!empty($externalId)) {
            $transactionData['payment_mode'] = $paymentMode;
        }

        if (!empty($data['card_type'])) {
            $transactionData['card_type'] = $data['card_type'];
        }
        // Empty cart If booking from cart
        if ($bookingFrom == 'cart') {
            $transactionData['booking_by'] = Transaction::BOOKING_BY_CART;
        }

        $transactionData['status'] = $success;

        $transaction = $this->create($transactionData);
        // End add transaction

        if (!empty($transaction)) {
            $this->addTransactionItems(
                $transaction->id,
                $this->shoppingCart['items'],
                $successStatusItem
            );
        }

        // Check payment by wallet
        if ($data['walletAmount'] > 0) {
            $walletData = [
                'user_id' => $user->id,
                'amount' => '-' . $data['walletAmount'],
                'type' => 'debit',
            ];
            $wallet = $this->walletRepository
                ->createWallet($walletData);
            $this->update(['wallet_id' => $wallet->id], $transaction->id);
        }
       

        // Payment getaways
        if ($data['payment_method'] == Transaction::STATUS_DIRECT_PAYMENT
            || $data['payment_method'] == Transaction::NEW_CARD
        ) {
            $checkoutId = $this->generateCheckoutId($transaction);
            $transaction->checkout_id = $checkoutId;
            $transaction->save();
            return $checkoutId;
        }
        // Empty cart If booking from cart
        if ($bookingFrom == 'cart') {
            $this->cartRepository->deleteCart($user->id);
        }
        BookingEvent::dispatch($transaction->id);
        return $transaction;
    }

    /**
     * Get cart items
     *
     * @return Void
     */
    public function getCartItems()
    {
        $user = Auth::user();
        $cart = $this->cartRepository->getCart($user->id);
        if (!empty($cart) && !empty($cart->items)) {
            foreach ($cart->items as $item) {
                if (!empty($item->class_id)) {
                    $data['item_id'] = $item->class_id;
                    $data['item_type'] = 'class';
                } elseif (!empty($item->blog_id)) {
                    $data['item_id'] = $item->blog_id;
                    $data['item_type'] = 'blog';
                }
                $this->checkBookingItems($data);
            }
        }
    }

    /**
     * Check booking items
     *
     * @param $data
     *
     * @return Void
     */
    public function checkBookingItems($data, $isExtraHour = false)
    {
        $user = Auth::user();
        if (@$data['item_id']) {
            if (@$data['item_type'] == 'class') {
                // Check class available or not
                if (!$isExtraHour) {
                    $item = $this->classRepository
                        ->checkClassAvailable($data['item_id']);
                    // Check student already booking at class time
                    $bookingCheck = $this->classBookingRepository
                        ->checkStudentBooking(
                            $item->start_time,
                            $item->duration,
                            $user->id
                        );
                } else {
                    $item = $this->classRepository
                        ->getClass($data['item_id']);
                    $endTime = Carbon::parse($item->start_time)
                        ->addMinutes($item->duration);
                    $parentBooking = $this->classBookingRepository
                        ->getStudentBookingByClassId(
                            $item->id
                        );
                    $bookingCheck = $this->classBookingRepository
                        ->checkStudentBooking(
                            $endTime,
                            $item->extra_duration,
                            $user->id,
                            $item->id
                        );
                }
                if (!empty($bookingCheck)) {
                    throw new Exception(trans('error.already_booked_class'));
                }

                $item->item_type = 'class';
                $item->item_id = $item->id;
                if ($isExtraHour) {
                    $item->item_amount = $item->extra_hour_charge;
                    $item->is_extra_hour = 1;
                    $item->parent_id = $parentBooking->id;
                } else {
                    if (!empty($item->total_fees)) {
                        $item->item_amount = $item->total_fees;
                    } else {
                        $item->item_amount = $item->hourly_fees * ($item->duration / 60);
                    }
                }
            }
            if (@$data['item_type'] == 'blog') {
                $is_purchase = $this->transactionItemRepository
                    ->checkPurchased($user->id, $data['item_id']);
                if ($is_purchase) {
                    throw new Exception(trans('error.blog_purchased'));
                }
                $item = $this->blogRepository->getBlog($data['item_id']);
                if (empty($item)) {
                    throw new Exception(trans('error.blog_not_available'));
                }
                $item->item_type = 'blog';
                $item->item_id = $item->id;
                $item->item_amount = $item->total_fees;
            }
            $this->shoppingCart['cartTotal'] = (@$this->shoppingCart['cartTotal'])
                ? @$this->shoppingCart['cartTotal']
                + $item->item_amount
                : $item->item_amount;
            $this->shoppingCart['items'][] = $item;
        }
    }

    /**
     * Add transaction items
     *
     * @param $id
     * @param $items
     *
     * @return Void
     */
    public function addTransactionItems($id, $items, $status = '')
    {
        $user = Auth::user();
        if (!empty($items)) {
            foreach ($items as $item) {
                $transactionItemData = [
                    'transaction_id' => $id,
                    'student_id' => $user->id,
                    'status' => $status,
                ];
                if ($item->item_type == 'class') {
                    // Add class booking
                    $classBookingData = [
                        'class_id' => $item->item_id,
                        'transaction_id' => $id,
                        'student_id' => $user->id,
                        'status' => $status,
                        'is_extra_hour' => $item->is_extra_hour ? '1' : '0',
                        'parent_id' => $item->parent_id
                    ];
                    $this->classBookingRepository->firstOrCreate($classBookingData);

                    $transactionItemData['class_id'] = $item->item_id;
                    // commission calculate
                    $tutorPlan = TutorSubscription::tutorActivePlan($item->tutor_id);
                    $commission = isset($tutorPlan->commission) ?
                        $tutorPlan->commission : 0;
                }
                if ($item->item_type == 'blog') {
                    $transactionItemData['blog_id'] = $item->item_id;
                    // commission calculate
                    $tutorPlan = TutorSubscription::tutorActivePlan($item->tutor_id);
                    $commission = isset($tutorPlan->blog_commission) ?
                        $tutorPlan->blog_commission : 0;
                }


                $commission = ($item->item_amount * ($commission / 100));


                $transactionItemData['total_amount'] = $item->item_amount;
                $transactionItemData['commission'] = $commission;
                $transactionItemData['amount'] = $item->item_amount - $commission;
                $this->transactionItemRepository->create($transactionItemData);
            }
        }
    }

    /**
     * Get booking total amount
     *
     * @return Void
     */
    public function getBookingTotal()
    {
        $cartTotal = $this->shoppingCart['cartTotal'];
        $this->shoppingCart['vat'] = formatAmount(
            $cartTotal * (getSetting('vat') / 100)
        );

        $this->shoppingCart['transactionFees'] = formatAmount(
            ($cartTotal + $this->shoppingCart['vat']) * (getSetting('transaction_fee') / 100)
        );

        $this->shoppingCart['bookingTotal'] = formatAmount(
            ($cartTotal + $this->shoppingCart['vat'] + $this->shoppingCart['transactionFees'])
        );
    }

    /**
     * Check user wallet amount
     *
     * @param $bookingAmount
     *
     * @return Bool
     */
    public function checkWalletAmount($bookingAmount)
    {
        $user = Auth::user();
        $walletAmount = Wallet::availableBalance($user->id);
        if ($walletAmount >= $bookingAmount) {
            return true;
        }
        return false;
    }

    /**
     * Get class details
     *
     * @param $id
     *
     * @return Object
     */
    public function getClass($id)
    {
        return $this->classRepository->getClass($id);
    }

    /**
     * Get blog details
     *
     * @param $id
     *
     * @return Object
     */
    public function getBlog($id)
    {
        return $this->blogRepository->getBlog($id);
    }

    /**
     * Get cart details
     *
     * @param $id
     *
     * @return Object
     */
    public function getCart($id)
    {
        return $this->cartRepository->getCart($id);
    }

    /**
     * Method getTransactions
     *
     * @param array $params
     *
     * @return Object
     */
    public function getTransactions(array $params = [])
    {
        $sortFields = [
            'id' => 'id',
            'transaction_id' => 'external_id',
            'name' => 'user_translations.name',
            'total_amount' => 'total_amount',
            'admin_commission' => 'transaction_items.commission',
            'transaction_date' => 'created_at',
            'status' => 'status',
            'payment_mode' => 'payment_mode',
        ];
        $language = getUserLanguage($params);
        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->select('transactions.*');
        if (Auth::user()->user_type == User::TYPE_ADMIN) {
            $query->leftjoin(
                'transaction_items',
                'transactions.id',
                'transaction_items.transaction_id'
            )->leftjoin(
                'users',
                'transactions.user_id',
                'users.id'
            )->leftjoin(
                'user_translations',
                'users.id',
                'user_translations.user_id'
            );
            $query->whereRaw(
                "if(user_translations.language IS NOT NULL,
            user_translations.language= '" . $language . "',
                true )"
            );
            $query->groupBy('transactions.id');
        }

        if (!empty($params['search'])) {
            $query->where("transactions.external_id", 'Like', '%' . $params['search'] . '%');
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }
        if (!empty($params['from_date'])) {
            $query->whereDate('transactions.created_at', '>=', $params['from_date']);
        }

        if (!empty($params['to_date'])) {
            $query->whereDate('transactions.created_at', '<=', $params['to_date']);
        }

        if (!empty($params['status'])) {
            $query->where('transactions.status', $params['status']);
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }
        if (!empty($sort)) {
            $query->orderBy($sort, $direction);
        }
        if (Auth::check() && Auth::user()->user_type != User::TYPE_ADMIN) {
            $query->where('user_id', Auth::user()->id);
        }
        if (isset($params['is_paginate'])) {
            return $query->get();
        }
        return $query->paginate($size);
    }

    /**
     * Method getTransactions
     *
     * @param array $params
     *
     * @return Object
     */
    public function getTransaction(array $params = [])
    {
        return $this->orderBy('id', 'DESC')
            ->when(
                !empty($params["checkout_id"]),
                function ($query) use ($params) {
                    $query->where("checkout_id", $params["checkout_id"]);
                }
            )
            ->when(
                !empty($params["transaction_id"]),
                function ($query) use ($params) {
                    $query->where("id", $params["transaction_id"]);
                }
            )
            ->first();
    }

    /**
     * Method walletTransaction
     *
     * @param array $data
     *
     * @return Add amount to walet
     */
    public function walletTransaction($data)
    {
        $user = Auth::user();
        $this->getWalletTransactionTotal($data['amount']);

        // Add transaction
        $transactionData = [
            'user_id' => $user->id,
            'total_amount' => $this->shoppingCart['bookingTotal'],
            'amount' => $this->shoppingCart['cartTotal'],
            'transaction_type' => Transaction::STATUS_ADD_TO_WALLET,
            'vat' => 0,
            'transaction_fees' => 0,
            'wallet_amount' => 0,
            'status' => Transaction::STATUS_PENDING,
            'card_type' => $data["card_type"],
        ];
        // save transaction
        $transaction = $this->create($transactionData);
        $checkoutId = $this->generateCheckoutId($transaction);
        $transaction->checkout_id = $checkoutId;
        $transaction->save();
        return $checkoutId;
    }

    /**
     * Method getWalletTransactionTotal
     *
     * @param float $amount
     *
     * @return void
     */
    public function getWalletTransactionTotal($amount)
    {
        $this->shoppingCart['cartTotal'] = $amount;
        // $this->shoppingCart['transactionFees'] = $amount
        //     * ((int)getSetting('transaction_fee') / 100);

        $this->shoppingCart['bookingTotal'] = $amount;
    }

    /**
     * Method paymentCheckoutId
     *
     * @param object $params
     *
     * @return string
     */
    public function generateCheckoutId($params = [])
    {
        return $this->paymentService->generateCheckoutId($params);
    }

    /**
     * Method getPaymentStatus
     *
     * @param Array $params
     *
     * @return Bool
     */
    public function getPaymentStatus($params)
    {
        $result = $this->paymentService->getPaymentStatus($params);
        $transaction = $this->find($result["merchantTransactionId"]);
        $transaction->external_id = $result["transaction_id"];
        $transaction->payment_mode = Transaction::STATUS_DIRECT_PAYMENT;
        $transaction->status = $result["status"];
        $transaction->response_data = $result["response_data"];
        $user = User::find($transaction->user_id);

        // Empty cart If booking from cart
        if ($transaction->booking_by == Transaction::BOOKING_BY_CART) {
            $this->cartRepository->deleteCart($user->id);
        }

        // Add amount in user wallet
        if ($transaction->transaction_type == Transaction::STATUS_ADD_TO_WALLET
            && $result["status"] == Transaction::STATUS_SUCCESS
        ) {
            $walletData = [
                'user_id' => $transaction->user_id,
                'amount' => $transaction->amount,
                'type' => Wallet::STATUS_CREDIT,
            ];
            $wallet = $this->walletRepository
                ->createWallet($walletData);
            $transaction->wallet_id = $wallet->id;
        }

        //Save card details
        if (isset($result['card_id'])
            && !empty($result['card_id'])
        ) {
            $this->paymentMethodRepository->saveCard($result, false, $user);
        }

        // Upgrate the top up plan
        if ($result["status"] == Transaction::STATUS_SUCCESS
            && $transaction->transaction_type == Transaction::TOP_UP
        ) {
            $topUp = $this->topupTutorRepository
                ->getTopUpByTransactionId(["transaction_id" => $transaction->id]);
            $paramTop["user"] = $user;
            $paramTop["class_hours"] = $topUp->class_per_hours;
            $paramTop["webinar_hours"] = $topUp->webinar_per_hours;
            $paramTop["blog_count"] = $topUp->blog;
            $paramTop["is_featured"] = $topUp->is_featured_day;
            $this->topUpService->upgradeTutorTopUp($paramTop);
        }

        // Upgrade the subscription plan
        if ($result["status"] == Transaction::STATUS_SUCCESS
            && $transaction->transaction_type == Transaction::STATUS_SUBSCRIPTION
        ) {
            $plan = TutorSubscription::getPlanByTransactionId($transaction->id);

            //Get the active plan
            $activePlan =  TutorSubscription::tutorActivePlan($transaction->user_id);

            // Update status inactive old plan
            if (!empty($activePlan)) {
                $activePlan->status = TutorSubscription::INACTIVE;
                $activePlan->save();
            }
            $data["user"] = $user;
            $this->subscriptionService
                ->upgradeTutorPlan($plan, $data, $activePlan);

            // Update tutor plan status
            $plan->status = TutorSubscription::ACTIVE;
            $plan->card_id = $result["card_id"];
            $plan->card_type = $result["brand"];
            $plan->save();
        }

        // Upgrade the Booking update
        if ($transaction->transaction_type == Transaction::STATUS_BOOKING) {
            if ($result["status"] == Transaction::STATUS_SUCCESS) {
                $transactionUpdateData = [
                    "status" => TransactionItem::STATUS_CONFIRMED
                ];
                $bookingUpdateData = [
                    "status" => ClassBooking::STATUS_CONFIRMED
                ];
                BookingEvent::dispatch($transaction->id);
            } else {
                $transactionUpdateData = [
                    "status" => ClassBooking::STATUS_CANCELLED
                ];
                if ($transaction->user_id) {
                    $transactionUpdateData['cancelled_by'] = $transaction->user_id;
                }
                $bookingUpdateData = [
                    "status" => ClassBooking::STATUS_FAILED
                ];
            }
            $this->classBookingRepository
                ->where('transaction_id', $transaction->id)
                ->update($transactionUpdateData);

            $this->transactionItemRepository
                ->where('transaction_id', $transaction->id)
                ->update($bookingUpdateData);
        }

        $transaction->save();
        return $transaction;
    }
    /**
     * Function Revenue Report
     *
     * @param $params
     *
     * @return object
     */
    public function revenueReport($params = [])
    {
        $query = $this->select(
            'transactions.created_at',
            'transactions.amount',
            DB::raw("DATE_FORMAT(transactions.created_at, '%m') as month"),
            DB::raw(
                "sum(
                    IF(
                        (transactions.transaction_type='subscription' 
                        or transactions.transaction_type='top_up'),
                        transactions.amount, 0
                    )
                ) as subscription_sum"
            ),
            DB::raw(
                " sum(
                    IF( 
                        (
                            transaction_items.class_id 
                            and 
                            transaction_items.status 
                            = '" . TransactionItem::STATUS_CONFIRMED . "'
                            and transaction_items.class_id in 
                                (select id FROM class_webinars 
                                    where class_type 
                                    = '" . ClassWebinar::TYPE_WEBINAR . "'
                                )
                        ),
                        transaction_items.commission, 0
                    )
                ) 
                  as webinar_sum"
            ),
            DB::raw(
                " sum(
                    IF( 
                        (
                            transaction_items.class_id 
                            and transaction_items.status 
                            = '" . TransactionItem::STATUS_CONFIRMED . "'
                            and transaction_items.class_id in 
                            (select id FROM class_webinars 
                                where class_type = '" . ClassWebinar::TYPE_CLASS . "'
                            )
                        ),
                        transaction_items.commission, 0
                    )
                ) 
                  as class_sum"
            ),
            DB::raw(
                "sum(
                    IF( 
                        (
                            transaction_items.blog_id 
                            and transaction_items.status 
                            = '" . TransactionItem::STATUS_CONFIRMED . "'
                        ),
                        transaction_items.commission, 0
                    )
                ) as blog_sum"
            ),
            DB::raw(
                "sum(
                    IF( 
                        (
                             transactions.transaction_type 
                            = '" . Transaction::STATUS_FINE . "'
                        ),
                        transactions.amount, 0
                    )
                ) as fine_sum"
            ),
            DB::raw(
                "sum(
                    IF( 
                        (
                             transaction_items.status 
                            = '" . TransactionItem::STATUS_REFUND . "'
                        ),
                        transaction_items.commission, 0
                    )
                ) as refund_sum"
            )
        )->leftjoin(
            'transaction_items',
            'transaction_items.transaction_id',
            'transactions.id'
        )->where('transactions.status', Transaction::STATUS_SUCCESS)
            ->whereYear('transactions.created_at', $params['year']);
        $query =  $query->groupBy(
            DB::raw("month")
        )->get();

        $query->map(
            function ($item) {
                $item->point_sum = abs(RewardPoint::getMonthPoints($item->created_at));

                return $item;
            }
        );

        return $query;
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Models\Transaction;
use Illuminate\Support\Facades\Crypt;
use Illuminate\Http\Request;
use App\Repositories\TransactionRepository;
use App\Repositories\SubscriptionRepository;
use App\Repositories\TutorSubscriptionRepository;
use App\Repositories\topUpRepository;
use App\Models\Wallet;
use Illuminate\Support\Facades\Auth;
use Exception;
use Illuminate\Auth\Events\Failed;
use Illuminate\Support\Facades\DB;
use Log;

/**
 * Class is created for student booking 
 */
class CheckoutController extends Controller
{
    protected $transactionRepository;

    protected $subscriptionRepository;

    protected $tutorSubscriptionRepository;

    protected $topUpRepository;


    /**
     * Method __construct
     *    
     * @param TransactionRepository       $transactionRepository   
     * @param SubscriptionRepository      $subscriptionRepository 
     * @param TutorSubscriptionRepository $tutorSubscriptionRepository 
     * @param TopUpRepository             $topUpRepository              
     *
     * @return void
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        SubscriptionRepository $subscriptionRepository,
        TutorSubscriptionRepository $tutorSubscriptionRepository,
        TopUpRepository $topUpRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
        $this->topUpRepository = $topUpRepository;
    }

    /**
     * Show checkout page 
     * 
     * @param Request $request [explicite description]
     * 
     * @return View
     */
    public function index(Request $request)
    {
        $params = [];
        $user = Auth::user();
        $params['user'] = $user;
        $params['itemTotal'] = 0;
        $params['totalItems'] = 0;
        $params['itemType'] = '';
        $items = [];
        if (@$request->class_id) {
            $params['totalItems'] = 1;
            $params['class_id'] = (int)Crypt::decryptString($request->class_id);
            $item = $this->transactionRepository
                ->getClass($params['class_id']);
            if (!empty($item) && ($item->class_type)) {
                $params['itemType'] = $item->class_type;
                if (!empty($item->total_fees)) {
                    $params['itemTotal'] = $item->total_fees;
                } else {
                    $params['itemTotal'] = $item->hourly_fees * ($item->duration / 60);
                }
                $item->type = 'class';
                $item->is_available = $this->checkBookingItems(
                    [
                        'item_id' => $item->id,
                        'item_type' => 'class'
                    ]
                );
                $items[] = $item;
            }
            $params['items'] = $items;
            $params['bookingType'] = 'direct_booking';
        } else if (@$request->blog_id) {
            $params['totalItems'] = 1;
            $params['blog_id'] = Crypt::decryptString($request->blog_id);
            $item = $this->transactionRepository
                ->getBlog($params['blog_id']);
            if (!empty($item)) {
                $params['itemType'] = 'blog';
                $params['itemTotal'] = $item->total_fees;
                $item->type = 'blog';
                $item->is_available = $this->checkBookingItems(
                    [
                        'item_id' => $item->id,
                        'item_type' => 'blog'
                    ]
                );
                $items[] = $item;
            }
            $params['items'] = $items;
            $params['bookingType'] = 'direct_booking';
        } else if (@$request->subscription_id) { // purchase and upgrade subscription
            $params['totalItems'] = 1;
            $params['subscription_id']
                = Crypt::decryptString($request->subscription_id);
            $params["duration"] = $request->duration;
            $item = $this->subscriptionRepository
                ->getSubscription($params['subscription_id'], $params);
            if (!empty($item)) {
                $params['itemType'] = 'subscription';
                $params['itemTotal']
                    = !empty($item) ? $item->amount : 0;
                $item->type = 'subscription';
                $items[] = $item;
            }
            $params['items'] = $items;
            $params['bookingType'] = 'direct_booking';
        } else if (@$request->top_up_id) { // Tutor purchase topUp
            $params['totalItems'] = 1;
            $params['top_up_id'] = $request->top_up_id;


            $item = $this->topUpRepository->getTopUp($request->top_up_id);
            if (!empty($item)) {
                $classAmount = 0;
                $webinarAmount = 0;
                $blogAmount = 0;
                $isFeaturedAmount = 0;
                $params['itemType'] = 'topUp';
                $params['class_hours'] = $request->class_hours;
                $params['webinar_hours'] = $request->webinar_hours;
                $params['blog_count'] = $request->blog;
                $params['is_featured'] = $request->is_featured;

                if ($request->class_hours) {
                    $classAmount
                        = $item->class_per_hours_price * $request->class_hours;
                }

                if ($request->webinar_hours) {
                    $webinarAmount
                        = $item->webinar_per_hours_price * $request->webinar_hours;
                }

                if ($request->blog) {
                    $blogAmount
                        = $item->blog_per_hours_price * $request->blog;
                }

                if ($request->is_featured) {
                    $isFeaturedAmount
                        = $item->is_featured_price * $request->is_featured;
                }

                $params['itemTotal']
                    = $classAmount + $webinarAmount + $blogAmount + $isFeaturedAmount;
                $item->type = 'topUp';
                $items[] = $item;
            }
            $params['items'] = $items;
            $params['bookingType'] = 'direct_booking';
        } else if (@$request->amount) {
            $item = [
                'type' => 'wallet'
            ];
            $items[] = $item;
            $params['itemType'] = 'wallet';
            $params['itemTotal'] = $request->amount;
            $params['bookingType'] = 'direct_booking';
            $params['totalItems'] = 1;
        } else {
            $cart = $this->getCartItems();
            $params['cart'] = $cart['cart'];
            $params['items'] = $cart['items'];
            $params['itemTotal'] = $cart['itemTotal'];
            $params['totalItems'] = $cart['totalItems'];
            $params['bookingType'] = 'cart_booking';
        }
        // get user wallet amount
        $params['walletAmount'] = Wallet::availableBalance($user->id);
        return view('frontend.checkout.index', $params);
    }

    /**
     * Get cart items 
     * 
     * @return Void
     */
    public function getCartItems()
    {
        $user = Auth::user();
        $items = [];
        $itemTotal = 0;
        $totalItems = 0;
        $cart = $this->transactionRepository->getCart($user->id);
        if (!empty($cart) && !empty($cart->items)) {
            foreach ($cart->items as $item) {
                $total = 0;
                $totalItems++;
                if (!empty($item->class_id)) {
                    $item->classWebinar->item_type = $item->classWebinar->class_type;
                    $item->classWebinar->cart_item_id = $item->id;
                    if (!empty($item->classWebinar->total_fees)) {
                        $total = $item->classWebinar->total_fees;
                    } else {
                        $total = $item->classWebinar->hourly_fees
                            * ($item->classWebinar->duration / 60);
                    }
                    $item->classWebinar->is_available = $this->checkBookingItems(
                        [
                            'item_id' => $item->classWebinar->id,
                            'item_type' => 'class'
                        ]
                    );
                    $items[] = $item->classWebinar;
                } else if (!empty($item->blog_id)) {
                    $item->blog->item_type = 'blog';
                    $item->blog->cart_item_id = $item->id;
                    $total = $item->blog->total_fees;
                    $item->blog->is_available = $this->checkBookingItems(
                        [
                            'item_id' => $item->blog->id,
                            'item_type' => 'blog'
                        ]
                    );
                    $items[] = $item->blog;
                }
                $itemTotal = $total + $itemTotal;
            }
        }
        return [
            'cart' => $cart,
            'items' => $items,
            'itemTotal' => $itemTotal,
            'totalItems' => $totalItems
        ];
    }

    /**
     * Create booking
     * 
     * @param Request $request [explicite description]
     * 
     * @return JsonResponse
     */
    public function store(Request $request)
    {
        try {

            DB::beginTransaction();
            $data = $request->all();

            $booking = [];

            if (isset($data['item_type']) && $data['item_type'] == 'subscription') {
                $data["plan_id"] = $data['item_id'];
                $data["user_id"] = Auth::user()->id;
                $booking = $this->tutorSubscriptionRepository->purchasePlan($data);
                if ($data['payment_method'] == Transaction::STATUS_WALLET) {
                    $booking['external_id'] = $booking->transaction->external_id;
                }
            } else if (isset($data['item_type']) 
                && $data['item_type'] == 'topUp'
            ) {
                $data["top_up_id"] = $data['item_id'];
                $data["user_id"] = Auth::user()->id;
                $booking = $this->tutorSubscriptionRepository->purchaseTopUp($data);
                if ($data['payment_method'] == Transaction::STATUS_WALLET) {
                    $booking['external_id'] = $booking->transaction->external_id;
                }

            } else if (isset($data['item_type']) && $data['item_type'] == 'wallet') {
                $booking = $this->transactionRepository->walletTransaction($data);
            } else {
                $booking = $this->transactionRepository->checkout($data);
            }

            DB::commit();
            return $this->apiSuccessResponse(
                $booking,
                trans('message.booking_success')
            );
        } catch (Exception $e) {
            DB::rollback();
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     *  Method checkBookingItems
     * 
     * @param $data 
     * 
     * @return Bool
     */
    public function checkBookingItems($data)
    {
        try {
            $this->transactionRepository->checkBookingItems($data);
            return array('success' => true, 'message' => '');
        } catch (Exception $e) {
            return array('success' => false, 'message' => $e->getMessage());
        }
    }

    /**
     * Method payNow
     * 
     * @param Request $request 
     * @param String  $checkoutId 
     * 
     * @return view
     */
    public function payNow(Request $request, $checkoutId)
    {
        if (isset($request->lang) && !empty($request->lang)) {
            setUserLanguage($request->get('lang'));
        }
        $itemType = $request->item;
        $card_type = $request->card_type;
        return view(
            'frontend.checkout.pay-now',
            compact('checkoutId', 'itemType', 'card_type')
        );
    }

    /**
     * Method paymentSuccess
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function paymentSuccess(Request $request)
    {
        try {
            $params = $request->all();

            $params['checkout_id'] = $params["id"];
            $checkoutId = $this->transactionRepository->getTransaction($params);
            $params['card_type'] = $checkoutId->card_type;
            
            $transaction = $this->transactionRepository->getPaymentStatus($params);
            
            if (Auth::check() && Auth::user()->isStudent()) {
                $url = route('student.transactions.index');
            } else if (Auth::check() && Auth::user()->isTutor()) {
                $url =  route('tutor.transactions.index');
            } else {
                return redirect()->route(
                    'show/login', ['status'=> $transaction->status]
                );
            }
        
            if ($transaction && $transaction->status == Transaction::STATUS_SUCCESS) {
                return view('frontend.checkout.payment-success', compact('url'));
            }
            $data = json_decode($transaction->response_data);

            $response_brand = $data->paymentBrand;
            $select_brand = $checkoutId->card_type;
            $data = ['url' => $url, 'response_brand' => $response_brand, 'select_brand' => $select_brand];
            
            return view('frontend.checkout.payment-failed', $data);
        } catch (Exception $e) {

            if (Auth::check() && Auth::user()->isStudent()) {
                $url = route('student.transactions.index');
            } else if (Auth::check() && Auth::user()->isTutor()) {
                $url =  route('tutor.transactions.index');
            } else {
                return redirect()->route(
                    'show/login', ['status'=> Transaction::STATUS_FAILED]
                );
            }
            $data = ['url' => $url, 'response_brand' => '', 'select_brand' => ''];
            return view('frontend.checkout.payment-failed', $data);
        }
    }
}

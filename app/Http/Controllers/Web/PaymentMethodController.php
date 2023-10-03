<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\PaymentMethodRepository;
use App\Repositories\TutorRepository;
use App\Http\Requests\PaymentMethod\PaymentAddCardRequest;
use App\Http\Requests\PaymentMethod\BankDetailRequest;
use Exception;
use App\Models\Transaction;
use Illuminate\Support\Facades\Auth;


/**
 * PaymentMethodController
 */
class PaymentMethodController extends Controller
{
    protected $paymentMethodRepository;
    
    protected $tutorRepository;

    /**
     * Function __construct 
     * 
     * @param PaymentMethodRepository $paymentMethodRepository 
     * @param TutorRepository $tutorRepository
     * 
     * @return void
     */
    public function __construct(PaymentMethodRepository $paymentMethodRepository,TutorRepository $tutorRepository)
    {
        $this->paymentMethodRepository = $paymentMethodRepository;
        $this->tutorRepository = $tutorRepository;
    }

    /**
     * Function index 
     * 
     * @return view
     */
    public function index()
    {
        $id = auth()->user()->id;
        $data['currentPage'] = 'paymentMethod';
        $data['tutor'] = $this->tutorRepository->getTutor($id);
        $data['banks'] = getBankName();
        return view('frontend.payment-method.payment-method', $data);
    }

    /**
     * Function store all cards
     * 
     * @param PaymentAddCardRequest $request 
     * 
     * @return void
     */
    public function store(PaymentAddCardRequest $request)
    {

        try {
            $post = $request->all();
            $expired = explode('/', $post['expired_date']);
            $post['exp_month'] = $expired[0];
            $post['exp_year'] = $expired[1];
            $post['gateway'] = isset($post["payment_gateway"]) ?
                $post["payment_gateway"] : Transaction::PAYMENT_GATEWAY_HYPERPAY;
            $results = $this->paymentMethodRepository->saveCard($post);
            if (!empty($results)) {
                return $this->apiSuccessResponse([], trans('message.add_card'));
            }
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Function delete 
     * 
     * @param Request $request 
     * @param int     $id 
     * 
     * @return void
     */
    public function delete(Request $request, $id)
    {
        try {
            $data = $request->all();
            $data['gateway'] = isset($data["payment_gateway"]) ?
                $data["payment_gateway"] : Transaction::PAYMENT_GATEWAY_HYPERPAY;
            $results = $this->paymentMethodRepository->deleteCard($data, $id);
            if (!empty($results)) {
                return $this->apiSuccessResponse([], trans('message.delete_card'));
            }
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Get list of cards
     * 
     * @param Request $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            $post['size'] = '4';
            $cardLists = $this->paymentMethodRepository->getCarts($post);
            $html = view(
                'frontend.payment-method.list',
                ['cardLists' => $cardLists]
            )->render();
            if (isset($request->type) && $request->type == 'checkout') {
                $html = view(
                    'frontend.student.checkout.card-list',
                    ['cardLists' => $cardLists]
                )->render();
            }
            return $this->apiSuccessResponse($html);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method generateCheckoutId
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function generateCheckoutId(Request $request)
    {
        $params['gateway'] = isset($request->payment_gateway)?
        $request->payment_gateway:Transaction::PAYMENT_GATEWAY_HYPERPAY;

        $checkoutId = $this->paymentMethodRepository
            ->generateCheckoutId($params);
        return redirect()
            ->route(
                'payment.method.checkout.saveCardForm',
                ["checkoutId" => $checkoutId]
            );
    }

    /**
     * Method saveCardForm
     * 
     * @param string $checkoutId 
     * 
     * @return void 
     */
    public function saveCardForm($checkoutId)
    {
        
        return view(
            'frontend.payment-method.payment-method-form',
            compact('checkoutId')
        );
    }

    public function paymentReturnUrl(Request $request) 
    {
        $params = $request->all();
        $params['gateway'] = Transaction::PAYMENT_GATEWAY_HYPERPAY;
        $this->paymentMethodRepository->getSaveCard($params);
    }

    /**
     * Function store all cards
     * 
     * @param BankDetailRequest $request 
     * 
     * @return void
     */
    public function saveBankDetail(BankDetailRequest $request)
    {
        try {
            $user = Auth::user();
            $post = $request->all();
            $results = $this->tutorRepository->updateTutor($user, $post);
            if (!empty($results)) {
                return $this->apiSuccessResponse([], trans('message.add_bank_details'));
            }
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}
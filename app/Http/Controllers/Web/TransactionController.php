<?php

namespace App\Http\Controllers\Web;

use Exception;
use App\Models\Transaction;
use App\Models\TutorPayout;
use Illuminate\Http\Request;
use App\Models\TransactionItem;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Repositories\TransactionRepository;
use App\Repositories\TutorPayoutRepository;
/**
 * Show transaction class 
 */
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
    public function __construct(TransactionRepository $transactionRepository,
        TutorPayoutRepository $tutorPayoutRepository
    ){
        $this->transactionRepository = $transactionRepository;
        $this->tutorPayoutRepository = $tutorPayoutRepository;
    }


    /**
     * Show transaction view
     * 
     * @return View 
     */
    public function index()
    {
        if (Auth::check() && Auth::user()->isTutor()) {
            $user = Auth::user();
            $calculation = TransactionItem::totalSaleCommission($user->id);
            $totalPaid = (TutorPayout::totalPayout($user->id));// + Transaction::totalFine($user->id, 1));
            $currentFine = Transaction::totalFine($user->id);
            // var_dump($calculation);
            // var_dump($currentFine);
            $totalEarning = $calculation->total_earning - $currentFine;
            $params["total_earning"] = formatAmount($totalEarning);
            $params['total_sale'] = formatAmount($calculation->total_sale);
            $params['total_paid_tutor'] = $totalPaid;
            $params['currentFine'] = $currentFine;
            $params['commission'] = $calculation->total_admin_commission;
            $params['total_due'] = formatAmount($totalEarning - $totalPaid);
        }
        $params['currentPage'] = 'myTransactions';
        // dd($params);
        return view('frontend.transaction.index', $params);
    }

    /**
     * Get list of transaction
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     *  @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            $transactions = $this->transactionRepository->getTransactions();
            $html = view(
                'frontend.transaction.list',
                ['transactions' => $transactions]
            )->render();
            return $this->apiSuccessResponse(
                $html,
                trans('message.transaction_list')
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Get payoutList of transaction
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     *  @return \Illuminate\Http\Response
     */
    public function payoutList(Request $request)
    {
        try {
            $transactions = $this->tutorPayoutRepository->getPayouts();
            $html = view(
                'frontend.transaction.payout-list',
                ['transactions' => $transactions]
            )->render();
            return $this->apiSuccessResponse(
                $html,
                trans('message.transaction_list')
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

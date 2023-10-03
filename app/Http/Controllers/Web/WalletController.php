<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Wallet;
use App\Http\Requests\Wallet\AddAmountRequest;
use App\Http\Requests\Wallet\RedeemRequest;
use App\Models\Transaction;
use App\Repositories\RewardPointsRepository;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Exception;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

/**
 * Class created for user wallet operations
 */
class WalletController extends Controller
{
    protected $transactionRepository;
    protected $walletRepository;
    protected $rewardPointsRepository;

    /**
     * Method __construct
     * 
     * @param TransactionRepository $transactionRepository  
     * @param WalletRepository      $walletRepository  
     * @param RewardPointsRepository      $rewardPointsRepository  
     *
     * @return void
     */
    public function __construct(
        TransactionRepository $transactionRepository,
        WalletRepository $walletRepository,
        RewardPointsRepository $rewardPointsRepository
    ) {
        $this->transactionRepository = $transactionRepository;
        $this->walletRepository = $walletRepository;
        $this->rewardPointsRepository = $rewardPointsRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $user = Auth::user();
        $data['currentPage'] = 'myWallet';
        $data['availableBalance'] = Wallet::availableBalance($user->id);
        $data['availablePoints'] = $this->rewardPointsRepository->userAvailablePoints($user->id);
        return view('frontend.wallet.index', $data);
    }

    /**
     * Add balance 
     * 
     * @param AddAmountRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function addBalance(AddAmountRequest $request)
    {
        try {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['transaction_id'] = rand();
            $data['status'] = 'success';
            $data['type'] = 'wallet';

            $this->transactionRepository->createTransaction($data);
            return $this->apiSuccessResponse(
                [],
                trans('message.add_payment_wallet')
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Get list of wallet transaction
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     *  @return \Illuminate\Http\Response
     */
    public function list(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $wallets = $this->walletRepository->walletHistory($userId);
            $html = view(
                'frontend.wallet.list',
                ['wallets' => $wallets]
            )->render();
            return $this->apiSuccessResponse($html, trans('message.blog_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Redeem Points
     * 
     * @param RedeemRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function redeemPoints(RedeemRequest $request)
    {
        try {
            DB::beginTransaction();
            $data = $request->all();
            if (request()->user) {
                $userId = request()->user->id;
            } else {
                $userId = auth()->user()->id;
            }
            $data['user_id'] = $userId;
            $data['type'] = 'debit';
            
            $points = $this->rewardPointsRepository->createRewardPoint($data);
            if ($points) {
                $data['transaction_id'] = rand();
                $data['status'] = Transaction::STATUS_SUCCESS;
                $data['type'] = Transaction::STATUS_WALLET;
                $data['transaction_type'] = Transaction::STATUS_REDEEMED;
                $data['amount'] = ($data['points']) / 10;
                $this->transactionRepository->createTransaction($data);
                DB::commit();
            }
            return $this->apiSuccessResponse(
                [],
                trans('message.redeem_successful')
            );
        } catch (Exception $e) {
            DB::rollback();
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }
}

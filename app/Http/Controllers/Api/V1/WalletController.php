<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\RedeemRequest;
use Illuminate\Http\Request;
use App\Http\Requests\Api\WalletRequest;
use App\Http\Resources\V1\RewardPointResource;
use App\Repositories\TransactionRepository;
use App\Repositories\WalletRepository;
use Auth;
use App\Http\Resources\V1\WalletResource;
use App\Repositories\RewardPointsRepository;
use Exception;
use Illuminate\Support\Facades\DB;
use App\Models\Transaction;

class WalletController extends Controller
{
    protected $transactionRepository;

    /**
     * Method __construct
     * 
     * @param TransactionRepository $transactionRepository  
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
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $userId = Auth::user()->id;
            $wallet = $this->walletRepository->walletHistory($userId);
            return WalletResource::collection($wallet);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\WalletRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(WalletRequest $request)
    {
        try {
            $data = $request->all();
            $wallet = $this->transactionRepository->walletTransaction($data);
            
            return $this->apiSuccessResponse(
                [
                    "checkout_url" =>
                    route(
                        'checkout.payNow',
                        ["checkoutId" => $wallet]
                    ).'?item=&card_type='.$data["card_type"]
                ]
            );
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\WalletRequest $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function redeemPoints(RedeemRequest $request)
    {
        try {
            $data = $request->all();
            $data['user_id'] = Auth::user()->id;
            $data['type'] = 'debit';
            //$data['points'] = $data['points']*-1;            
            $points = $this->rewardPointsRepository->createRewardPoint($data);
            if ($points) {
                $data['transaction_id'] = rand();
                $data['amount'] = ($data['points'])/10;
                $data['status'] = Transaction::STATUS_SUCCESS;
                $data['type'] = Transaction::STATUS_WALLET;
                $data['transaction_type'] = Transaction::STATUS_REDEEMED;
                $wallet = $this->transactionRepository->createTransaction($data);
            }
            return new WalletResource($wallet);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    
}

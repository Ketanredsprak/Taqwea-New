<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\TransactionResource;
use Illuminate\Http\Request;
use App\Repositories\TransactionRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\TransactionHistoryExport;
use Exception;


/**
 * PaymentController class
 */
class TransactionController extends Controller
{
    protected $transactionRepository;

    /**
     * Function __construct 
     * 
     * @param TransactionRepository $transactionRepository  
     * 
     * @return void
     */
    public function __construct(TransactionRepository $transactionRepository)
    {
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Function TransactionHistory
     * 
     * @return view
     */
    public function transactionHistory()
    {
        return view('admin.payment-history.transactions-history');
    }

    /**
     * Function TransactionHistoryList 
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function transactionHistoryList(Request $request)
    {
        $transaction = $this->transactionRepository
            ->getTransactions($request->all());
        return TransactionResource::collection($transaction);
    }

    /**
     * TransactionExportCsv function all student details 
     *  
     * @return void
     */
    public function transactionExportCsv(Request $request)
    {
        try {
            return Excel::download(new TransactionHistoryExport($this->transactionRepository, $request), 'transaction-history.csv');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}

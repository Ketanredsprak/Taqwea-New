<?php

namespace App\Http\Controllers\Web\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Exports\RevenueExportCsv;
use App\Repositories\TransactionRepository;
use App\Http\Resources\V1\RevenueResources;
use Maatwebsite\Excel\Facades\Excel;
use Carbon\Carbon;
use Exception;

/**
 * ReportController class
 */
class ReportController extends Controller
{
    protected $transactionRepository;

    /**
     * Function __construct
     * 
     * @param TransactionRepository $transactionRepository 
     * 
     * @return void
     */
    public function __construct(
        TransactionRepository     $transactionRepository
    ) {
        $this->transactionRepository = $transactionRepository;
    }
    /**
     * Function RevenueReport
     * 
     * @return view
     */
    public function revenueReport()
    {
        return View('accountant.reports.revenue-report');
    }

    /**
     * Function RevenueReportList
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function revenueReportList(Request $request)
    {
        try {
            $param['year'] = $request->year ? $request->year : Carbon::now()->year;
            $revenue = $this->transactionRepository->revenueReport($param);
            return RevenueResources::collection($revenue);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * RevenueExportCsv function all tutor details 
     * 
     * @param Request $request  
     * 
     * @return void
     */
    public function revenueExportCsv(Request $request)
    {
        try {
            $revenueExport = new RevenueExportCsv(
                $this->transactionRepository,
                $request
            );
            return Excel::download($revenueExport, 'revenue-reports.csv');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}

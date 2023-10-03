<?php

namespace App\Exports;

use Throwable;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Carbon\Carbon;

/**
 * TransactionHistoryExport
 */
class TransactionHistoryExport implements FromCollection, WithHeadings, ShouldAutoSize
{
    protected $transactionRepository;
    protected $request;

    /**
     * Method __construct
     *
     * @param TransactionRepository $transactionRepository [explicite description]
     * @param Request               $request               [explicite description]
     *
     * @return void
     */
    function __construct(
        $transactionRepository,
        $request
    ) {

        $this->transactionRepository = $transactionRepository;
        $this->request = $request;
    }

    /**
     * Collection all Student data
     *
     * @return \Illuminate\Support\Collection
     */
    public function collection()
    {

        $post = $this->request->all();
        $post['is_paginate'] = true;
        if (!empty($post['from_date'])) {
            $post['from_date'] = Carbon::parse($post['from_date'])->format("Y-m-d");
        }
        if (!empty($post['to_date'])) {
            $post['to_date'] = Carbon::parse($post['to_date'])->format("Y-m-d");
        }
        $users = $this->transactionRepository->getTransactions($post);

        $exports = array();

        foreach ($users as $key => $item) {
            $data['id'] = $key + 1;
            $data['transaction_id'] = ($item->external_id) ?
                '#' . ($item->external_id) : "N/A";
            $data['name'] = ($item->user()->withTrashed()->getResults()->translateOrDefault()->name) ? ucfirst($item->user()->withTrashed()->getResults()->translateOrDefault()->name) : "N/A";
            $data['total_amount'] = ($item->total_amount) ?
                config('app.currency.default') . ' ' . $item->total_amount : "0";
            $data['admin_commission'] = isset($item->transactionItems) ?
                config('app.currency.default') . ' ' .
                $item->transactionItems->sum('commission') : $item->amount;
            $data['date'] = ($item->created_at) ? $item->created_at : "N/A";
            $data['payment_status'] = ($item->status) ? (ucfirst($item->status))
                : "N/A";
            $data['payment_type'] = ($item->payment_mode) ?
                ucfirst($item->payment_mode) : "N/A";

            $exports[] = $data;
        }
        return collect($exports);
    }

    /**
     * Headings function Loading method for returning heading for excel
     *
     * @return array
     */
    public function headings(): array
    {
        return [
            'ID',
            'Transaction id',
            'Name',
            "Total Amount",
            'Admin Commission',
            'Date',
            'Payment Status',
            'Payment Type'
        ];
    }
}

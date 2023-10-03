<?php

namespace App\Exports;

use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\ShouldAutoSize;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Illuminate\Http\Request;

/**
 * RevenueExportCsv
 */
class RevenueExportCsv implements FromCollection, WithHeadings, ShouldAutoSize
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
        $post['year'] = $this->request->year ?
            $this->request->year : Carbon::now()->year;
        $classes = $this->transactionRepository->revenueReport($post);
        $exports = array();

        foreach ($classes as $key => $item) {
            $data['id'] = $key + 1;
            $data['month'] = ($item->created_at) ?
                Carbon::parse($item->created_at)->format('F') : "N/A";
            $data['subscription_sum'] = ($item->subscription_sum) ?
                $item->subscription_sum : "N/A";
            $data['class_sum'] = ($item->class_sum) ?
                $item->class_sum : "N/A";
            $data['webinar_sum'] = ($item->webinar_sum) ?
                ($item->webinar_sum) : 'N/A';
            $data['blog_sum'] = ($item->blog_sum) ? ($item->blog_sum) : 'N/A';
            $data['total_sum'] = ($item->subscription_sum) + ($item->class_sum)
                + ($item->webinar_sum) + ($item->blog_sum);


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
            'Month Name',
            'Subscription Revenue',
            'Class Revenue',
            'Webinar Revenue',
            'Blog Revenue',
            'Total Revenue'
        ];
    }
}

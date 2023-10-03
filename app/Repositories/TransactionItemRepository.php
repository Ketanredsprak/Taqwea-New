<?php

namespace App\Repositories;

use App\Models\Transaction;
use App\Models\TransactionItem;
use App\Models\User;
use App\Models\Wallet;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 * Interface Repository.
 *
 * @package TransactionItemRepository;
 */
class TransactionItemRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TransactionItem::class;
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
     * Function getItem
     *
     * @param int $id [explicite description]
     *
     * @return void
     */
    public function getItem($id)
    {
        return $this->where('id', $id)->first();
    }

    /**
     * Method getBlogs
     *
     * @param array $params
     *
     * @return Collection
     */
    public function getBogs(array $params = [])
    {
        $sortFields = [
            'id' => 'transaction_items.id',
            'student_name' => 'user_translations.name',
            'blog_name' => 'blog_translations.blog_title',
            'blog_price' => 'blogs.total_fees',
            'amount_paid' => 'transaction_items.amount',
            'created_at' => 'transaction_items.created_at',

        ];

        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->whereNotNull('transaction_items.blog_id');

        $query->select('transaction_items.*');

        $query->leftjoin(
            'user_translations',
            'user_translations.user_id',
            'transaction_items.student_id'
        )->leftjoin(
            'blog_translations',
            'blog_translations.blog_id',
            'transaction_items.blog_id'
        )->leftjoin(
            'blogs',
            'blogs.id',
            'transaction_items.blog_id'
        );

        if (Auth::check()) {
            $users = Auth::user();
            if ($users->user_type == User::TYPE_STUDENT) {
                $query->where("transaction_items.student_id", $users->id);
                $query->where("transaction_items.status", TransactionItem::STATUS_CONFIRMED);
            }
        }
        if (!empty($params['search'])) {
            $query->where(
                function ($qry) use ($params) {
                    $qry->where(
                        'blog_translations.blog_title',
                        'like',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'user_translations.name',
                        'like',
                        "%" . $params['search'] . "%"
                    )->OrWhere(
                        'transaction_items.id',
                        $params['search']
                    );
                }
            );
        }

        if (!empty($params['start_time'])) {
            $query->whereDate(
                'transaction_items.created_at',
                '>=',
                $params['start_time']
            );
        }

        if (!empty($params['end_time'])) {
            $query->whereDate(
                'transaction_items.created_at',
                '<=',
                $params['end_time']
            );
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }
        $query->groupBy("transaction_items.id");
        $query->orderBy($sort, $direction);

        return $query->paginate($size);
    }

    /**
     * Method update transaction item
     *
     * @param array $param
     *
     * @return Object
     */
    public function cancelTransactionItem(array $bookingItem = [])
    {
        $transactionItem = $this->where(
            [
                'student_id' => $bookingItem['student_id'],
                'class_id' => $bookingItem['class_id'],
                'status' => TransactionItem::STATUS_CONFIRMED,
            ]
        )->first();

        if ($transactionItem) {

            $refundData = $this->checkCancellationPolicy($transactionItem, $bookingItem);
            if (!empty($refundData)
                && $refundData['refund_type'] == User::TYPE_STUDENT
            ) {

                $transactionItem
                    ->update(['status' => TransactionItem::STATUS_REFUND]);

                $walletData = [
                    'user_id' => $refundData['user_id'],
                    'amount' => $refundData['amount'],
                    'type' => Wallet::STATUS_CREDIT,
                ];
                $walletData = Wallet::create($walletData);

                if ($walletData) {
                    $transactionData = [
                        'external_id' => getExternalId(),
                        'user_id' => $refundData['user_id'],
                        'payment_mode' => Transaction::STATUS_WALLET,
                        'total_amount' => $refundData['amount'],
                        'amount' => $refundData['amount'],
                        'transaction_type' => Transaction::STATUS_ADD_TO_REFUND,
                        'admin_commision' => 0,
                        'vat' => !empty($refundData['vat']) ? $refundData['vat'] : 0,
                        'transaction_fees' => !empty($refundData['transactionFees']) ? $refundData['transactionFees'] : 0,
                        'wallet_amount' => $refundData['amount'],
                        'status' => Transaction::STATUS_REFUNDED,
                        'wallet_id' => $walletData->id,
                    ];
                    $transaction = Transaction::create($transactionData);
                    if ($transaction) {
                        return true;
                    }
                    return false;
                }
            } else if ($refundData['refund_type'] == User::TYPE_TUTOR) {
                $transactionItem->update(
                    [
                        'amount' => $refundData['amount'],
                        'commission' => $refundData['commission'],
                    ]
                );
            }
            return true;
        }
    }

    /**
     * Method checkPurchased
     *
     * @param int $student_id
     * @param int $blog_id
     *
     * @return Array
     */
    public function checkPurchased($student_id, $blog_id)
    {
        $where['student_id'] = $student_id;

        if ($blog_id) {
            $where['blog_id'] = $blog_id;
        }

        return $this->where($where)->whereIn(
            'status',
            [TransactionItem::STATUS_CONFIRMED, TransactionItem::STATUS_REFUND]
        )->first();
    }

    /**
     * Method checkCancellationPolicy
     *
     * @param object $transactionItem
     * @param array  $bookingItem
     *
     * @return Array
     */
    public function checkCancellationPolicy($transactionItem, $bookingItem)
    {

        $refundData = array();
        $accountant = '';

        if (Auth::check()) {
            $accountant = Auth::user()->user_type;
        }

        if ($accountant == User::TYPE_ACCOUNTANT) {
            $refundData = calculationRefundAmount($transactionItem);
            $refundData['user_id'] = $transactionItem->student_id;
            $refundData['refund_type'] = User::TYPE_STUDENT;
        } else {
            $classCancelTime = config('services.class_cancel_before');
           
            $currentTime = Carbon::parse($bookingItem['current_time'])
                ->addMinutes($classCancelTime);

            $classBeforOneHrsTime = Carbon::parse($bookingItem['class_time'])
                ->subMinutes(60);

            if ($bookingItem['user_type'] == User::TYPE_STUDENT
                && ($bookingItem['current_time'] >= $classBeforOneHrsTime)
                && ($bookingItem['class_time'] >= $bookingItem['current_time'])
            ) {
                $tutorAmount = ($transactionItem->total_amount * 50) / 100;
                $refundData['refund_type'] = User::TYPE_TUTOR;
                $refundData['item_id'] = $transactionItem->id;
                $refundData['amount'] = $tutorAmount;
                $refundData['commission'] = $transactionItem->total_amount - $tutorAmount;
            } elseif ((strtotime($currentTime) >= strtotime($classBeforOneHrsTime)) && strtotime($bookingItem['class_time']) >= strtotime($currentTime)) {
                $refundData = calculationRefundAmount($transactionItem);
                $refundData['user_id'] = $transactionItem->student_id;
                $refundData['refund_type'] = User::TYPE_STUDENT;
            } else {
                $refundData = calculationRefundAmount($transactionItem);
                $refundData['user_id'] = $transactionItem->student_id;
                $refundData['refund_type'] = User::TYPE_STUDENT;
            }
        }
        
        return $refundData;
    }

    /**
     * Function DashboardClassCount
     *
     * @param $request [explicite description]
     *
     * @return object
     */
    public function dashboardClassCount($request)
    {
        $query = $this->select(
            'transaction_items.id',
            'transaction_items.created_at',
            DB::raw(
                "DATE_FORMAT(transaction_items.created_at, '%m') as month"
            ),
            DB::raw(
                "sum(transaction_items.commission) as class_sum"
            )
        )->Join(
            'class_webinars',
            'transaction_items.class_id',
            'class_webinars.id'
        )->where('transaction_items.status', 'confirm')
            ->where('class_webinars.class_type', 'class')
            ->whereYear('transaction_items.created_at', $request->data);

        $query = $query->groupBy(
            DB::raw("month")
        )->get();

        $userCollection = collect($query);
        $userfilter = [];
        $class = [];

        for ($i = 1; $i <= 12; $i++) {
            $userfilter = $userCollection->where('month', $i)->first();

            if (!empty($userfilter->class_sum)) {
                array_push($class, floatval(number_format($userfilter->class_sum, 2, '.', '')));
            } else {
                array_push($class, 0);
            }
        }
        return $class;
    }

    /**
     * Function DashboardWebinarCount
     *
     * @param $request [explicite description]
     *
     * @return object
     */
    public function dashboardWebinarCount($request)
    {
        $query = $this->select(
            'transaction_items.id',
            'transaction_items.created_at',
            DB::raw(
                "sum(commission) as webinars_sum"
            ),
            DB::raw(
                "DATE_FORMAT(transaction_items.created_at, '%m') as month"
            )
        )->leftJoin(
            'class_webinars',
            'class_webinars.id',
            'transaction_items.class_id'
        )->where('transaction_items.status', 'confirm')
            ->where('class_webinars.class_type', 'webinar')
            ->whereYear('transaction_items.created_at', $request->data);

        $query = $query->groupBy(
            DB::raw("month")
        )->get();

        $userCollection = collect($query);
        $userfilter = [];
        $webinar = [];

        for ($i = 1; $i <= 12; $i++) {
            $userfilter = $userCollection->where('month', $i)->first();

            if (!empty($userfilter->webinars_sum)) {
                array_push($webinar, floatval(number_format($userfilter->webinars_sum, 2, '.', '')));
            } else {
                array_push($webinar, 0);
            }
        }

        return $webinar;
    }

    /**
     * Function DashboardBlogCount
     *
     * @param $request [explicite description]
     *
     * @return object
     */
    public function dashboardBlogCount($request)
    {
        $query = $this->select(
            'transaction_items.blog_id',
            'transaction_items.created_at',
            DB::raw(
                "sum(commission) as blog_sum"
            ),
            DB::raw(
                "DATE_FORMAT(transaction_items.created_at, '%m') as month"
            )
        )->leftJoin(
            'blogs',
            'blogs.id',
            'transaction_items.blog_id'
        )->where('transaction_items.status', 'confirm')
            ->whereYear('transaction_items.created_at', $request->data)
            ->where('transaction_items.blog_id', '!=', null);

        $query = $query->groupBy(
            DB::raw("month")
        )->get();

        $userCollection = collect($query);
        $userfilter = [];
        $blog = [];

        for ($i = 1; $i <= 12; $i++) {
            $userfilter = $userCollection->where('month', $i)->first();

            if (!empty($userfilter->blog_sum)) {
                array_push($blog, floatval(number_format($userfilter->blog_sum, 2, '.', '')));
            } else {
                array_push($blog, 0);
            }
        }
        return $blog;
    }

    /**
     * Function ClassRefundRequest
     *
     * @param array $refundItem
     *
     * @return Object
     */
    public function classRefundRequest(array $refundItem = [])
    {
        $transactionItem = $this->where(
            [
                'student_id' => $refundItem['student_id'],
                'class_id' => $refundItem['class_id'],
                'status' => TransactionItem::STATUS_CONFIRMED,
            ]
        )->first();
        if ($transactionItem) {
            $transactionItem->update(['status' => TransactionItem::STATUS_REFUND]);
            $refundAmount = calculationRefundAmount($transactionItem);
            $walletData = [
                'user_id' => $refundItem['student_id'],
                'amount' => $refundAmount['amount'],
                'type' => Wallet::STATUS_CREDIT,
            ];
            $walletData = Wallet::create($walletData);
            if ($walletData) {
                $transactionData = [
                    'external_id' => getExternalId(),
                    'user_id' => $refundItem['student_id'],
                    'payment_mode' => Transaction::STATUS_WALLET,
                    'total_amount' => $refundAmount['amount'],
                    'amount' => $transactionItem->total_amount,
                    'transaction_type' => Transaction::STATUS_ADD_TO_REFUND,
                    'admin_commision' => 0,
                    'vat' => $refundAmount['vat'],
                    'transaction_fees' => $refundAmount['transactionFees'],
                    'status' => Transaction::STATUS_REFUNDED,
                    'wallet_id' => $walletData->id,
                ];
                $transaction = Transaction::create($transactionData);
                if ($transaction) {
                    return true;
                }
                return false;
            }
        }
    }

    /**
     * Function GetEarningList
     *
     * @param int   $tutorId 
     * @param array $params 
     *
     * @return void
     */
    public function getEarningList(int $tutorId, array $params = [])
    {
        $sortFields = [
            'id' => 'id',
            'booking_count' => 'booking_count',
            'booking_amount' => 'booking_amount',
            'admin_commission' => 'admin_commission',
            'total_refund' => 'total_refund',
            'final_earning' => 'final_earning',
        ];

        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->select(
            'transaction_items.id',
            'transaction_items.class_id',
            'transaction_items.blog_id',
            'transactions.amount as fine_amount',
            DB::raw("count(transaction_items.class_id)+count(blog_id) as booking_count"),
            DB::raw("sum(if ( transaction_items.status = 'confirm', transaction_items.total_amount, 0 )) as booking_amount"),
            DB::raw("sum(if ( transaction_items.status = 'refund', transaction_items.total_amount, 0 )) as total_refund"),
            DB::raw("sum(if ( transaction_items.status = 'confirm', transaction_items.commission, 0 )) as admin_commission"),
            DB::raw("sum(if ( transaction_items.status = 'confirm', transaction_items.total_amount, 0 ))-sum(if ( transaction_items.status = 'confirm', commission, 0 )) as final_earning"),
        )->leftJoin(
            'transactions', function ($join) {
                $join->on('transactions.class_id', '=', 'transaction_items.class_id')
                    ->where('transactions.status', Transaction::STATUS_SUCCESS)
                    ->where('transactions.transaction_type', Transaction::STATUS_FINE)
                    ->where('transactions.is_fine_collected', 0);
            }
        )
        ->groupBy('blog_id', 'transaction_items.class_id')->where(
            function ($q) use ($tutorId) {
                $q->whereHas(
                    'classWebinar',
                    function ($q) use ($tutorId) {
                        $q->where('tutor_id', $tutorId);
                    }
                )->orWhereHas(
                    'blog',
                    function ($q) use ($tutorId) {
                        $q->where('tutor_id', $tutorId);
                    }
                );
            }
        )->with('classWebinar', 'blog');
        $sort = $sortFields['id'];
        $direction = 'desc';
     
        if (array_key_exists('sortColumn', $params)) {   
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }
        $query->orderBy($sort, $direction);

        return $query->paginate($size);
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class TransactionItem extends Model
{
    public const STATUS_CONFIRMED = "confirm";
    public const STATUS_PENDING = "pending";
    public const STATUS_REFUND = "refund";
    public const STATUS_FAILED = "failed";

    protected $fillable = [
        'transaction_id', 'student_id',
        'class_id', 'blog_id',
        'amount', 'status', 'commission', 'total_amount','class_request_id'
    ];


    /**
     * Method transaction
     *
     * @return mixed
     */
    public function transaction()
    {
        return $this->belongsTo(
            Transaction::class,
            'transaction_id',
            'id'
        );
    }

    /**
     * Method classWebinar
     *
     * @return mixed
     */
    public function classWebinar()
    {
        return $this->belongsTo(
            ClassWebinar::class,
            'class_id',
            'id'
        );
    }

    /**
     * Method blog
     *
     * @return mixed
     */
    public function blog()
    {
        return $this->belongsTo(
            Blog::class,
            'blog_id',
            'id'
        )->withTrashed();
    }

    /**
     * Method student
     *
     * @return mixed
     */
    public function student()
    {
        return $this->belongsTo(
            User::class,
            'student_id',
            'id'
        );
    }

    /**
     * Method isPurchased
     *
     * @param int $userId
     * @param int $classId
     * @param int $blogId
     *
     * @return bool
     */
    public static function isPurchased($userId, $classId = '', $blogId = ''): bool
    {
        $where['student_id'] = $userId;

        if ($classId) {
            $where['class_id'] = $classId;
        }

        if ($blogId) {
            $where['blog_id'] = $blogId;
        }

        $result = self::where($where)
            ->whereIn(
                "status",
                [self::STATUS_CONFIRMED, self::STATUS_REFUND]
            )
            ->count();
        if (!empty($result)) {
            return true;
        }
        return false;
    }

    /**
     * Function Total Earning
     *
     * @param int $tutorId
     *
     * @return float
     */
    public static function totalEarning($tutorId)
    {
        $query = self::where(
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
        )->where('status', TransactionItem::STATUS_CONFIRMED)->sum('amount');

        return  str_replace(',', '', number_format($query, 2));
    }
    /**
     * Method totalSaleCommission for calculation tutor total sales, total admin commission and total tutor earning
     *
     * @param int $tutorId
     *
     * @return response
     */
    public static function totalSaleCommission($tutorId)
    {
        $query = self::select(
            DB::raw("SUM(amount) as total_earning"),
            DB::raw("SUM(commission) as total_admin_commission"),
            DB::raw("SUM(total_amount) as total_sale"),
        )
            ->where(
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
            )->where('status', TransactionItem::STATUS_CONFIRMED)->first();

        return $query;
    }

    /**
     * Function TotalEarningHistory
     *
     * @param $tutorId
     *
     * @return response
     */
    public static function totalEarningHistory($tutorId)
    {
        $query = self::select(
            DB::raw("count(class_id)+count(blog_id) as booking_count"),
            DB::raw("sum(if ( status = 'confirm', total_amount, 0 )) as booking_amount"),
            DB::raw("sum(if ( status = 'refund', total_amount, 0 )) as total_refund"),
            DB::raw("sum(if ( status = 'confirm', commission, 0 )) as admin_commission")
        )->where(
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
        )->first();
        return $query;
    }
    
    /**
     * Method studentPurchases
     *
     * @param $studentId int
     * @param $type      string
     *
     * @return count
     */
    public static function studentPurchases($studentId, $type = 'blog')
    {
        $query = self::where('student_id', $studentId)
            ->where(
                function ($q) use ($type) {
                    if ($type == 'blog') {
                        $q->whereNotNull('blog_id');
                    } elseif (in_array($type, ['webinar', 'class'])) {
                        $class = ($type == 'class') ? ClassWebinar::TYPE_CLASS : ClassWebinar::TYPE_WEBINAR;
                        $q->whereHas(
                            'classWebinar',
                            function ($q) use ($class) {
                                $q->where('class_type', $class);
                            }
                        );
                    }
                }
            )
            ->where('status', TransactionItem::STATUS_CONFIRMED)
            ->count();

        return  $query;
    }
}

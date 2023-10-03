<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassBooking extends Model
{
    public const STATUS_CONFIRMED = "confirm";
    public const STATUS_PENDING = "pending";
    public const STATUS_CANCELLED = "cancel";
    public const STATUS_COMPLETED = "complete";
    public const JOINED = "joined";
    public const BOOKING = "booking";
    public const STATUS_FAILED = "failed";

    protected $fillable = [
        'class_id', 'student_id', 'status', 'cancelled_by', 'is_joined',
        'is_extra_hour', 'parent_id', 'transaction_id'
    ];

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
     * Method class
     *
     * @return mixed
     */
    public function class()
    {
        return $this->belongsTo(
            ClassWebinar::class,
            'class_id',
            'id'
        );
    }

    /**
     * Method class
     *
     * @return mixed
     */
    public function rating()
    {
        return $this->belongsTo(RatingReview::class, 'student_id', 'to_id');
    }


    /**
     * Method cancelledBy
     *
     * @return mixed
     */
    public function cancelledBy()
    {
        return $this->belongsTo(
            User::class,
            'cancelled_by',
            'id'
        );
    }

    /**
     * Method cancelledBy
     *
     * @return mixed
     */
    public function transactionItem()
    {
        return $this->belongsTo(
            TransactionItem::class,
            'class_id',
            'class_id'
        );
    }

    /**
     * Method bookingClassesCount
     *
     * @param int $studentId 
     * 
     * @return int
     */
    public static function bookingClassesCount(
        int $studentId
    ): int {
        return self::where('student_id', $studentId)
            ->count();
    }
}

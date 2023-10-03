<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RaiseHand extends Model
{
    public const STATUS_ACCEPT = "accept";
    public const STATUS_REJECT = "reject";
    public const STATUS_PENDING = "pending";
    public const STATUS_COMPLETE = "complete";

    public static $statusList = [
        self::STATUS_ACCEPT => 'Accept',
        self::STATUS_REJECT => 'Reject',
        self::STATUS_PENDING => 'Pending',
        self::STATUS_COMPLETE => 'Complete',
    ];

    protected $fillable = [
        'student_id', 'class_id', 'status'
    ];

    /**
     * Method category
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
}

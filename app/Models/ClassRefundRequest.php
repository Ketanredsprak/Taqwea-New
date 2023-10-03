<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassRefundRequest extends Model
{
    public const STATUS_CANCEL = "cancel";
    public const STATUS_PENDING = "pending";
    public const STATUS_REFUND = "refund";

    protected $fillable = ['dispute_reason', 'class_id', 'user_id', 'status', 'cancel_reason'];

    /**
     * Method classes
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
     * Method classes
     * 
     * @return mixed
     */
    public function student()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    /**
     * Method transaction
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
}

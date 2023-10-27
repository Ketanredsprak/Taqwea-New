<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Transaction extends Model
{
    protected $fillable = [
        'external_id', 'user_id',
        'amount', 'payment_mode',
        'wallet_id', 'transaction_type',
        'class_id', 'blog_id', 'status',
        'total_amount', 'wallet_amount',
        'admin_commision', 'vat', 'transaction_fees', 'response_data',
        'checkout_id', 'card_type', 'booking_by', 
        'is_fine_collected', 'class_id','class_request_id'
    ];

    public const PAYMENT_GATEWAY_HYPERPAY = "hyperpay";
    public const STATUS_WALLET = "wallet";
    public const STATUS_ADD_TO_WALLET = "add_to_wallet";
    public const STATUS_REFUNDED = "refunded";
    public const STATUS_DIRECT_PAYMENT = "direct_payment";
    public const STATUS_REDEEMED = "redeem";
    public const STATUS_SUCCESS = "success";
    public const STATUS_ADD_TO_REFUND = "refund";
    public const STATUS_SUBSCRIPTION = "subscription";

    public const STATUS_FINE = "fine";
    public const NEW_CARD = "new_card";
    public const RECURRING_PAYMENT = "recurring_payment";
    public const TOP_UP = "top_up";
    public const STATUS_PENDING = "pending";
    public const STATUS_FAILED = "failed";
    public const STATUS_BOOKING = "booking";
    public const STATUS_EXTRA_HOURS= "extra_hours";
    public const BOOKING_BY_CART= "cart";

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
        );
    }

    /**
     * Method blog
     *
     * @return mixed
     */
    public function user()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }


    /**
     * Method transactionItems
     * 
     * @return mixed 
     */
    public function transactionItems()
    {
        return $this->hasMany(
            TransactionItem::class,
            'transaction_id',
            'id'
        );
    }

    /**
     * Function Total Fine
     *
     * @param int $tutorId
     * @param int $fine_collected
     *
     * @return float
     */
    public static function totalFine($tutorId, $fine_collected = 0)
    {
        $query = self::where('user_id', $tutorId)
            ->where('status', self::STATUS_SUCCESS)
            ->where('transaction_type', self::STATUS_FINE)
            ->where('is_fine_collected', $fine_collected)
            ->sum('amount');

        return  str_replace(',', '', number_format($query, 2));
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Class TutorSubscription
 */
class TutorSubscription extends Model
{
    public const ACTIVE = 'active';

    public const INACTIVE = 'inactive';

    protected $fillable = [
        'blog', 'commission', 'featured', 'webinar_hours', 'class_hours',
        'allow_booking', 'allow_booking', 'status',
        'user_id', 'subscription_id', 'subscription_name', 'start_date',
        'end_date', 'transaction_id', 'plan_duration', 'blog_commission',
        'payment_method_id', 'card_id', 'card_type'
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
     * Method tutor
     * 
     * @return mixed
     */
    public function tutor()
    {
        return $this->belongsTo(
            User::class,
            'user_id',
            'id'
        );
    }

    /**
     * Method paymentMethod
     * 
     * @return mixed
     */
    public function paymentMethod()
    {
        return $this->belongsTo(
            PaymentMethod::class,
            'payment_method_id',
            'id'
        );
    }

    /**
     * Method subscription
     * 
     * @return mixed
     */
    public function subscription()
    {
        return $this->belongsTo(
            Subscription::class,
            'subscription_id',
            'id'
        );
    }

    /**
     * Method TutorActivePlan
     * 
     * @param $userId 
     *  
     * @return Object
     */
    public static function tutorActivePlan($userId)
    {
        return self::where('user_id', $userId)
            ->where("status", self::ACTIVE)
            ->first();
       
    }

    /**
     * Method getPlanByTransactionId
     * 
     * @param $transactionId 
     *  
     * @return Object
     */
    public static function getPlanByTransactionId($transactionId)
    {
        return self::where('transaction_id', $transactionId)
            ->first();
       
    }
}

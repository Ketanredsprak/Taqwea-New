<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorPayout extends Model
{
    protected $fillable = ['tutor_id', 'transaction_id', 'amount', 'status', 'payout_response', 'account_number'];

    public const STATUS_SUCCESS = "success";

    /**
     * Function totalPayout 
     * 
     * @param int $tutorId  
     * 
     * @return float
     */
    public static function totalPayout($tutorId)
    {
        $query = self::where('status', self::STATUS_SUCCESS)->where('tutor_id', $tutorId)->sum('amount');
        return  str_replace(',','',number_format($query, 2));
    }
}

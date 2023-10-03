<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RewardPoint extends Model
{

    public const TYPE_DEBIT = 'debit';
    public const TYPE_CREDIT = 'credit';
    public const TYPE_REVERT = 'revert';
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'points', 'type'
    ];
    
    /**
     * Method getUserPoints
     *
     * @param int $userId [explicite description]
     *
     * @return int
     */
    public static function getUserPoints(int $userId):int
    {
        return self::where('user_id', $userId)->sum('points');
    }

    /**
     * Method getMonthPoints
     *
     * @param $date [explicite description]
     *
     * @return int
     */
    public static function getMonthPoints($date):int
    {
        return self::whereYear('created_at', $date)
            ->where('type', 'debit')
            ->whereMonth('created_at', $date)
            ->sum('points');
    }
}

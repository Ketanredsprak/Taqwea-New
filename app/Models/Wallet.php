<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Wallet extends Model
{
    protected $fillable = [
        'user_id', 'amount', 'type'
    ];

    public const STATUS_CREDIT = "credit";

    /**
     * Method transaction
     * 
     * @return mixed
     */
    public function transaction()
    {
        return $this->hasOne(
            Transaction::class,
            'wallet_id',
            'id'
        );
    }

    /**
     * Get user available wallet balance
     * 
     * @param $userId 
     *  
     * @return String
     */
    public static function availableBalance($userId):string
    {
        $balance = "0.0";
        $wallet = self::where('user_id', $userId)->sum('amount');
        if (!empty($wallet)) {
            $balance = $wallet;
        }
        return $balance;
    }
}

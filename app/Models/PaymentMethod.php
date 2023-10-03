<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * PaymentMethod 
 */
class PaymentMethod extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'card_id', 'brand', 'exp_month',
        'exp_year', 'card_number', 'card_holder_name'
    ];
}

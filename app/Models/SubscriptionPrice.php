<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubscriptionPrice extends Model
{
    protected $fillable = [
        'amount', 'duration', 'subscription_id'
    ];
}

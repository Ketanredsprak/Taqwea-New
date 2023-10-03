<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Setting extends Model
{
    public const AVAILABLE_SETTINGS = [
        'vat',
        'transaction_fee',
        'commission',
        'google_link',
        'app_store_link',
        'facebook_link',
        'twitter_link',
        'youtube_link',
        'instagram_link',
        'phone_number'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'setting_key', 'setting_value'
    ];
}

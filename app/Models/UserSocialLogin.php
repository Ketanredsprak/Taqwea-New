<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserSocialLogin extends Model
{
    public const PROVIDER_APPLE = 'apple';
    public const PROVIDER_GOOGLE = 'google';
    public const PROVIDER_TWITTER = 'twitter';

    public static $providers = [
        self::PROVIDER_APPLE,
        self::PROVIDER_GOOGLE,
        self::PROVIDER_TWITTER,
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'social_id', 'social_type'
    ];

    /**
     * Method user
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
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserDevice extends Model
{
    public const CERTIFICATION_DEV = 'development';

    public const TYPE_WEB = 'web';
    public const TYPE_ANDROID = 'android';
    public const TYPE_IOS = 'ios';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id', 'device_id', 'device_type', 'certification_type', 'access_token',
    ];
}

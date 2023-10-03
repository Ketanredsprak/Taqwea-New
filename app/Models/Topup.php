<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * TopUp Class
 */
class Topup extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'class_per_hours_price', 'webinar_per_hours_price', 'blog_per_hours_price',
        'is_featured_price'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

/**
 * Class Subscription
 */
class Subscription extends Model implements TranslatableContract
{
    use Translatable;
    use SoftDeletes;

    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';
    public const RECURRING = 'recurring';
    public $translatedAttributes = ['subscription_name', 'subscription_description'];
    protected $fillable = [
        'blog', 'commission', 'featured', 'webinar_hours', 'class_hours',
        'allow_booking', 'status', 'default_plan', 'amount', 'duration', 'blog_commission'
    ];

    
    /**
     * Method activePlan
     *
     * @return mixed
     */
    public function activePlan()
    {
        return $this->hasOne(
            TutorSubscription::class,
            'subscription_id',
            'id'
        );
    }
}

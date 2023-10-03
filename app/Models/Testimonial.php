<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * Testimonial Model
 */
class Testimonial extends Model implements TranslatableContract
{
    use Translatable;

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    public $translatedAttributes = ['name', 'content'];

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['name', 'content', 'testimonial_file', 'rating'];

    protected $appends = [
        'testimonial_image_url'
    ];

    /** 
     * Method getTestimonialImageUrlAttribute
     *
     * @return string
     */
    public function getTestimonialImageUrlAttribute()
    {
        return getImageUrl($this->testimonial_file);
    }
}

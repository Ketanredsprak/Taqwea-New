<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
class Tutor extends Model
{
    
    protected $fillable = [
        'user_id', 'experience', 'introduction_video', 'id_card', 'is_featured',
        'reject_reason', 'blog', 'allow_booking', 'class_hours', 'webinar_hours',
        'is_featured_end_date', 'beneficiary_name', 'account_number','bank_code', 'address'
    ];

    protected $appends = [
        'introduction_video_url', 'id_card_url', 'introduction_video_thumb'
    ];

    /** 
     * Method getProfileImageUrlAttribute
     *
     * @return string
     */
    public function getIntroductionVideoUrlAttribute()
    {
        return getImageUrl($this->introduction_video);
    }

    /** 
     * Method getProfileImageUrlAttribute
     *
     * @return string
     */
    public function getIntroductionVideoThumbAttribute()
    {
        return getThumbnailUrl($this->introduction_video, 'video');
    }


    /** 
     * Method getIdCardUrlAttribute
     *
     * @return string
     */
    public function getIdCardUrlAttribute()
    {
        return getImageUrl($this->id_card);
    }
}

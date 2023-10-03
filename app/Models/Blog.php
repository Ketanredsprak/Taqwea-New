<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
use Illuminate\Database\Eloquent\SoftDeletes;

class Blog extends Model implements TranslatableContract
{
    use Translatable;
    use SoftDeletes;

    public const TYPE_IMAGE = 'image';
    public const TYPE_DOCUMENT = 'document';
    public const TYPE_VIDEO = 'video';
    public const ACTIVE = 'active';
    public const INACTIVE = 'inactive';
    public const BLOG_TYPE = "blog";

    
    public $translatedAttributes = ['blog_title', 'blog_description'];
    protected $fillable = [
        'tutor_id', 'category_id', 'level_id', 'grade_id', 'total_fees',
        'media', 'type', 'slug', 'subject_id', 'status'
    ];

    protected $appends = [
        'media_url', 'media_thumb_url'
    ];

    /** 
     * Method getMediaUrlAttribute
     *
     * @return string
     */
    public function getMediaUrlAttribute()
    {
        return getImageUrl($this->media, '', "private");
    }

    /** 
     * Method getMediaUrlAttribute
     *
     * @return string
     */
    public function getMediaThumbUrlAttribute()
    {
        return getThumbnailUrl($this->media, $this->type);
    }

    /**
     * Method tutor
     *
     * @return mixed
     */
    public function tutor()
    {
        return $this->belongsTo(
            User::class,
            'tutor_id',
            'id'
        );
    }

    /**
     * Method category
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'id'
        );
    }

    /**
     * Method grade
     *
     * @return mixed
     */
    public function grade()
    {
        return $this->belongsTo(
            Grade::class,
            'grade_id',
            'id'
        );
    }

    /**
     * Method level
     *
     * @return mixed
     */
    public function level()
    {
        return $this->belongsTo(
            Category::class,
            'level_id',
            'id'
        );
    }

    /**
     * Method subject
     *
     * @return mixed
     */
    public function subject()
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id',
            'id'
        );
    }

    /**
     * Method blogCount
     *
     * @param int $tutorId 
     * 
     * @return int
     */
    public static function blogCount(
        int $tutorId
    ): int {
        return self::where('tutor_id', $tutorId)
            ->count();
    }

    /**
     *  Method cartItem
     * 
     * @return mixed
     */
    public function cartItem()
    {
        return $this->belongsTo(
            CartItem::class,
            'id',
            'blog_id'
        );
    }
}

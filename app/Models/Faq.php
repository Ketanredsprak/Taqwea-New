<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * Faq class
 */
class Faq extends Model implements TranslatableContract
{
    use Translatable;

    public const TYPE_IMAGE = 'image';
    public const TYPE_DOCUMENT = 'document';
    public const TYPE_VIDEO = 'video';
    public const TYPE_TEXT = 'text';

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    public $translatedAttributes = ['question', 'content'];

    /**
     * The attributes that are mass assignable
     *
     * @var array
     */
    protected $fillable = ['question', 'content', 'faq_file', 'type'];

    protected $appends = [
        'faq_file_url', 'faq_thumb_url'
    ];

    /**
     * Method faqTranslations
     * 
     * @return Illuminate\Database\Eloquent\Concerns hasMany 
     */
    public function faqTranslations()
    {
        return $this->hasMany(
            FaqTranslation::class,
            'faq_id',
            'id'
        )->orderBy('id', 'ASC');
    }

    /** 
     * Method getFaqFileUrlAttribute
     *
     * @return string
     */
    public function getFaqFileUrlAttribute()
    {
        return getImageUrl($this->faq_file);
    }

    /** 
     * Method getFaqUrlAttribute
     *
     * @return string
     */
    public function getFaqThumbUrlAttribute()
    {
        return getThumbnailUrl($this->faq_file, $this->type);
    }
}

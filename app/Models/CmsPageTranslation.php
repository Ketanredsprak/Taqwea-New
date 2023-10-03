<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * CmsPageTranslation class
 */
class CmsPageTranslation extends Model
{
    protected $fillable = [
        'page_title', 'page_content', 'meta_title', 'meta_keywords',
        'meta_description','language'
    ];
}

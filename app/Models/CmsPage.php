<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * CmsPage class
 */
class CmsPage extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = [
        'page_title', 'page_content', 'meta_title', 'meta_keywords',
        'meta_description', 'language'
    ];
    protected $fillable = ['slug', 'created_by', 'updated_by'];

}

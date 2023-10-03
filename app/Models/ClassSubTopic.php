<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;
class ClassSubTopic extends Model implements TranslatableContract
{
    use Translatable;
    
    public $translatedAttributes = [
        'sub_topic'
    ];

    protected $fillable = [
        'class_topic_id'
    ];
}

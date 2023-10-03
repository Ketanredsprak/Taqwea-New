<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassTopicTranslation extends Model
{
    protected $fillable = [
        'topic_title', 'topic_description'
    ];
}

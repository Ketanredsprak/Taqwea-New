<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

class ClassTopic extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = [
        'topic_title', 'topic_description'
    ];

    protected $fillable = [
        'class_id', 'topic_title', 'topic_description'
    ];

    /**
     * Method subTopics
     *
     * @return mixed
     */
    public function subTopics()
    {
        return $this->hasMany(
            ClassSubTopic::class,
            'class_topic_id',
            'id'
        );
    }
}

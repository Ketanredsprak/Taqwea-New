<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassWebinarTranslation extends Model
{
    protected $fillable = [
        'class_name', 'class_description', 'class_detail'
    ];
}

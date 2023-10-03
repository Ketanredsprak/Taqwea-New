<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Translatable;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
class Grade extends Model implements TranslatableContract
{
    use Translatable;

    public $translatedAttributes = ['grade_name'];

    protected $fillable = ['id', 'grade_name'];
}

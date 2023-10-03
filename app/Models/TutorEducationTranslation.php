<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class TutorEducationTranslation extends Model
{
    protected $fillable = ['tutor_id', 'degree', 'university'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectTranslation extends Model
{
    protected $fillable = ['subject_name', 'subject_id', 'language'];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class UserGeneralKnowledge extends Model
{
    protected $table = "user_general_knowledges";
    protected $fillable = ['user_id', 'category_id'];
}

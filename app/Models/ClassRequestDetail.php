<?php

namespace App\models;

use Illuminate\Database\Eloquent\Model;

class ClassRequestDetail extends Model
{
    //
    protected $table = 'class_request_detail';
    protected $fillable = ['user_id,status,date,start_time,end_time,class_request_id'];
}

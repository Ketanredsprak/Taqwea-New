<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;


class TutorRequest extends Model
{
    //
    protected $table = 'tutor_requests';

    protected $fillable = [
        'id',
        'class_request_id',
        'tutor_id',
        'user_id',
        'status',
    ];

    public function classrequest(){
        return $this->hasOne(ClassRequest::class, 'id', 'class_request_id');
    }

    public function userdata(){
        return $this->hasOne(User::class, 'id', 'user_id');
    }

    public function classrequestdetail(){
        return $this->hasOne(ClassRequestDetail::class, 'id', 'class_request_id');
    }





}

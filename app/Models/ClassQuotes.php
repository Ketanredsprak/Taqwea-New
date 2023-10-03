<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ClassQuotes extends Model
{
    //
    protected $table = 'class_quotes';

    protected $fillable = [
        'class_request_id',
        'student_id',
        'tutor_id',
        'status',
        'reject_time',
        'price',
        'created_at',
        'updated_at',    
    ];

    // public function tutor()
    // {
    //     return $this->hasMany(User::class,'tutor_id');
    // }
    public function tutor(){
        return $this->hasOne(User::class, 'id', 'tutor_id');
    }


}

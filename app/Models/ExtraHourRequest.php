<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ExtraHourRequest extends Model
{
    public const STATUS_ACCEPTED = 'accepted';
    public const STATUS_PENDING = 'pending';
    public const STATUS_REJECTED = 'rejected';
    
    protected $fillable = ['student_id', 'class_id', 'status'];

    /**
     * Method category
     *
     * @return mixed
     */
    public function class()
    {
        return $this->belongsTo(
            ClassWebinar::class,
            'class_id',
            'id'
        );
    }

    /**
     * Method category
     *
     * @return mixed
     */
    public function student()
    {
        return $this->belongsTo(
            User::class,
            'student_id',
            'id'
        );
    }
}

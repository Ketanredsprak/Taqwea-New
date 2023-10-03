<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Thread extends Model
{
    protected $fillable = [
        'class_id', 'student_id', 'tutor_id', 'uuid','booking_id'
    ];

    /**
     * Method student
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

    /**
     * Method class
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
     * Method tutor
     *
     * @return mixed
     */
    public function tutor()
    {
        return $this->belongsTo(
            User::class,
            'tutor_id',
            'id'
        );
    }

    /**
     * Method bookingClassesCount
     *
     * @return string
     */
    public static function generateUUID()
    {
        $uuid = Str::uuid()->toString();
        return (self::where('uuid', $uuid)->count() == 0) ?
        $uuid : self::generateUUID();
    }

    /**
     * Method messages
     *
     * @return mixed
     */
    public function messages()
    {
        return $this->hasMany(
            Message::class,
            'thread_id',
            'id'
        )->orderBy("id", "asc");
    }
}

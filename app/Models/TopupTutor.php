<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * TopupTutor class
 */
class TopupTutor extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'tutor_id','transaction_id', 'class_per_hours', 'webinar_per_hours',
        'blog', 'status', 'is_featured_day'
    ];

    /**
     * Method transaction
     * 
     * @return mixed
     */
    public function transaction()
    {
        return $this->belongsTo(
            Transaction::class,
            'transaction_id',
            'id'
        );
    }
}

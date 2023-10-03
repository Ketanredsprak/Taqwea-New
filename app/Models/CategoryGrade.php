<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategoryGrade extends Model
{
    /**
     * Method grade
     *
     * @return mixed
     */
    public function grade()
    {
        return $this->belongsTo(
            Grade::class,
            'grade_id',
            'id'
        );
    }
}

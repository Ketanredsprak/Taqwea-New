<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CategorySubject extends Model
{
    protected $fillable = ['category_id', 'grade_id', 'subject_id'];
    /**
     * Method category
     *
     * @return mixed
     */
    public function category()
    {
        return $this->belongsTo(
            Category::class,
            'category_id',
            'id'
        );
    }

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

    /**
     * Method subject
     *
     * @return mixed
     */
    public function subject()
    {
        return $this->belongsTo(
            Subject::class,
            'subject_id',
            'id'
        );
    }
}

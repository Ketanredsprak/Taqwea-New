<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * Language
 */
class Language extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */   
    protected $fillable = ['id', 'name', 'code', 'status'];

    /**
     * Get active languages
     *
     * @param Builder $query  [explicite description]
     *
     * @return void
     */
    public function scopeActive($query)
    {
        $query->where('status', 'active');
    }
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * FaqTranslation class
 */
class FaqTranslation extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['question', 'content'];
}

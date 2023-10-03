<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

/**
 * SupportRequest class
 */
class SupportRequest extends Model
{
    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = ['name', 'email', 'message'];

}

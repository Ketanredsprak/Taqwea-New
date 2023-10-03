<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Astrotomic\Translatable\Contracts\Translatable as TranslatableContract;
use Astrotomic\Translatable\Translatable;

/**
 * Bank Model
 */
class Bank extends Model
{
    use Translatable;

    public const BANK_ACTIVE = 'active';
    public const BANK_INACTIVE = 'inactive';

    public $translatedAttributes = [
        'bank_name'
    ];
    
    protected $fillable = [
        'bank_code', 
        'status'
    ];
}

<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Cart extends Model
{
    protected $fillable = ['user_id'];

    /**
     * Method Item
     * 
     * @return mixed
     */
    public function items()
    {
        return $this->hasMany('App\Models\CartItem');
    }
}

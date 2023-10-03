<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class CartItem extends Model
{
    protected $fillable = [
        'cart_id', 'class_id',
        'blog_id', 'qty', 'unit_price',
        'price'
    ];

    /**
     * Method classWebinar
     *
     * @return mixed
     */
    public function classWebinar()
    {
        return $this->belongsTo(
            ClassWebinar::class,
            'class_id',
            'id'
        );
    }

    /**
     * Method blog
     *
     * @return mixed
     */
    public function blog()
    {
        return $this->belongsTo(
            Blog::class,
            'blog_id',
            'id'
        );
    }

    /**
     * Method cart
     *
     * @return mixed
     */
    public function cart()
    {
        return $this->belongsTo(
            Cart::class,
            'cart_id',
            'id'
        );
    }

    /**
     * Method isCart
     * 
     * @param int $userId 
     * @param int $classId 
     * @param int $blogId 
     *  
     * @return bool
     */
    public static function isCart($userId, $classId = '', $blogId = ''):bool
    {

        if ($classId) {
            $where['class_id'] = $classId;
        }

        if ($blogId) {
            $where['blog_id'] = $blogId;
        }

        $query = self::where($where);

        if ($userId) {
            $query->whereHas(
                'cart', 
                function ($q) use ($userId) {
                    $q->where("user_id", $userId);
                }
            );
        }
        $wallet = $query->count();
        if (!empty($wallet)) {
            return true;
        }
        return false;
    }

    /**
     * Method getCount
     * 
     * @param int $userId 
     * 
     * @return int
     */
    public static function getCount($userId):int
    {
        return self::whereHas(
            'cart',
            function ($subQuery) use ($userId) {
                $subQuery->where('user_id', $userId);
            }
        )->count();
        
    }

}

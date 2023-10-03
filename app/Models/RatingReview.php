<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\DB;

class RatingReview extends Model
{
    protected $fillable = [
        'from_id', 'to_id', 'class_id', 'rating', 'review', 'clarity',
        'orgnization', 'give_homework', 'use_of_supporting_tools',
        'on_time'
    ];

    /**
     * Method from
     *
     * @return mixed
     */
    public function from()
    {
        return $this->belongsTo(
            User::class,
            'from_id',
            'id'
        );
    }

    /**
     * Method to
     *
     * @return mixed
     */
    public function to()
    {
        return $this->belongsTo(
            User::class,
            'to_id',
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
     * Method getAverageRating
     *
     * @param int $userId [explicite description]
     *
     * @return string
     */
    public static function getAverageRating(int $userId, $classId = ''): string
    {
        $avgRating = "0.0";
        $query = self::select(
            DB::raw("AVG(rating) AS avg_rating")
        )
            ->where('to_id', $userId);
        if ($classId) {
            $query->where('class_id', $classId);
        }
        $rating = $query->first();
        if ($rating) {
            $avgRating = number_format($rating['avg_rating'], 1);
        }
        return $avgRating;
    }
}

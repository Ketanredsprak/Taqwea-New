<?php

namespace App\Repositories;

use App\Models\RatingReview;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Eloquent\BaseRepository;

class RatingReviewRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RatingReview::class;
    }


    /**
     * Method getRatings
     *
     * @param array $params [explicite description]
     *
     * @return void
     */
    public function getRatings(array $params)
    {
        $limit = $params['size'] ?? defaultPaginationLimit();
        $query = $this->select(
            'rating_reviews.*',
            DB::raw("AVG(rating) AS avg_rating")
        );

        if (!empty($params['from_id'])) {
            $query->where('from_id', $params['from_id']);
            if (!empty($params['search'])) {
                $query->whereHas(
                    'to',
                    function ($subQuery) use ($params) {
                        $subQuery->whereTranslationLike(
                            'name',
                            "%" . $params['search'] . "%"
                        );
                    }
                );
            }
            
        }

        if (!empty($params['to_id'])) {
            $query->where('to_id', $params['to_id']);
            if (!empty($params['search'])) {
                $query->whereHas(
                    'from',
                    function ($subQuery) use ($params) {
                        $subQuery->whereTranslationLike(
                            'name',
                            "%" . $params['search'] . "%"
                        );
                    }
                );
            }
        }
        if (!empty($params['class_id'])) {
            $query->where('class_id', $params['class_id']);
        }

        if (!empty($params['tutor_id'])) {
            $query->where('to_id', $params['tutor_id']);
        }

        if (!empty($params['groupBy'])) {
            $query->groupBy('id');
        }

        if (!empty($params['orderBy'])) {
            $query->orderBy($params['orderByColumn'] ?? 'id', $params['orderBy']);
        } else {
            $query->latest();
        }
        return $query->paginate($limit);
    }

    /**
     * Method addRating
     *
     * @param array $data [explicite description]
     *
     * @return object
     */
    public function addRating(array $data)
    {
        return $this->create($data);
    }

    /**
     * Method GetByIdRating
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function getRating(int $id)
    {
        return $this->where('to_id', $id)->first();
    }

    /**
     * Method addRating
     *
     * @param $toId     [explicite description]
     * @param $class_id [explicite description]
     * @param $fromId   [explicite description]
     *
     * @return object
     */
    public function getStudentByClassRating($toId, $class_id, $fromId)
    {
        return $this->where(
            [
                'class_id' => $class_id,
                'to_id' => $toId,
                'from_id' => $fromId
            ]
        )->first();
    }
}

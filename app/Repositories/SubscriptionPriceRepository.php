<?php

namespace App\Repositories;

use App\Models\SubscriptionPrice;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Log;

/**
 * Interface Repository.
 *
 * @package SubscriptionRepository;
 */
class SubscriptionPriceRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return SubscriptionPrice::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Function UpdateSubscriptionPrice
     * 
     * @param $post [explicite description]
     * 
     * @return object
     */
    public function updateSubscriptionPrice($post, $id)
    {

        foreach ($post['updateField'] as $key => $value) {

            
            if ($key == 0) {
                $value['subscription_id'] = $id;
                $query = $this->create($value);
            } else {
                $query = $this->update($value, $key);
            }

            if (!isset($value['duration'])) {
                $query = $this->delete($value['id']);
            }

        }
        return $query;
    }
}

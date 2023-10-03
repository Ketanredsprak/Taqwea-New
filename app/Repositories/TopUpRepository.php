<?php

namespace App\Repositories;

use App\Models\Topup;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 *  SettingRepository class
 */
class TopUpRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Topup::class;
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
     * Method getTopUp
     * 
     * @param int $id 
     * 
     * @return Topup
     */
    public function getTopUp( $id = null)
    {
        if ($id) {
            return $this->where("id", $id)->first();
        }
        return $this->first();
    }
    /**
     * Function update
     *
     * @param array $data [explicite description]
     * 
     * @return void
     */
    public function updateTopUp(array $data)
    {
        return $this->update($data, $data['id']);
    }
}

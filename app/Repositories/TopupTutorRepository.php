<?php

namespace App\Repositories;

use App\Models\TopupTutor;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

/**
 *  SettingRepository class
 */
class TopupTutorRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TopupTutor::class;
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
     * @param array $params [explicite description] 
     * 
     * @return object
     */
    public function getTopUp(array $params = [])
    {
        $size = config('repository.pagination.limit');
        return $this->where("tutor_id", $params['tutor_id'])
            ->orderBy('id', 'DESC')
            ->paginate($size);
    }

    /**
     * Method createTopUp
     * 
     * @param array $data 
     * 
     * @return Object
     */
    public function createTopUp($data)
    {
        return $this->create($data);
    }

    /**
     * Method getTopUpByTransactionId
     * 
     * @param array $params 
     * 
     * @return Object
     */
    public function getTopUpByTransactionId(array $params = [])
    {
        return $this->where("transaction_id", $params['transaction_id'])
            ->first();
            
    }
}

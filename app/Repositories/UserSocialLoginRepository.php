<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\UserSocialLogin;

/**
 * Interface Repository.
 *
 * @package UserSocialLoginRepository;
 */
class UserSocialLoginRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserSocialLogin::class;
    }

    /**
     * Method boot
     *
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }
    
    /**
     * Method createSocialLogin
     *
     * @param array $data [explicite description]
     *
     * @return object
     */
    public function createSocialLogin(array $data)
    {
        return $this->updateOrCreate(
            [
                'user_id' => $data['user_id']
            ],
            $data
        );
    }
    
    /**
     * Method getDetails
     *
     * @param array $params [explicite description]
     *
     * @return UserSocialLogin
     */
    public function getDetails(array $params)
    {
        $query = $this->where('user_id', '<>', null);

        if (!empty($params['social_type'])) {
            $query->where('social_type', $params['provider']);
        }

        if (!empty($params['social_id'])) {
            $query->where('social_id', $params['social_id']);
        }

        if (!empty($params['user_id'])) {
            $query->where('user_id', $params['user_id']);
        }
        return $query->first();
    }

    /**
     * Method destroy
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function destroy($id)
    {
        $this->delete($id);
    }

}

<?php

namespace App\Repositories;

use App\Models\UserDevice;
use Exception;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Tymon\JWTAuth\Facades\JWTAuth;

/**
 * Class UserDeviceRepository.
 */
class UserDeviceRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return UserDevice::class;
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
     * Method createDevice
     *
     * @param array $data [explicite description]
     *
     * @return UserDevice|null
     */
    public function createDevice(array $data)
    {
        if (!$data['user_id']) {
            return null;
        }

        $oldDevice = $this->where('user_id', $data['user_id'])->first();
        if ($oldDevice && $oldDevice->authorization) {
            try {
                JWTAuth::setToken($oldDevice->authorization)->invalidate();
            } catch (Exception $e) {
                
            }
        }
        return $this->updateOrCreate(
            [
                'user_id' => $data['user_id']
            ],
            [
                'device_id' => $data['device_id'], 
                'device_type' => $data['device_type'], 
                'access_token' => $data['access_token'] ?? null, 
                'certification_type' => $data['certification_type'] ?? UserDevice::CERTIFICATION_DEV, 
            ]
        );
    }
    
    /**
     * Method getDeviceByUser
     *
     * @param int|array $userIds  [explicite description]
     * @param boolean   $withUser [explicite description]
     *
     * @return Collection
     */
    public function getDeviceByUser($userIds, $withUser = false)
    {
        if (!is_array($userIds)) {
            $userIds = [$userIds];
        }
        $query = $this->whereIn('user_id', $userIds);
        if ($withUser) {
            $query->with('user');
        }

        return $query->get();
    }
    
    /**
     * Method updateDevice
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return int
     */
    public function updateDeviceByUser(array $data, int $id):int
    {
        return $this->where('user_id', $id)->update($data, $id);
    }

    /**
     * Method updateDevice
     *
     * @param int    $id   [explicite description]
     * @param string $type [explicite description]
     *
     * @return int
     */
    public function destroy($id, $type):int
    {
        return $this->where(['user_id' =>  $id, "device_type" => $type])->delete();
    }
}

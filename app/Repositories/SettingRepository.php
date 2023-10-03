<?php

namespace App\Repositories;

use App\Models\Setting;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

/**
 *  SettingRepository class
 */
class SettingRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Setting::class;
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
     * Function store
     *
     * @param array $data [explicite description]
     * 
     * @return void
     */
    public function store(array $data)
    {
        foreach ($data as $key => $value) {
            if (in_array($key, Setting::AVAILABLE_SETTINGS)) {
                $result['setting_key'] = $key;
                $result['setting_value'] = $value;
                $this->updateOrCreate(
                    [
                        'setting_key' => $key
                    ],
                    $result
                );
            }
        }
        return true;
    }

    /**
     * Method getSettings
     * 
     * @param array $param 
     * 
     * @return String
     */
    public function getSettings(array $param = [])
    {
        if (isset($param['key'])) {
            $result = $this->where("setting_key", $param['key'])
                ->first();
            if ($result) {
                return $result->setting_value;
            }
            return '';
        }
        
    }

}

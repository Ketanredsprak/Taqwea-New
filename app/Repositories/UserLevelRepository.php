<?php
namespace App\Repositories;

use App\Models\TutorLevel;
use App\Models\User;
use App\Models\UserLevel;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserLevelRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return UserLevel::class;
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
     * Method updateLevels
     *
     * @param User  $user [explicite description]
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function updateLevels(User $user, array $data)
    {
        if (is_array($data['levels'])) {
            $data['levels'] = array_filter($data['levels']);
        }
        if (!empty($data['levels'])) {
            if (!is_array($data['levels'])) {
                $data['levels'] = explode(',', $data['levels']);
            }
            $user->levels()->sync($data['levels']);
        } else {
            $user->levels()->detach();
        }
    }
}
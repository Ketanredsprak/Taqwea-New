<?php
namespace App\Repositories;

use App\Models\TutorGrade;
use App\Models\User;
use App\Models\UserGrade;
use App\Models\UserSubjects;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserGradeRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return UserGrade::class;
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
    public function updateGrades(User $user, array $data)
    {
        if (is_array($data['grades'])) {
            $data['grades'] = array_filter($data['grades']);
        }
        
        if (!empty($data['grades'])) {
            if (!is_array($data['grades'])) {
                $data['grades'] = explode(',', $data['grades']);
            }
            $user->grades()->sync($data['grades']);
        } else {
            $user->grades()->detach();
        }
    }
}
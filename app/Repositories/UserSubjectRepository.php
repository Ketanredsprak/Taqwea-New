<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserSubject;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserSubjectRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return UserSubject::class;
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
     * Method updateSubjects
     *
     * @param User  $user [explicite description]
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function updateSubjects(User $user, array $data)
    {
        if (is_array($data['subjects'])) {
            $data['subjects'] = array_filter($data['subjects']);
        }
        if (!empty($data['subjects'])) {
            if (!is_array($data['subjects'])) {
                $data['subjects'] = explode(',', $data['subjects']);
            }
            $user->subjects()->sync($data['subjects']);
        } else {
            $user->subjects()->detach();
        }
    }
}
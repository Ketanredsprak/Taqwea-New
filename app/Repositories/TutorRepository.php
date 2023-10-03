<?php
namespace App\Repositories;

use App\Models\Tutor;
use App\Models\User;
use FunctionName;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class TutorRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Tutor::class;
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
     * Method updateTutor
     *
     * @param User  $user [explicite description]
     * @param array $data [explicite description]
     *
     * @return Tutor
     */
    public function updateTutor(User $user, array $data)
    {
       
        if (!empty($data['introduction_video'])) {
            $data['introduction_video'] = uploadFile(
                $data['introduction_video'],
                'tutor/introduction_video',
                'public',
                [
                    'width' => 300,
                    'height' => 150
                ]
            );
            if ($user->tutor && $user->tutor->introduction_video) {
                deleteFile($user->tutor->introduction_video);
            }
        } else if (array_key_exists("introduction_video_old", $data)) {
            $data['introduction_video'] = $data['introduction_video_old'];
        }

        if (!empty($data['id_card'])) {
            $data['id_card'] = uploadFile(
                $data['id_card'],
                'tutor/id_card'
            );
            if ($user->tutor && $user->tutor->id_card) {
                deleteFile($user->tutor->id_card);
            }
        }
        return $this->updateOrCreate(
            [
                'user_id' => $user->id
            ],
            $data
        );
    }

    /**
     * Method upgradePlan
     *
     * @param int   $user_id [explicite description]
     * @param array $data [explicite description]
     *
     * @return Tutor
     */
    public function upgradePlan($user_id, array $data)
    {
       
        return $this->updateOrCreate(
            [
                'user_id' => $user_id
            ],
            $data
        );
    }
    
    /**
     * Method getTutor
     *
     * @param int $id 
     * 
     * @return Tutor
     */
    public function getTutor($id)
    {
        return $this->where("user_id", $id)->first();
    }

}
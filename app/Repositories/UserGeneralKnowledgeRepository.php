<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserGeneralKnowledge;
use App\Models\UserSubject;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserGeneralKnowledgeRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return UserGeneralKnowledge::class;
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
     * Method updateGeneralKnowledge
     *
     * @param User  $user [explicite description]
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function updateGeneralKnowledge(User $user, array $data)
    {
        if (is_array($data['general_knowledge'])) {
            $data['general_knowledge'] = array_filter($data['general_knowledge']);
        }

        if (!empty($data['general_knowledge'])) {
            if (!is_array($data['general_knowledge'])) {
                $data['general_knowledge'] = explode(
                    ',',
                    $data['general_knowledge']
                );
            }
            $user->generalKnowledge()->sync($data['general_knowledge']);
        } else {
            $user->generalKnowledge()->detach();
        }
    }
}
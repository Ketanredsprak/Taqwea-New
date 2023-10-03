<?php
namespace App\Repositories;

use App\Models\User;
use App\Models\UserLanguage;
use App\Models\UserSubject;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class UserLanguageRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return UserLanguage::class;
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
     * Method updateLanguages
     *
     * @param User  $user [explicite description]
     * @param array $data [explicite description]
     *
     * @return void
     */
    public function updateLanguages(User $user, array $data)
    {
        if (is_array($data['languages'])) {
            $data['languages'] = array_filter($data['languages']);
        }

        if (!empty($data['languages'])) {
            if (!is_array($data['languages'])) {
                $data['languages'] = explode(',', $data['languages']);
            }
            $user->languages()->sync($data['languages']);
        } else {
            $user->languages()->detach();
        }
    }
}
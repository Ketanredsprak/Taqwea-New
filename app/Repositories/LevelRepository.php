<?php
namespace App\Repositories;

use App\Models\Level;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class LevelRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Level::class;
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
     * Method getCategories
     *
     * @param array $params [explicite description]
     *
     * @return void
     */
    public function getLevels(array $params = [])
    {
        return $this->withTranslation()->paginate();
    }

    /**
     * Get all levels
     * 
     * @param array $where
     * 
     * @return void
    */
    public function getAll($where = []){
        return $this->withTranslation()->where($where)->get();
    }
}
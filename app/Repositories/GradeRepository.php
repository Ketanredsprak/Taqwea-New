<?php
namespace App\Repositories;

use App\Models\Grade;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class GradeRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Grade::class;
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
    public function getGrades(array $params = [])
    {
        return $this->withTranslation()->paginate();
    }

    /**
     * Get all grates
     *
     * @param array $params [explicite description]
     *
     * @return void
     */
    public function getAll(array $params = [])
    {
        return $this->withTranslation()->where($params)->get();
    }
}
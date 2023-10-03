<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\Demo;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Interface Repository.
 *
 * @package DemoRepository;
 */
class DemoRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Demo::class;
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
     * Function getdemo
     * 
     * @param int $id [explicite description]
     * 
     * @return void
     */
    public function getdemo($id)
    {
        return $this->where('id', $id)->first();
    }

      /**
     * Function createDemo
     *
     * @param $post [explicite description]
     * 
     * @return void
     */
    public function createDemo($post)
    {
        
        try {
            DB::beginTransaction();
            $result = $this->create($post);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }

    /**
     * Function updateFaq
     * 
     * @param $post [explicite description]
     * @param int $id   [explicite description]
     *
     * @return void
     */
    public function demoUpdate($post, $id)
    {
        try {
            DB::beginTransaction();
            $result = $this->update($post, $id);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }

    /** 
     * Get details of demo
     *
     * @param array $where  
     * 
     * @return Collection
     */
    public function getdemoDetails(array $where)
    {
        return $this->withTranslation()->where($where)->first();
    }

     /** 
     * Get  demos  all
     *
     * @param array $where  
     * 
     * @return Collection
     */
    public function getdemos(array $params = [])
    {

        $limit = 10;
        $query = $this;

        if (!empty($params['search'])) {
            $query->whereTranslationLike('question', "%".$params['search']."%");
        }
         
        return $query->paginate($limit);

    }


    /**
     * Method deletedemo
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deletedemo(int $id): int
    {
        return $this->delete($id);
    }


}

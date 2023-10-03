<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ClassQuotes;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Interface Repository.
 *
 * @package TutorClassRequestRepository;
 */
class TutorClassRequestRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClassQuotes::class;
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
     * Function getClassQuotes
     * 
     * @param int $id [explicite description]
     * 
     * @return void
     */
    public function getClassQuotes($id)
    {
        return $this->where('id', $id)->first();
    }

      /**
     * Function createClassQuotes
     *
     * @param $post [explicite description]
     * 
     * @return void
     */
    public function createClassQuotes($post)
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
    public function ClassQuotesUpdate($post, $id)
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
     * Get details of ClassQuotes
     *
     * @param array $where  
     * 
     * @return Collection
     */
    public function getClassQuotesDetails(array $where)
    {
        return $this->withTranslation()->where($where)->first();
    }

     /** 
     * Get  ClassQuotes  all
     *
     * @param array $where  
     * 
     * @return Collection
     */
    // public function getClassQuotes(array $params = [])
    // {

    //     $limit = 10;
    //     $query = $this;

    //     if (!empty($params['search'])) {
    //         $query->whereTranslationLike('question', "%".$params['search']."%");
    //     }
         
    //     return $query->paginate($limit);

    // }


    /**
     * Method deleteClassQuotes
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteClassQuotes(int $id): int
    {
        return $this->delete($id);
    }

    
    /**
     * Method getAll
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function getAll(int $id){
        return $this->with('tutor')->where('class_request_id',$id)->where('status',1)->paginate(10);
    }



     /**
     * Method getAll
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function tutorrequestreject($post, $id){
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

    




}

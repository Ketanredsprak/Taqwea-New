<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ClassRequestDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;


/**
 * Interface Repository.
 *
 * @package ClassRequestDetailRepository;
 */
class ClassRequestDetailRepository extends BaseRepository
{



   


    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClassRequestDetail::class;
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
     * Function getClassRequest
     * 
     * @param int $id [explicite description]
     * 
     * @return void
     */
    public function getClassRequestDetail($id)
    {
        return $this->where('id', $id)->first();
    }

      /**
     * Function createClassRequest
     *
     * @param $post [explicite description]
     * 
     * @return void
     */
    public function createClassRequestDetail($post)
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
     * Function classRequestUpdate
     * 
     * @param $post [explicite description]
     * @param int $id   [explicite description]
     *
     * @return void
     */
    public function classRequestDetailUpdate($post, $id)
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
     * Get details of getClassRequestDetails
     *
     * @param array $where  
     * 
     * @return Collection
     */
    public function getClassRequestDetails(array $where)
    {
        return $this->withTranslation()->where($where)->first();
    }

     /** 
     * Get  getClassRequests  all
     *
     * @param array $where  
     * 
     * @return Collection
     */
    public function getClassRequestsDetail(array $params = [])
    {

        $limit = 10;
        $query = $this;

        if (!empty($params['search'])) {
            $query->whereTranslationLike('question', "%".$params['search']."%");
        }
         
        return $query->paginate($limit);

    }


    /**
     * Method deleteClassRequest
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteClassRequestDetail(int $id): int
    {
        return $this->delete($id);
    }

    
    /**
     * Method cancelClassRequest
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function cancelClassRequest($post=[],$id)
    {
        try {
            DB::beginTransaction();
            $datas  = $this->where('class_request_id', $id)->get();
            foreach($datas as $data)
                {
                                $updateclassrequestdetails = ClassRequestDetail::find($data->id);
                                $updateclassrequestdetails->status = "Cancel";
                                $updateclassrequestdetails->update();
                }
            DB::commit();
            return $updateclassrequestdetails;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }


    }



}

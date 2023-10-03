<?php

namespace App\Repositories;

use Exception;
use Carbon\Carbon;
use App\Models\ClassRequest;
use App\Models\ClassRequestDetail;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;

/**
 * Interface Repository.
 *
 * @package ClassRequestRepository;
 */
class ClassRequestRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ClassRequest::class;
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
    public function getClassRequest($id)
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
    public function createClassRequest($post)
    {
        // try {
            DB::beginTransaction();
            $result = $this->create($post);
            DB::commit();

            if ($post['class_type'] == "Multiple") {
                foreach ($post['class'] as $class) {
                    $classStartTime = Carbon::parse($class['date'] . ' ' . $post['class_time']);
                    $classStartTime = changeDateToFormat($classStartTime, 'Y-m-d H:i:s');
                    $start_time = $classStartTime;

                    $endTime = changeDateToFormat(Carbon::parse($start_time)->addMinutes($post['class_duration']), 'Y-m-d H:i:s');
                    $end_time = $endTime;

                    $class_detail = new ClassRequestDetail;
                    $class_detail->date = date("d-m-Y", strtotime($class['date']));
                    $class_detail->status = "Active";
                    $class_detail->start_time = $start_time;
                    $class_detail->end_time = $end_time;
                    $class_detail->user_id =  Auth::user()->id;
                    $class_detail->class_request_id  = $result['id'];
                    $class_detail->save();
                }
            } else {
                $classStartTime = Carbon::parse($post['class_date'] . ' ' . $post['class_time']);
                $classStartTime = changeDateToFormat($classStartTime, 'Y-m-d H:i:s');
                $start_time = $classStartTime;

                $endTime = changeDateToFormat(Carbon::parse($start_time)->addMinutes($post['class_duration']), 'Y-m-d H:i:s');
                $end_time = $endTime;

                $class_detail = new ClassRequestDetail;
                $class_detail->date = $post['class_date'];
                $class_detail->status = "Active";
                $class_detail->start_time = $start_time;
                $class_detail->end_time = $end_time;
                $class_detail->user_id =  Auth::user()->id;
                $class_detail->class_request_id  = $result['id'];
                $class_detail->save();
            }


            return $result;
        // } catch (Exception $e) {
        //     DB::rollBack();
        //     throw ($e);
        // }
    }

    /**
     * Function classRequestUpdate
     *
     * @param $post [explicite description]
     * @param int $id   [explicite description]
     *
     * @return void
     */
    public function classRequestUpdate($post, $id)
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
    public function getClassRequests(array $params = [])
    {

        $limit = 10;
        $query = $this;

        if (!empty($params['search'])) {
            $query->whereTranslationLike('question', "%" . $params['search'] . "%");
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
    public function deleteClassRequest(int $id): int
    {
        return $this->delete($id);
    }

    public function getAll(int $id)
    {
        return $this->where('user_id', $id)->paginate(10);
    }

    public function startTimeCheck($post,$timezone){

        if($post['class_date'] != null){
            $classStartTime = Carbon::parse($post['class_date'] . ' ' . $post['class_time']);
            $classStartTime = changeDateToFormat($classStartTime, 'Y-m-d H:i:s');
            $start_time = convertDateToTz($classStartTime, $timezone, 'Y-m-d H:i:s', 'UTC');;
            if ($start_time < Carbon::now()) {
                throw new Exception(__('message.class_invalid_time'));
            }
        }

        if($post['class'] != null && count($post['class']) > 0){
            foreach ($post['class'] as $key => $value) {
                if($value['date'] != null){
                    $classStartTime = Carbon::parse($value['date'] . ' ' . $post['class_time']);
                    $classStartTime = changeDateToFormat($classStartTime, 'Y-m-d H:i:s');
                    $start_time = $classStartTime;
                    if ($start_time < Carbon::now()) {
                        throw new Exception(__('message.class_invalid_time'));
                    }
                }
            }
        }
    }
}

<?php

namespace App\Repositories;

use App\Models\ClassRefundRequest;
use App\Models\Transaction;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use App\Models\User;
use App\Events\RequestDisputeEvent;
use Exception;

/**
 * ClassRefundRepository
 */
class ClassRefundRequestRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return ClassRefundRequest::class;
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
     * Create Method
     *
     * @param Object $class 
     * @param array  $data 
     * 
     * @return Boolean
     */
    public function createRefundRequest($class = [], $data = [])
    {
        try {
            $data['user_id'] = $data['user']->id;

            if (!empty($class)) {
                $data["class_id"] = $class->id;
            }
            
            $where = [
                'user_id' => $data['user_id'],
                'class_id' => $data["class_id"]
            ];
            $result = $this->updateOrCreate(
                $where,
                $data
            );
            RequestDisputeEvent::dispatch($result);
            return true;
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    /**
     * Method getRecentUsers
     *
     * @return Collection
     */
    public function getRecentStudents()
    {
        return $this->with('student')
            ->whereHas(
                'student',
                function ($subQuery) {
                    $subQuery->where('user_type', User::TYPE_STUDENT);
                }
            )->orderBy('created_at', 'desc')
            ->limit(5);
    }

    /**
     * Function RefundRequestList
     * 
     * @param $params [explicite description]
     * 
     * @return collection
     */
    public function refundRequestList(array $params = [])
    {
        $sortFields = [
            'id' => 'id',
            'tutor_name' => 'tutor_name',
            'student_name' => 'student_name',
            'class_name' => 'class_name',
            'duration' => 'duration',
            'hourly_fees' => 'hourly_fees',
            'date_&_time' => 'date_&_time',
            'dispute_reason' => 'dispute_reason'
        ];

        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this;

        if (!empty($params['search'])) {
            $query = $query->whereHas(
                'class.tutor',
                function ($q) use ($params) {
                    $q->whereTranslationLike('name', "%" . $params['search'] . "%");
                }
            );
        }

        if (!empty($params['status'])) {
            $query =  $query->where('status', $params['status']);
        }

        if (!empty($params['tutor_name'])) {
            $query = $query->whereHas(
                'class.tutor',
                function ($q) use ($params) {
                    $q->whereTranslation('name', $params['tutor_name']);
                }
            );
        }

        if (!empty($params['student_name'])) {
            $query = $query->whereHas(
                'student',
                function ($q) use ($params) {
                    $q->whereTranslation('name', $params['student_name']);
                }
            );
        }

        if (!empty($params['from_date'])) {
            $query = $query->whereDate('created_at', $params['from_date']);
        }

        if (!empty($params['to_date'])) {
            $query = $query->whereDate('created_at', $params['to_date']);
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }

        $query =  $query->orderBy($sort, $direction);

        return $query->paginate($size);
    }

    /**
     * Function ShowStudentDetails 
     * 
     * @param $id 
     * 
     * @return object
     */
    public function showStudentDetails($id, $data)
    {
        return $this->where('user_id', $id)->where('id', $data['id'])->with(
            [
                'transactionItem' =>
                function ($q) use ($id, $data) {
                    $q->where('class_id', $data['class_id'])
                        ->where('student_id', $id)
                        ->where('status', 'refund');
                }
            ]
        )->first();
    }

    /**
     * Function Refund Amount
     * 
     * @param array $post 
     * 
     * @return object
     */
    public function refundAmount(array $post = [])
    {
        $result = $this->where(
            [
                'user_id' => $post['student_id'],
                'class_id' => $post['class_id'],
            ]
        )->update(['status' => ClassRefundRequest::STATUS_REFUND]);

        return $result;
    }

    /**
     * Function Check Refund Request
     * 
     * @param $class_id 
     * 
     * @return object
     */
    public function checkRefundRequest($class_id)
    {
        return $this->where(
            [
                'user_id' => Auth::user()->id, 'class_id' => $class_id
            ]
        )->first();
    }

    /**
     * Method getList
     * 
     * @param array $params 
     * 
     * @return object
     */
    public function getList($params = [])
    {
        $query = $this->orderBy("id", "desc");
        if (!empty($params['id'])) {
            $query->where('id', $params['id']);
        }
        return $query->first();
    }
}

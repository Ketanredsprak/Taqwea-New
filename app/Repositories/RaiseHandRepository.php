<?php

namespace App\Repositories;

use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\RaiseHand;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * Interface Repository.
 *
 * @package RaiseHandRepository;
 */
class RaiseHandRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return RaiseHand::class;
    }

    /**
     * Method boot
     *
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Undocumented function
     *
     * @param array $params 
     * 
     * @return Collection
     */
    public function getRaiseHandRequests(array $params)
    {
        return $this->where('class_id', $params['class_id'])
            ->whereIn(
                'status', 
                [
                    RaiseHand::STATUS_PENDING,
                    RaiseHand::STATUS_ACCEPT
                ]
            )
            ->get();
    }

    /**
     * Function createFaq
     *
     * @param $post [explicite description]
     * 
     * @return void
     */
    public function addRaiseHandRequest($post)
    {
        $request = $this->where(
            [
                'student_id' => $post['student_id'],
                'class_id' => $post['class_id'],
            ]
        )->whereNotIn(
            'status',
            [
                RaiseHand::STATUS_COMPLETE,
                RaiseHand::STATUS_REJECT
            ]
        )->first();

        if (!$request) {
            return $this->create($post);
        }

        return $this->updateRaiseHandRequest($request->id, $post);
    }
    
    /**
     * Method updateRaiseHandRequest
     *
     * @param int   $id   [explicite description]
     * @param array $data [explicite description]
     *
     * @return RaiseHand
     */
    public function updateRaiseHandRequest(int $id, array $data):RaiseHand
    {
        $requestData = $this->getRaiseHandRequestById($id);
        if (!$requestData) {
            throw new Exception(__('error.model_not_found'));
        }
        return $this->update($data, $id);
    }
    
    /**
     * Method getRaiseHandRequestById
     *
     * @param int $requestId [explicite description]
     *
     * @return RaiseHand
     */
    public function getRaiseHandRequestById(int $requestId):RaiseHand
    {
        return $this->where('id', $requestId)->first();
    }

    /**
     * Undocumented function
     *
     * @param array $params 
     * 
     * @return Collection
     */
    public function getRaiseHandRequest(array $params)
    {
        $query = $this->where('class_id', $params['class_id']);

        if (!empty($params['student_id'])) {
            $query->where('student_id', $params['student_id']);
        }
        
        if (!empty($params['status'])) {
            $status = [];
            if (!is_array($params['status'])) {
                $status[] = $params['status'];
            }
            $query->whereIn(
                'status',
                $status
            );
        }        
        return $query->first();
    }

}

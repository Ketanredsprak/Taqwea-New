<?php

namespace App\Repositories;

use App\Jobs\ExtraHourRequestJob;
use App\Models\ClassBooking;
use App\Models\ClassWebinar;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\ExtraHourRequest;
use Exception;
use Illuminate\Database\Eloquent\Collection;

class ExtraHourRequestRepository extends BaseRepository
{
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return ExtraHourRequest::class;
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
     * Function createRequest
     * 
     * @param $post [explicite description]
     *
     * @return void
     */
    public function createRequest($post)
    {
        return $this->create($post);
    }
    
    /**
     * Method sendRequest
     *
     * @param ClassWebinar $class [explicite description]
     *
     * @return void
     */
    public function sendRequest(ClassWebinar $class)
    {
        foreach ($class->bookings as $booking) {
            if ($booking->status == ClassBooking::STATUS_CONFIRMED
                && $booking->parent_id == null
            ) {
                $data = [
                    'student_id' => $booking->student_id,
                    'class_id' => $class->id
                ];
                ExtraHourRequestJob::dispatch($data);
            }            
        }
    }
    
    /**
     * Method getRequest
     *
     * @param array $params [explicite description]
     *
     * @return ExtraHourRequest|null
     */
    public function getRequest(array $params):?ExtraHourRequest
    {
        $query = $this->where('class_id', $params['class_id']);

        if (!empty($params['student_id'])) {
            $query->where('student_id', $params['student_id']);
        }

        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query->first();
    }
    
    /**
     * Method updateRequest
     *
     * @param array $params [explicite description]
     *
     * @return ExtraHourRequest
     */
    public function updateRequest(array $params):ExtraHourRequest
    {
        $status = $params['status'];
        unset($params['status']);
        $request = $this->getRequest($params);
        if (!$request) {
            throw new Exception(__('error.extra_hour_request_not_found'), 404);
        }

        if (in_array(
            $request->status,
            [
                ExtraHourRequest::STATUS_ACCEPTED,
                ExtraHourRequest::STATUS_REJECTED
            ]
        )
        ) {
            throw new Exception(__('error.extra_hour_request_already_accepted'), 422);
        }

        return $this->update(
            [
                'status' => $status
            ],
            $request->id
        );
    }

    /**
     * Method getRequest
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getRequests(array $params)
    {
        $query = $this->where('class_id', $params['class_id']);

        if (!empty($params['student_id'])) {
            $query->where('student_id', $params['student_id']);
        }

        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        return $query->get();
    }
}

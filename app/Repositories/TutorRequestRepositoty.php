<?php

namespace App\Repositories;

use Exception;
use App\Models\TutorRequest;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use Illuminate\Container\Container as Application;

/**
 * Interface Repository.
 *
 * @package TutorRequestRepositoty;
 */
class TutorRequestRepositoty extends BaseRepository
{
    protected $notificationRepository;

    /**
     * Method __construct
     *
     * @param NotificationRepository         $notificationRepository
     *
     * @return void
     */
    public function __construct(
        Application $app,
        NotificationRepository $notificationRepository
    ) {
        parent::__construct($app);
        $this->notificationRepository = $notificationRepository;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TutorRequest::class;
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
     * Function gettutorclassrequest
     *
     * @param int $id [explicite description]
     *
     * @return void
     */
    public function gettutorRequest($id)
    {
        return $this->where('id', $id)->with('classrequest')->with('userdata')->first();
    }

    /**
     * Function createtutorclassrequest
     *
     * @param $post [explicite description]
     *
     * @return void
     */
    public function createTutorRequest($result_data, $post)
    {


        try {
            DB::beginTransaction();
          
            foreach ($post as $tutor_data) {
               
                $data['class_request_id'] = $result_data->id;
                $data['user_id'] = $result_data->user_id;
                $data['tutor_id'] = $tutor_data->id;
                $data['status'] = "Active";
                $result = $this->create($data);
                $extra_data = [
                    'type' => 'class_request_from_student',
                    'from_id' => Auth::id(),
                    'to_id' =>  $tutor_data->id,
                    'notification_message' => "Student has requested a class",
                ];

                $data1['type'] = 'class_request_from_student';
                $data1['extra_data'] = $extra_data;
                $data1['from_id'] = Auth::id();
                $data1['to_id'] = $tutor_data->id;
                $data1['notification_message'] = "Student has requested a class";
                $this->notificationRepository
                    ->sendNotification($data1, true);
          
            }
           
            DB::commit();
            return true;
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
    public function getTutorClassRequestDetails(array $where)
    {
        return $this->withTranslation()->where($where)->first();
    }

    /**
     * Get  gettutorclassrequests  all
     *
     * @param array $where
     *
     * @return Collection
     */
    public function gettutorclassrequest(int $id)
    {
        return $this->with('classrequest', 'userdata')->where('tutor_id', $id)->paginate(10);
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

     /**
     * Method cancelClassRequest
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function cancelClassRequest($id)
    {
         try {
            DB::beginTransaction();
            $datas  = $this->where('class_request_id', $id)->get();
            if($datas != null)
            {
            foreach($datas as $data)
                {
                                $update_tutor_class_request_status = TutorRequest::find($data->id);
                                $update_tutor_class_request_status->status = "Cancel";
                                $update_tutor_class_request_status->update();
                }
            }
            else
            {
                $update_tutor_class_request_status = "No Entry Found";
            }
            DB::commit();
            return $update_tutor_class_request_status;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }


    }

}

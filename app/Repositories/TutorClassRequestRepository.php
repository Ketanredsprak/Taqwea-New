<?php

namespace App\Repositories;

use App\Models\ClassQuotes;
use App\Models\ClassRequest;
use Carbon\Carbon;
use Exception;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Models\RatingReview;

/**
 * Interface Repository.
 *
 * @package TutorClassRequestRepository;
 */
class TutorClassRequestRepository extends BaseRepository
{
    protected $notificationRepository;

    /**
     * Method __construct
     *
     * @param Application                    $app
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
        return $this->with('tutor')->with('class_request','class_request_detail')->where('id', $id)->first();
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
    public function getAll(int $id)
    {
        $datas =  $this->with('tutor','classrequestdetail','class_request')->where('class_request_id', $id)->where('status', 0)->paginate(10);
        foreach($datas as $data)
        {
            $data['rating'] = RatingReview::getAverageRating($data->tutor_id);
        }
        return $datas;
    }

    /**
     * Method getAll
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function tutorrequestreject($post, $id)
    {
        try {
            DB::beginTransaction();
            $quoteData = $this->find($id);
            $result = $this->update($post, $id);


            $extra_data = [
                'type' => 'reject_request',
                'from_id' => Auth::id(),
                'to_id' => $quoteData->tutor_id,
                'notification_message' => "Hello, your proposal is rejected",
            ];

            $data1['type'] = 'reject_request';
            $data1['extra_data'] = $extra_data;
            $data1['from_id'] = Auth::id();
            $data1['to_id'] = $quoteData->tutor_id;
            $data1['notification_message'] = "Hello, your proposal is rejected";
            $this->notificationRepository
                ->sendNotification($data1, true);
            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }
    public function tutorRequestAccept($post, $id)
    {

        try {

            DB::beginTransaction();
            $quoteData = $this->find($id);

            $quote_id = array($id);

            $classRequests = $this->select("*")->where('status',0)->whereNotIn('id',$quote_id)->get();



            if (count($classRequests) > 0) {
                foreach ($classRequests as $key => $classRequest) {
                    $classRequest->status = '2';
                    $classRequest->reject_time = Carbon::now();
                    $classRequest->update();


                    $extra_data = [
                        'type' => 'reject_request',
                        'from_id' => Auth::id(),
                        'to_id' => $classRequest->tutor_id,
                        'notification_message' => "Your quote is rejected by student",
                    ];

                    $data1['type'] = 'reject_request';
                    $data1['extra_data'] = $extra_data;
                    $data1['from_id'] = Auth::id();
                    $data1['to_id'] = $classRequest->tutor_id;
                    $data1['notification_message'] = "Your quote is rejected by student";
                    $this->notificationRepository
                        ->sendNotification($data1, true);
                }
            }

                    $extra_data1 = [
                        'type' => 'accept_request',
                        'from_id' => Auth::id(),
                        'to_id' => $quoteData->tutor_id,
                        'notification_message' => "Thank you your proposal is accepted",
                    ];


            $result = $this->update($post, $id);
            $data['type'] = 'accept_request';
            $data['extra_data'] = $extra_data1;
            $data['from_id'] = Auth::id();
            $data['to_id'] = $quoteData->tutor_id;
            $data['notification_message'] = "Thank you your proposal is accepted";
            $this->notificationRepository
                ->sendNotification($data, true);

            $classRequestData = ClassRequest::find($quoteData->class_request_id);
            $classRequestData->update([
                'won_quote_id' => $id,
            ]);

            DB::commit();
            return $result;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }
}

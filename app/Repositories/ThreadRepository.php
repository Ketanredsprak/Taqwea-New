<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;
use App\Models\Thread;
use App\Models\User;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use Exception;
use Log;
use App\Models\Message;

class ThreadRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Thread::class;
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
     * Method __construct
     *
     * @param Application  $app
     *
     * @return void
     */
    public function __construct(
        Application $app
    ) {
        parent::__construct($app);
    }



    /**
     * Method createThread
     *
     * @param array $data [explicite description]
     *
     * @return Thread
     */
    public function createThread(array $data): Thread
    {
        try {
            DB::beginTransaction();
            $thread = $this->create($data);
            DB::commit();
            return $thread;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Method CheckIfExist
     *
     * @param array $where 
     *
     * @return count
     */
    public function checkIfExist(array $where)
    {
        try {
            return $this->where($where)->count();
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    /**
     * Method getMessageList
     * 
     * @param array $params 
     *
     * @return object
     */
    public function getMessageList(array $params = [])
    {
        try {
            $now = Carbon::now()->subDays(config('services.message_day'));
            $message_date = $now->format('Y-m-d H:i:s');

            $user = Auth::user();
            $dbRaw = "(select max(created_at) 
                        from messages 
                        where messages.thread_id = threads.id limit 1)
                        as last_message";

            $query = $this->select('threads.*', DB::raw($dbRaw))
                ->where("threads.created_at", ">=", $message_date)
                ->leftJoin("messages", "messages.thread_id", "=", "threads.id")
                ->with(['student', 'class', 'tutor'])
                ->withCount(
                    [
                        'messages' =>
                        function ($q) use ($user) {
                            $q->where('to_id', $user->id)->where('is_readed', 0);
                        }
                    ]
                );

            if (!empty($params["class_id"])) {
                $query->where("class_id", $params["class_id"]);
            }

            if ($user->user_type == User::TYPE_TUTOR) {
                $query->where('tutor_id', $user->id);
                if (!empty($params["search"])) {
                    $query->whereHas(
                        'student',
                        function ($subQuery) use ($params) {
                            $subQuery->whereTranslationLike(
                                'name',
                                "%" . $params['search'] . "%"
                            );
                        }
                    );
                }
            }

            if ($user->user_type == User::TYPE_STUDENT) {
                $query->where('student_id', $user->id);
                if (!empty($params["search"])) {
                    $query->where(
                        function ($q) use ($params) {
                            $q->whereHas(
                                'class',
                                function ($subQuery) use ($params) {
                                    $subQuery->whereTranslationLike(
                                        'class_name',
                                        "%" . $params['search'] . "%"
                                    );
                                }
                            );

                            $q->orWhereHas(
                                'tutor',
                                function ($subQuery) use ($params) {
                                    $subQuery->whereTranslationLike(
                                        'name',
                                        "%" . $params['search'] . "%"
                                    );
                                }
                            );
                        }
                    );
                }
            }

            if (!empty($params['group_by'])) {
                $query->groupBy("class_id");
            } else {
                $query->groupBy("threads.id");
            }

            return $query->orderBy("last_message", "DESC")->get();
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    /**
     * Method getMessageDetail
     *
     * @param array $data 
     *
     * @return count
     */
    public function getMessageDetail($data)
    {
        try {
            $user = Auth::user();

            // Update message read
            $updateQuery = Message::where("to_id", $user->id)
                ->where("thread_uuid", $data["uuid"]);

            if (!empty($data['studentId'])) {
                $updateQuery->where("from_id", $data['studentId']);
            }
            $updateQuery->update(["is_readed" => 1]);

            // get message
            $query = $this->where('uuid', $data['uuid'])
                ->with(['class', 'tutor']);

            if ($user->isStudent()) {
                $query->where('student_id', $user->id);
            }

            if (!empty($data['studentId'])) {
                $query->where('student_id', $data['studentId']);

                $query->with(
                    [
                        'messages' =>
                        function ($q) use ($user, $data) {
                            $q->where(
                                function ($q) use ($user, $data) {
                                    $q->where("from_id", $user->id);
                                    $q->Where("to_id", $data['studentId']);
                                }
                            );
                            $q->orWhere(
                                function ($q) use ($user, $data) {
                                    $q->where("from_id", $data['studentId']);
                                    $q->Where("to_id", $user->id);
                                }
                            );
                        }
                    ]
                );
            } else {
                $query->with(
                    [
                        'messages' =>
                        function ($q) use ($user) {
                            $q->where("from_id", $user->id);
                            $q->orWhere("to_id", $user->id);
                        }
                    ]
                );
            }



            return $query->first();
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }

    /**
     * Method getThread 
     * 
     * @param array $params 
     * 
     * @return array 
     */
    public function getThread(array $params = [])
    {
        try {
            $now = Carbon::now()->subDays(config('services.message_day'));
            $message_date = $now->format('Y-m-d H:i:s');

            $user = Auth::user();
            $query = $this->where("created_at", ">=", $message_date);


            if (!empty($params["class_id"])) {
                $query->where("class_id", $params["class_id"]);
            }

            if (!empty($user) && $user->user_type == User::TYPE_TUTOR) {
                $query->where('tutor_id', $user->id);
            }

            if (!empty($user) && $user->user_type == User::TYPE_STUDENT) {
                $query->where('student_id', $user->id);
            }
            return $query->first();
        } catch (Exception $e) {
            throw $e->getMessage();
        }
    }
}

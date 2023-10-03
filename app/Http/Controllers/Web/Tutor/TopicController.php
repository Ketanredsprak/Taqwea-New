<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ClassTopicRepository;
use App\Repositories\ClassSubTopicRepository;
use App\Http\Requests\Tutor\AddTopicRequest;
use App\Models\ClassTopic;
use App\Models\ClassWebinar;
use Exception;
use Illuminate\Support\Facades\App;

/**
 * Class for class topic opration
 */
class TopicController extends Controller
{
    protected $classTopicRepository;
    protected $subTopicRepository;

    /**
     * Method __construct
     * 
     * @param ClassTopicRepository    $classTopicRepository [explicite description]
     * @param ClassSubTopicRepository $subTopicRepository   [explicite description]
     *
     * @return void
     */
    public function __construct(
        ClassTopicRepository $classTopicRepository,
        ClassSubTopicRepository $subTopicRepository
    ) {
        $this->classTopicRepository = $classTopicRepository;
        $this->subTopicRepository = $subTopicRepository;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            if (!empty($request->class)) {
                $params['class_id'] = $request->class;
            }
            $topics = $this->classTopicRepository->getTopics($params);
            $html = view('frontend.tutor.class.topic-list', ['topics' => $topics])
                    ->render();

            return $this->apiSuccessResponse($html, '');
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create(Request $request)
    {
        try {
            $html = view('frontend.tutor.class.add-topic-modal')->render();
            return $this->apiSuccessResponse($html, '');
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddTopicRequest $request [explicite description]
     * @param ClassWebinar    $class   [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(AddTopicRequest $request, ClassWebinar $class)
    {
        try {
            $data = $request->all();
           
            if (empty(@$data['ar']['topic_title'])) {
                unset($data['ar']);
            }
            if (empty(@$data['sub_topics'])) {
                unset($data['sub_topics']);
            }
            // if (empty(@$data['sub_topics_ar'])) {
            //     unset($data['sub_topics_ar']);
            // }

            $data['class_id'] = $class->id;
            if (@$data['topic_id']) {
                $topic = $this->classTopicRepository->updateTopic($data, $data['topic_id']);
            } else {
                $topic = $this->classTopicRepository->createTopic($data);
            }
            return $this->apiSuccessResponse($topic, trans('message.topic_created'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $classId [explicite description]
     * @param int $topicId [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($classId, $topicId)
    {
        try {
            $topic = $this->classTopicRepository->getTopic($topicId);
            $html = view('frontend.tutor.class.add-topic-modal', ['topic' => $topic])
                    ->render();
            return $this->apiSuccessResponse($html, '');
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request [explicite description]
     * @param int                      $id      [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Delete sub topics
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return \Illuminate\Http\Response
     */
    public function deleteSubTopic(Request $request)
    {
        try {
            $topic = $this->subTopicRepository->deleteTopic($request->id);
            return $this->apiSuccessResponse($topic, trans('message.sub_topic_deleted'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

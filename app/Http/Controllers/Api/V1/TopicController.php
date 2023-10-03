<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddTopicRequest;
use App\Http\Resources\V1\TopicResource;
use App\Models\ClassTopic;
use App\Models\ClassWebinar;
use App\Repositories\ClassTopicRepository;
use Exception;
use Illuminate\Http\Request;

class TopicController extends Controller
{
    protected $classTopicRepository;
    
    /**
     * Method __construct
     * 
     * @param ClassTopicRepository $classTopicRepository 
     *
     * @return void
     */
    public function __construct(
        ClassTopicRepository $classTopicRepository
    ) {
        $this->classTopicRepository = $classTopicRepository;
    }

    /**
     * Display a listing of the resource.
     * 
     * @param ClassWebinar $class 
     *
     * @return BlogResource
     */
    public function index(ClassWebinar $class)
    {
        try {
            $params['class_id'] = $class->id;
            $topics = $this->classTopicRepository->getTopics($params);
            return TopicResource::collection($topics);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddTopicRequest $request 
     * @param ClassWebinar    $class 
     * 
     * @return BlogResource
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
            if (empty(@$data['sub_topics_ar'])) {
                unset($data['sub_topics_ar']);
            }
            $data['class_id'] = $class->id;
            $topic = $this->classTopicRepository->createTopic($data);
            return new TopicResource($topic);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return BlogResource
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param AddTopicRequest $request 
     * @param ClassWebinar    $class 
     * @param ClassTopic      $topic 
     * 
     * @return TopicResource
     */
    public function update(
        AddTopicRequest $request,
        ClassWebinar $class,
        ClassTopic $topic
    ) {
        try {
            $data = $request->all();
            
            if (empty(@$data['ar']['topic_title'])) {
                unset($data['ar']);
            }
            if (empty(@$data['sub_topics'])) {
                unset($data['sub_topics']);
            }
            if (empty(@$data['sub_topics_ar'])) {
                unset($data['sub_topics_ar']);
            }

            $topic = $this->classTopicRepository->updateTopic($data, $topic->id);
            return new TopicResource($topic);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param ClassWebinar $class 
     * @param ClassTopic   $topic 
     * 
     * @return void
     */
    public function destroy(
        ClassWebinar $class,
        ClassTopic $topic
    ) {
        try {
            $topic = $this->classTopicRepository->deleteTopic($topic->id);
            return $this->apiDeleteResponse();
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

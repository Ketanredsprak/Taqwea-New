<?php
namespace App\Repositories;

use App\Models\ClassSubTopic;
use App\Models\ClassTopic;
use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;

class ClassSubTopicRepository extends BaseRepository
{

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return ClassSubTopic::class;
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
     * Method createTopic
     *
     * @param array $data    [explicite description]
     * @param int   $topicId [explicite description]
     *
     * @return void
     */
    public function createSubTopics(array $data, int $topicId)
    {   
        
        if (!empty($data['sub_topics'])) {
            foreach ($data['sub_topics'] as $subTopic) {
                if (!empty($subTopic) && !empty($topicId)) {
                    $subTopicData = [
                        'class_topic_id' => $topicId,
                        'en' => ['sub_topic' => $subTopic]
                    ];
                    $this->create($subTopicData);
                }
            }
        }
        if (!empty($data['sub_topics'])) {
            foreach ($data['sub_topics'] as $subTopicAr) {
                if (!empty($subTopicAr) && !empty($topicId)) {
                    $subTopicArData = [
                        'class_topic_id' => $topicId,
                        'ar' => ['sub_topic' => $subTopicAr]
                    ];
                    $this->create($subTopicArData);
                }
            }
        }          
    }
    
    /**
     * Method deleteTopics
     *
     * @param int $topicId [explicite description]
     *
     * @return int
     */
    public function deleteTopics(int $topicId):int
    {
        return $this->where('class_topic_id', $topicId)->delete();
    }

    /**
     * Method deleteTopic
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteTopic(int $id): int
    {
        return $this->where('id', $id)->delete();
    }
}
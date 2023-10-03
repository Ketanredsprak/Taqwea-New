<?php
namespace App\Repositories;

use App\Models\ClassTopic;
use Exception;
use Illuminate\Support\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;

class ClassTopicRepository extends BaseRepository
{

    protected $subTopicRepository;

    /**
     * Method __construct
     *
     * @param Application             $app 
     * @param ClassSubTopicRepository $subTopicRepository 
     * 
     * @return void
     */
    public function __construct(
        Application $app,
        ClassSubTopicRepository $subTopicRepository
    ) {
        parent::__construct($app);
        $this->subTopicRepository = $subTopicRepository;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return ClassTopic::class;
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
     * Method getTopics
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getTopics(array $params = [])
    {
        $size = $params['size'] ?? config('repository.pagination.limit');
        $query =  $this->orderBy('id', 'ASC');//$this->withTranslation();
        if (@$params['class_id']) {
            $query->where('class_id', $params['class_id']);
        }
       
        return $query->paginate($size);
    }
    
    /**
     * Method getTopic
     *
     * @param int $id [explicite description]
     *
     * @return ClassTopic
     */
    public function getTopic(int $id)
    {
        return $this->find($id);
    }
    
    /**
     * Method createTopic
     *
     * @param array $data [explicite description]
     *
     * @return ClassTopic
     */
    public function createTopic(array $data):ClassTopic
    {   
        try {
            DB::beginTransaction();

            $topic = $this->create($data);
            $this->subTopicRepository->createSubTopics($data, $topic->id);
            DB::commit();
            return $topic;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Method updateTopic
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return ClassTopic
     */
    public function updateTopic(array $data, int $id):ClassTopic
    {   
        try {
            DB::beginTransaction();

            $topic = $this->update($data, $id);
            $this->subTopicRepository->deleteTopics($id);
            $this->subTopicRepository->createSubTopics($data, $id);
            DB::commit();
            return $topic;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }
    
    /**
     * Method deleteTopic
     *
     * @param int $id [explicite description]
     *
     * @return int
     */
    public function deleteTopic(int $id):int
    {
        return $this->delete($id);
    }
}
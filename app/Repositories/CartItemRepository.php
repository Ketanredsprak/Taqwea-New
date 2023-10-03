<?php

namespace App\Repositories;

use App\Models\CartItem;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use App\Repositories\ClassRepository;
use Exception;

/**
 * CartRepository
 */
class CartItemRepository extends BaseRepository
{
    protected $classRepository;

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return CartItem::class;
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
     * Function __construct
     * 
     * @param Application     $app 
     * @param ClassRepository $classRepository 
     * 
     * @return response 
     */
    public function __construct(Application $app, ClassRepository $classRepository)
    {
        parent::__construct($app);
        $this->classRepository = $classRepository;
    }

    /**
     * Create method
     *
     * @param array $data 
     * 
     * @return void
     */
    public function createItem(array $data)
    {
        $user = Auth::user();
        if (!empty($data['class_id'])) {
            $check = $this->checkClassExistInSameTime($user, $data);
            if (!empty($check)) {
                throw new Exception(trans('error.same_time_class_already_cart'));
            }
        }
        
        $this->create($data);
    }

    /**
     * Method delete Item
     *
     * @param int $id 
     * @param int $itemId  
     *
     * @return void
     */
    public function deleteItem(int $id, int $itemId): int
    {
        return $this->where(["cart_id" => $id, "id" => $itemId])
            ->delete();
    }

    /**
     * Method deleteBlogItem
     *
     * @param int $id 
     *
     * @return void
     */
    public function deleteBlogItem(int $id): int
    {
        return $this->where("blog_id", $id)
            ->delete();
    }

    /**
     * Function Check class already exist in same time add card
     * 
     * @param $user 
     * @param $data 
     * 
     * @return response
     */
    public function checkClassExistInSameTime($user, $data)
    {
        $class_data = $this->classRepository->find($data['class_id']);

        $query = $this->whereHas(
            'cart',
            function ($q) use ($user) {
                $q->where('user_id', $user->id);
            }
        )->whereHas(
            'classWebinar',
            function ($q) use ($class_data) {
                $q->where(
                    function ($query) use ($class_data) {
                        $query->whereRaw(
                            '`start_time` >= "' . $class_data['start_time'] . '" 
                                and `start_time` <= "' . $class_data['end_time'] . '"'
                        );
                    }
                );
                $q->orWhere(
                    function ($query) use ($class_data) {
                        $query->whereRaw(
                            '`end_time` >= "' . $class_data['start_time'] . '" 
                            and `end_time` <= "' . $class_data['end_time'] . '"'
                        );
                    }
                );
            }
        )->first();

        return $query;
    }
}

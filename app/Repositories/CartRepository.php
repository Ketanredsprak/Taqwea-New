<?php
namespace App\Repositories;

use App\Models\Cart;
use App\Models\ClassWebinar;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * CartRepository
 */
class CartRepository extends BaseRepository
{
    protected $cartItemRepository;
    
    /**
     * Method __construct
     *
     * @param Application        $app 
     * @param CartItemRepository $cartItemRepository 
     * 
     * @return void
     */
    public function __construct(
        Application $app,
        CartItemRepository $cartItemRepository
    ) {
        parent::__construct($app);
        $this->cartItemRepository = $cartItemRepository;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Cart::class;
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
     * Create Method
     *
     * @param array $data 
     * 
     * @return Boolean
     */
    public function createCart($data)
    {
        try {
            $user = Auth::user();
            $check = $this->checkItemExistInCart($user, $data);
            if (!empty($check)) {
                throw new Exception(trans('error.item_already_cart'));
            }

            if (!empty($data['class_id'])) {
                $class = ClassWebinar::where('id', $data['class_id'])->first();
                if (!$this->canAddClass($class)) {
                    throw new Exception(
                        __(
                            'error.class_booking_gender_wise',
                            [
                                "gender" => $class->gender_preference,
                                "class" => $class->class_type]
                        )
                    );
                }
            }
            
            DB::beginTransaction();
            $cart = $this->updateOrCreate(
                ['user_id' => $user->id],
                ['user_id' => $user->id]
            );
            if (!empty($cart)) {
                $data["cart_id"] = $cart->id;
                $this->cartItemRepository->createItem($data);
            }
            
            DB::commit();
            return true;
        } catch (Exception $e) {
            DB::rollback();
            throw $e;
        }
    }

    /**
     * Check item already exist in cart
     * 
     * @param $user 
     * @param $data 
     * 
     * @return Cart
     */
    public function checkItemExistInCart($user, $data)
    {
        return $this->where('user_id', $user->id)
            ->whereHas(
                'items', 
                function ($q) use ($data) {
                    if (!empty(@$data['class_id'])) {
                        $q->where('class_id', $data['class_id']);
                    }

                    if (!empty(@$data['blog_id'])) {
                        $q->where('blog_id', $data['blog_id']);
                    }
                }
            )
            ->first();
    }
    
    /**
     * Method canAddClass
     *
     * @param ClassWebinar $class [explicite description]
     *
     * @return bool
     */
    public function canAddClass(ClassWebinar $class):bool
    {
        if ($class && Auth::check()) {
            $userType = Auth::user()->gender;
            if ($class->gender_preference != 'both' && $userType != $class->gender_preference) {
                return false;
            }
        }
        return true;
    }

    /**
     * Get Method
     *
     * @param int $userId 
     * 
     * @return Object
     */
    public function getCart($userId)
    {
        return $this->where("user_id", $userId)->first();
    }

    /**
     * Delete user cart
     * 
     * @param int $userId 
     * 
     * @return bool 
     */
    public function deleteCart($userId)
    {
        return $this->where("user_id", $userId)->delete();
    }
}
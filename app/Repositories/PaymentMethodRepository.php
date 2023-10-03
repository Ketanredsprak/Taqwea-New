<?php

namespace App\Repositories;

use App\Models\PaymentMethod;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Support\Facades\Auth;
use App\Services\PaymentService;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use Exception;
/**
 * Class PaymentRepository
 */
class PaymentMethodRepository extends BaseRepository
{
    protected $paymentService;
    protected $entity_id_mada;
    protected $entity_id_master;

    /**
     * Method __construct
     *
     * @param PaymentService $paymentService 
     * @param Application    $app
     * @return void
     */
    public function __construct(
        PaymentService $paymentService,
        Application $app
    ) {
        parent::__construct($app);
        $this->paymentService = $paymentService;
        $this->entity_id_mada = config('app.hyper_pay_entity_id_mada');
        $this->entity_id_master = config('app.hyper_pay_entity_id_visa_master');
    }

    /**
     * Specify Model class name 
     *
     * @return string
     */
    function model()
    {
        return PaymentMethod::class;
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

    public function getCarts(array $params = [])
    {
        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->orderBy('id', 'DESC');
        if (Auth::check()) {
            $query->where("user_id", Auth::user()->id);
        }
        return $query->paginate($size);
    }
    /**
     * Method save cart
     * 
     * @param Array  $data 
     * @param bool   $cardSaveWithPayment 
     * @param Object $user  
     * 
     * @return Collection 
     */
    public function saveCard($data, $cardSaveWithPayment = true, $user = null)
    {
        if ($cardSaveWithPayment) {
            $data = $this->paymentService->storeCard($data);
        }

        if (!$user) {
            $user = Auth::user();
        }
        $data["user_id"] = $user->id;
        
        return $this->updateOrCreate(
            [
                "user_id" => $data["user_id"],
                "exp_month" => $data["exp_month"],
                "exp_year" => $data["exp_year"],
                "card_number" => $data["card_number"],
            ],
            $data
        );
    }

    /**
     * Method deleteCard
     * 
     * @param array $data  
     * @param int   $id 
     * 
     */
    public function deleteCard(array $data, $id)
    {
        DB::beginTransaction();
        $card = $this->find($id);
        if ($card) {
            $card->delete();
            $data['cardId'] = $card->card_id;
            $data['brand'] = $card->brand;
            $this->paymentService->deleteCard($data);
            DB::commit();
            return true;
        } else {
            DB::rollback();
            throw new Exception(trans('error.card_not_found'));
        }
    }

    /**
     * Method checkCard
     * 
     * @param Array $data 
     * 
     * @return object
     */
    public function checkCard($data): object
    {
        $query = $this->select('*');
        if (Auth::check()) {
            $query->where("user_id", Auth::user()->id);
        }

        if (!empty($data["cart_id"])) {
            $query->where("cart_id", $data["cart_id"]);
        }

        $result =  $query->first();

        if ($result) {
            return $result;
        }

        throw new Exception(trans('error.card_not_found'));
    }

    /**
     * Method generateCheckoutId
     * 
     * @param Array $params 
     * 
     * @return string 
     */
    public function generateCheckoutId($params = [])
    {
        return $this->paymentService->generateCheckoutId($params);
    }

    /**
     * Method getSaveCard
     * 
     * @param Array $data 
     * 
     * @return Bool
     */
    public function getSaveCard(array $data = []) 
    {
        $this->paymentService->getPaymentStatus($data);
    }
}

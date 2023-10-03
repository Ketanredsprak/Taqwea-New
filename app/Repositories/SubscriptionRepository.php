<?php

namespace App\Repositories;

use App\Models\Subscription;
use Illuminate\Container\Container as Application;
use Illuminate\Database\Eloquent\Collection;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Repositories\SubscriptionPriceRepository;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Interface Repository.
 *
 * @package SubscriptionRepository;
 */
class SubscriptionRepository extends BaseRepository
{
    protected $subscriptionPriceRepository;

    protected $tutorSubscriptionRepository;

    /**
     * Function __construct
     * 
     * @param Application                 $app   
     * @param SubscriptionPriceRepository $subscriptionPriceRepository 
     * 
     * @return void
     */
    public function __construct(
        Application $app,
        SubscriptionPriceRepository $subscriptionPriceRepository
    ) {
        parent::__construct($app);
        $this->subscriptionPriceRepository = $subscriptionPriceRepository;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return Subscription::class;
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
     * Function List
     * 
     * @param array $params [explicite description]
     * 
     * @return Collection
     */
    public function getSubscriptions(array $params = [])
    {
        $sortFields = [
            'id' => 'id',
            'blog' => 'blog',
            'commission' => 'commission',
            'featured' => 'featured',
            'webinar_hours' => 'webinar_hours',
            'class_hours' => 'class_hours',
            'allow_booking' => 'allow_booking',
            'amount' => 'amount',
            'subscription_name' => 'subscription_name',
            'subscription_description' => 'subscription_description',
            'status' => 'status',
        ];

        $limit = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->withTranslation();

        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            $user = Auth::user();
            $query->with(
                [
                    'activePlan' =>
                    function ($q) use ($user) {
                        $q->where('user_id', $user->id);
                        $q->where('status', 'active');
                    }
                ]
            );
        }

        if (!empty($params['status'])) {
            $query->where('status', $params['status']);
        }

        if (!empty($params['type_of_subscription'])) {
            $query->where('featured', $params['type_of_subscription']);
        }


        if (!empty($params['search'])) {
            $query->where(
                function ($qry) use ($params) {
                    $qry->whereTranslationLike(
                        'subscription_name',
                        "%" . $params['search'] . "%"
                    );
                }
            );
        }

        $sort = $sortFields['id'];
        $direction = 'ASC';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }

        if (in_array($sort, ['subscription_name', 'subscription_description'])) {
            $query->orderByTranslation($sort, $direction);
        } else {
            $query->orderBy($sort, $direction);
        }

        return $query->paginate($limit);
    }

    /**
     * Method updateSubscription 
     * 
     * @param Array $data 
     * @param int   $id 
     * 
     * @return Object
     */
    public function updateSubscription($data, $id)
    {
        return $this->update($data, $id);
    }

    /**
     * Method getSubscription
     * 
     * @param int   $id 
     * @param Array $params 
     * 
     * @return Subscription
     */
    public function getSubscription($id, Array $params = [])
    {
        $query = $this->where('id', $id);
        return $query->first();
    }

    /**
     * Method getDefaultSubscription
     * 
     * @return Array
     */
    public function getDefaultSubscription()
    {
        return $this->where('default_plan', 'Yes')->first();
    }
    
    /**
     * Method tutorActivePlan
     *
     * @param int $tutorId 
     * 
     * @return object
     */
    public function tutorActivePlan($tutorId)
    {

    }
    
}

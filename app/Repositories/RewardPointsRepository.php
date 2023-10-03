<?php
namespace App\Repositories;

use App\Models\RewardPoint;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Events\PointCreditDebitEvent;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class RewardPointsRepository extends BaseRepository
{
    

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return RewardPoint::class;
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
     * Method createRewardPoint
     * 
     * @param array $data [explicite description]
     * 
     * @return void
     */
    public function createRewardPoint($data)
    {      
       
        PointCreditDebitEvent::dispatch($data);
        
        if ($data['type'] == RewardPoint::TYPE_DEBIT) {
            $data['points'] = ('-'.$data['points']);
        }

        if ($data['type'] == RewardPoint::TYPE_REVERT) {
            $data['points'] = ('-'.$data['points']);
        }

        return $this->create($data);
    }

    /**
     * Get user available reward points
     * 
     * @param $userId 
     *  
     * @return String
     */
    public function userAvailablePoints($userId)
    {
        return $this->where(['user_id' => $userId])->sum('points');        
    }

    /**
     * Redeem reward points
     * 
     * @param int $userId [explicite description] 
     *  
     * @return String
     */
    public function redeemPoints($userId)
    {
        return $this->where('user_id', $userId)->sum('points');        
    }
}
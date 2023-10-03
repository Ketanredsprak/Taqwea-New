<?php
namespace App\Repositories;

use App\Models\Wallet;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use Illuminate\Container\Container as Application;
use Illuminate\Support\Facades\DB;
use Exception;

/**
 * WalletRepository
 */
class WalletRepository extends BaseRepository
{
    

    /**
     * Specify Model class name
     *
     * @return string
     */
    function model()
    {
        return Wallet::class;
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
     * @return Object
     */
    public function createWallet($data)
    {
        $dataArray = [
            "user_id" => $data['user_id'],
            "amount" => $data['amount'],
            "type" => (@$data['type'])? $data['type']: 'credit',
        ];
        return $this->create($dataArray);
    }

    /**
     * Method walletHistory
     * 
     * @param int $userId 
     * 
     * @return Object
     */
    public function walletHistory($userId)
    {
        $size = config('repository.pagination.limit');
        return $this->where("user_id", $userId)
            ->orderBy('id', 'DESC')
            ->paginate($size);
    }
}
<?php

namespace App\Repositories;

use App\Models\TutorPayout;
use Prettus\Repository\Criteria\RequestCriteria;
use Prettus\Repository\Eloquent\BaseRepository;
use App\Services\PaymentService;
use Illuminate\Container\Container as Application;
use App\Repositories\UserRepository;
use App\Models\TransactionItem;
use App\Models\User;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Mail\AccountantPayOutTutor;
use App\Events\UpdateIsFineCollectedForTutorPayOutEvent;

/**
 * TutorPayoutRepository
 */
class TutorPayoutRepository extends BaseRepository
{
    protected $paymentService;

    protected $userRepository;

    /**
     * Method __construct
     *
     * @param Application    $app
     * @param PaymentService $paymentService
     *
     * @return void
     */
    public function __construct(
        Application $app,
        PaymentService $paymentService,
        UserRepository $userRepository
    ) {
        parent::__construct($app);
        $this->paymentService = $paymentService;
        $this->userRepository = $userRepository;
    }

    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return TutorPayout::class;
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
     * Method payoutCreate
     *
     * @param array $param
     *
     * @return Object|Array
     */
    public function payoutCreate($param)
    {
        return $this->create($param);
    }

    /**
     * Method payoutUpdate
     *
     * @param array $params
     *
     * @return Object|Array
     */
    public function payoutUpdate($params, $id)
    {
        $payoutUpdate = $this->update($params, $id);
        // update the is_fine_collected for tutor
        if (isset($params['status']) && TutorPayout::STATUS_SUCCESS == $params['status']) {
            $payout = $this->find($id);
            UpdateIsFineCollectedForTutorPayOutEvent::dispatch($payout);
        }

        return $payoutUpdate;
    }

    /**
     * Method payNow
     *
     * @param array $params
     *
     * @return Object|array
     */
    public function payNow($params)
    {
        $id = $params['id'];
        $user = $this->userRepository->findUser($id);
        $totalPaid = TutorPayout::totalPayout($id);
        $totalEarning = TransactionItem::totalEarning($id);
        $total_due = $totalEarning - $totalPaid;
        if (!$user) {
            throw new Exception(trans('message.user_not_found'));
        }
        if (!$user->tutor->account_number) {
            throw new Exception(trans('message.bank_account_details'));
        }
        if ($total_due < $params['amount']) {
            throw new Exception(trans('message.enter_valid_amount'));
        }
        $params['tutor_id'] = $id;
        $params['amount'] = $params['amount'];
        $params['name'] = $user->name;
        $params['account_id'] = $user->tutor->account_number;
        $params['account_number'] = $user->tutor->account_number;
        $params['bank_id_bic'] = $user->tutor->bank_code;
        $params['payout_beneficiary_address1'] = $user->tutor->address;
        $payout = $this->payoutCreate($params);
        if (Auth::user()->user_type == User::TYPE_ACCOUNTANT) {
            $params['email'] = $user->email;
            $emailTemplate = new AccountantPayOutTutor($params);
            sendMail($params['email'], $emailTemplate);
        }
        $params['transaction_id'] = $payout->id;
        $result = $this->paymentService->tutorPayOut($params);
        return $this->payoutUpdate($result, $payout->id);
    }

    /**
     * Get Payout List
     *
     * @param array $params
     * @param int   $id
     *
     * @return response
     */
    public function getPayoutList(array $params = [], $id)
    {
        $sortFields = [
            'id' => 'id',
            'transaction_id' => 'transaction_id',
            'account_number' => 'account_number',
            'created_at' => 'created_at',
            'amount' => 'amount',
            'status' => 'status'
        ];

        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->where(
            ['tutor_id' => $id]
        )
            ->select('tutor_payouts.*');

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }

        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }

        $query->orderBy($sort, $direction);

        return $query->paginate($size);
    }

    /**
     * Method getPayouts
     *
     * @param array $params
     *
     * @return array||object
     */
    public function getPayouts(array $params = [])
    {
        $size = $params['size'] ?? config('repository.pagination.limit');
        $query = $this->select('*');
        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            $query->where('tutor_id', Auth::user()->id);
        }
        return $query->paginate($size);
    }
}

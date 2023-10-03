<?php

namespace App\Http\Controllers\Web\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use App\Http\Resources\V1\ClassResource;
use App\Http\Resources\V1\PayoutResource;
use App\Http\Resources\V1\UserResource;
use App\Repositories\ClassRepository;
use App\Repositories\TutorPayoutRepository;
use App\Repositories\TransactionItemRepository;
use App\Models\TransactionItem;
use App\Models\Transaction;
use Exception;
use App\Models\TutorPayout;
use Illuminate\Support\Facades\DB;
use App\Http\Requests\Admin\PayoutRequest;
use App\Http\Resources\V1\EarningHistoryResource;
use App\Http\Requests\Admin\ManagePointRequest;
use App\Models\RewardPoint;
use App\Repositories\RewardPointsRepository;
use Illuminate\Support\Facades\Auth;


/**
 * TutorController class
 */
class TutorController extends Controller
{
    protected $userRepository;

    protected $classRepository;

    protected $tutorPayoutRepository;

    protected $transactionItemRepository;

    protected $rewardPointsRepository;
    /**
     * Method __construct
     * 
     * @param UserRepository $userRepository 
     * 
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        ClassRepository $classRepository,
        TutorPayoutRepository $tutorPayoutRepository,
        TransactionItemRepository $transactionItemRepository,
        RewardPointsRepository $rewardPointsRepository
    ) {
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
        $this->tutorPayoutRepository = $tutorPayoutRepository;
        $this->transactionItemRepository = $transactionItemRepository;
        $this->rewardPointsRepository = $rewardPointsRepository;
    }

    /**
     * Method index
     * 
     * @return void
     */
    public function index()
    {
        return view('accountant.tutors.index');
    }

    /**
     * Method show
     * 
     * @param $id $id
     * 
     * @return void
     */
    public function show($id)
    {
        $user = $this->userRepository->findUser($id);
        return view('accountant.tutors.tutor-view', compact('user'));
    }

    /**
     * Method tutorList
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function tutorList(Request $request)
    {
        $data = $this->userRepository->getUsers($request->all());
        return UserResource::collection($data);
    }

    /**
     * Method Pay Details List 
     *
     * @param Request $request [explicite description]
     * @param int     $id 
     *
     * @return AnonymousResourceCollection
     */
    public function payDetailsList(Request $request, $id)
    {
        $post = $request->all();
        $data = $this->tutorPayoutRepository->getPayoutList($post, $id);
        return PayoutResource::collection($data);
    }

    /**
     * Method payNowLoad
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function payNowLoad(int $id)
    {
        try {
            
            $totalPaid = TutorPayout::totalPayout($id);
            $totalEarning = TransactionItem::totalEarning($id);
            $totalFine = Transaction::totalFine($id);
            $user = $this->userRepository->findUser($id);
            $data["id"] = $id;
            $data["amount"] = str_replace(',', '', number_format(($totalEarning - $totalPaid - $totalFine), 2));
            $data["user"] = $user;
            $html = view('accountant.tutors.pay-now', $data)->render();
            return response()->json(
                ['success' => true, 'html' => $html]
            );
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }
    /**
     * Method payNow
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function payNow(PayoutRequest $request)
    {
        DB::beginTransaction();
        $params = $request->all();
        try {
            $this->tutorPayoutRepository->payNow($params);
            DB::commit();
            return response()->json(
                ['success' => true, 'message' => trans('message.tutor_pay_success')]
            );
        } catch (Exception $e) {
            DB::rollback();
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()], 400
            );
        }
    }

    /**
     * Method list
     *
     * @param Request $request [explicite description]
     * @param int     $id 
     *
     * @return AnonymousResourceCollection
     */
    public function earningHistoryList(Request $request, $id)
    {
        $post = $request->all();
        $data = $this->transactionItemRepository->getEarningList($id, $post);
        return EarningHistoryResource::collection($data);
    }

    /**
     * Method getManagePoint
     *
     * @param int $id 
     *
     * @return void
     */
    public function getPoint(int $id)
    {
        try {
            $data = $this->userRepository->findUser($id);
            $data['points'] = RewardPoint::getUserPoints($id);
            $html = view('accountant.tutors.manage-point', compact('data'))->render();
            return response()->json(
                ['success' => true, 'html' => $html]
            );
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Method manage point
     *
     * @param ManagePointRequest $request 
     *
     * @return void 
     */
    public function managePoint(ManagePointRequest $request)
    {
        try {
            $param = $request->all();
            $param['from_id'] = Auth::user()->id;

            if ($param['type'] == RewardPoint::TYPE_REVERT) {
                $userPoints = RewardPoint::where('user_id', $param['user_id'])->sum('points');
               
                if ($userPoints < $param['points']) {
                    return response()->json(
                        ['success' => false, 'message' =>trans('error.invalid_points')], 400
                    );
                }
            }

            $result = $this->rewardPointsRepository->createRewardPoint($param);
            
                
            if (!empty($result)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.add_points')]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()], 400
            );
        }

    }
}

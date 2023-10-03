<?php

namespace App\Http\Controllers\Web\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\ClassRepository;
use App\Repositories\TransactionItemRepository;
use App\Repositories\TutorSubscriptionRepository;
use App\Repositories\ClassRefundRequestRepository;
use App\Models\User;

/**
 * DashboardController class 
 */
class DashboardController extends Controller
{
    protected $userRepository;
    protected $classRepository;
    protected $transactionItemRepository;
    protected $tutorSubscriptionRepository;
    protected $classRefundRequestRepository;

    /**
     * Function __construct
     * 
     * @param UserRepository               $userRepository 
     * @param ClassRepository              $classRepository 
     * @param TransactionItemRepository    $transactionItemRepository 
     * @param TutorSubscriptionRepository  $tutorSubscriptionRepository 
     * @param ClassRefundRequestRepository $classRefundRequestRepository 
     * 
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        ClassRepository $classRepository,
        TransactionItemRepository $transactionItemRepository,
        TutorSubscriptionRepository $tutorSubscriptionRepository,
        ClassRefundRequestRepository $classRefundRequestRepository
    ) {
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
        $this->transactionItemRepository = $transactionItemRepository;
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
        $this->classRefundRequestRepository = $classRefundRequestRepository;
    }

    /**
     * Function index
     * 
     * @return void
     */
    public function index()
    {
        $recentTutors = $this->tutorSubscriptionRepository->getRecentUsers(true);
        $recentStudents = $this->classRefundRequestRepository->getRecentStudents();
        $usersThisMonth = $this->userRepository->getDashboardCount('month');
        $usersOverAll = $this->userRepository->getDashboardCount();
        $classThisMonth = $this->classRepository->getDashboardCount('month');
        $classOverAll = $this->classRepository->getDashboardCount();
        return view(
            'accountant.dashboard.index',
            compact(
                'recentTutors',
                'recentStudents',
                'usersThisMonth',
                'usersOverAll',
                'classThisMonth',
                'classOverAll'
            )
        );
    }

    /**
     * Function dashboardChart 
     * 
     * @param Request $request 
     * 
     * @return response
     */
    public function dashboardChart(Request $request)
    {
        $data['class'] = $this
            ->transactionItemRepository->dashboardClassCount($request);
        $data['webinar'] = $this
            ->transactionItemRepository->dashboardWebinarCount($request);
        $data['blog'] = $this
            ->transactionItemRepository->dashboardBlogCount($request);
        return response()->json($data);
    }
}

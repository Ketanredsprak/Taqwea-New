<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Models\User;
use App\Repositories\ClassRepository;
use App\Repositories\UserRepository;
use App\Repositories\TransactionItemRepository;
use Illuminate\View\View;
use Illuminate\Http\Request;

/**
 * DashboardController class
 */
class DashboardController extends Controller
{
    protected $userRepository;

    protected $classRepository;

    protected $transactionItemRepository;

    /**
     * Function __construct
     * 
     * @param UserRepository            $userRepository 
     * @param ClassRepository           $classRepository 
     * @param TransactionItemRepository $transactionItemRepository 
     * 
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        ClassRepository $classRepository,
        TransactionItemRepository $transactionItemRepository
    ) {
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
        $this->transactionItemRepository = $transactionItemRepository;
    }

    /**
     * Function index
     *
     * @return View
     */
    public function index()
    {
        $recentTutors = $this->userRepository->getRecentUsers(
            User::TYPE_TUTOR
        );
        $recentStudents = $this->userRepository->getRecentUsers(
            User::TYPE_STUDENT
        );
        $usersThisMonth = $this->userRepository->getDashboardCount('month');
        $usersOverAll = $this->userRepository->getDashboardCount();
        $classThisMonth = $this->classRepository->getDashboardCount('month');
        $classOverAll = $this->classRepository->getDashboardCount();
        return view(
            'admin.dashboard.index',
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

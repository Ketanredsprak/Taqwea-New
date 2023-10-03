<?php

namespace App\Http\Controllers\Web\Admin;

use App\Exports\StudentExportCsv;
use App\Exports\TutorExportCsv;
use App\Exports\ClassExportCsv;
use App\Exports\BlogExportCsv;
use App\Exports\WebinarExportCsv;
use App\Exports\RevenueExportCsv;
use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ClassResource;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use App\Repositories\ClassRepository;
use App\Repositories\BlogRepository;
use App\Http\Resources\V1\UserResource;
use App\Http\Resources\V1\BlogResource;
use App\Http\Resources\V1\RevenueResources;
use App\Repositories\SubscriptionRepository;
use Maatwebsite\Excel\Facades\Excel;
use App\Repositories\TransactionItemRepository;
use App\Repositories\TransactionRepository;
use Carbon\Carbon;
use Exception;

/**
 * ReportController class
 */
class ReportController extends Controller
{
    protected $userRepository;
    protected $classRepository;
    protected $blogRepository;
    protected $subscriptionRepository;
    protected $transactionItemRepository;
    protected $transactionRepository;

    /**
     * Function __construct
     * 
     * @param UserRepository            $userRepository 
     * @param ClassRepository           $classRepository 
     * @param BlogRepository            $blogRepository 
     * @param SubscriptionRepository    $subscriptionRepository 
     * @param TransactionItemRepository $transactionItemRepository 
     * @param TransactionRepository     $transactionRepository 
     * 
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        ClassRepository $classRepository,
        BlogRepository $blogRepository,
        SubscriptionRepository $subscriptionRepository,
        TransactionItemRepository $transactionItemRepository,
        TransactionRepository     $transactionRepository
    ) {
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
        $this->blogRepository = $blogRepository;
        $this->subscriptionRepository = $subscriptionRepository;
        $this->transactionItemRepository = $transactionItemRepository;
        $this->transactionRepository = $transactionRepository;
    }

    /**
     * Function StudentReport
     * 
     * @return void
     */
    public function studentReport()
    {
        return View('admin.reports.student-report');
    }

    /**
     * Function Report
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function reportList(Request $request)
    {
        try {
            $data = $this->userRepository->getUsers($request->all());
            return UserResource::collection($data);
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * StudentExportCsv function all student details 
     * 
     * @param Request $request 
     *  
     * @return void
     */
    public function studentExportCsv(Request $request)
    {
        try {
            $studentExport = new StudentExportCsv($this->userRepository, $request);
            return Excel::download($studentExport, 'student-reports.csv');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Function TutorReport
     * 
     * @return void
     */
    public function tutorReport()
    {
        $subscriptions = $this->subscriptionRepository->get();
        return View('admin.reports.tutor-report', compact('subscriptions'));
    }

    /**
     * TutorExportCsv function all tutor details 
     *  
     * @param Request $request 
     * 
     * @return void
     */
    public function tutorExportCsv(Request $request)
    {
        try {
            $tutorExportCvs = new TutorExportCsv($this->userRepository, $request);
            return Excel::download($tutorExportCvs, 'tutor-reports.csv');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Function ClassReport
     * 
     * @return view
     */
    public function classReport()
    {
        return View('admin.reports.class-report');
    }

    /**
     * Function ClassReportList
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function classReportList(Request $request)
    {
        try {
            $classes = $this->classRepository->getClasses($request->all());
            return ClassResource::collection($classes);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * ClassExportCsv function all tutor details 
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function classExportCsv(Request $request)
    {
        try {
            $classExportCvs = new ClassExportCsv($this->classRepository, $request);
            return Excel::download($classExportCvs, 'classe-reports.csv');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Function BlogReport
     * 
     * @return view
     */
    public function blogReport()
    {
        return View('admin.reports.blog-report');
    }

    /**
     * Function BlogReportList
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function blogReportList(Request $request)
    {
        try {
            $blogs = $this->blogRepository->getBlogs($request->all());
            return BlogResource::collection($blogs);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * BlogExportCsv function all tutor details 
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function blogExportCsv(Request $request)
    {
        try {
            $blogExport =  new BlogExportCsv($request, $this->blogRepository);
            return Excel::download(
                $blogExport,
                'blog-reports.csv'
            );
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * Function WebinarReport
     * 
     * @return view
     */
    public function webinarReport()
    {
        return View('admin.reports.webinar-report');
    }

    /**
     * Function WebinarReportList
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function webinarReportList(Request $request)
    {
        try {
            $webinar = $this->classRepository->getClasses($request->all());
            return ClassResource::collection($webinar);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * WebinarExportCsv function all tutor details 
     * 
     * @param Request $request  
     * 
     * @return void
     */
    public function webinarExportCsv(Request $request)
    {
        try {
            $webinarExport = new WebinarExportCsv($this->classRepository, $request);
            return Excel::download($webinarExport, 'webinar-reports.csv');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }


    /**
     * Function RevenueReport
     * 
     * @return view
     */
    public function revenueReport()
    {
        return View('admin.reports.revenue-report');
    }

    /**
     * Function RevenueReportList
     * 
     * @param Request $request 
     * 
     * @return collection
     */
    public function revenueReportList(Request $request)
    {
        try {
            $param['year'] = $request->year ? $request->year : Carbon::now()->year;
            $revenue = $this->transactionRepository->revenueReport($param);
            return RevenueResources::collection($revenue);
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }

    /**
     * RevenueExportCsv function all tutor details 
     * 
     * @param Request $request  
     * 
     * @return void
     */
    public function revenueExportCsv(Request $request)
    {
        try {
            $revenueExport = new RevenueExportCsv(
                $this->transactionRepository,
                $request
            );
            return Excel::download($revenueExport, 'revenue-reports.csv');
        } catch (Exception $ex) {
            return $ex->getMessage();
        }
    }
}

<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ClassResource;
use App\Http\Resources\V1\ClassBookingResource;
use App\Models\Category;
use App\Models\ClassBooking;
use App\Models\ClassWebinar;
use App\Repositories\CategoryRepository;
use App\Repositories\ClassRepository;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\ClassBookingRepository;
use Exception;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
use Illuminate\View\View;

class ClassController extends Controller
{
    protected $classRepository;
    protected $classBookingRepository;

    protected $categoryRepository;

    protected $gradeRepository;

    protected $subjectRepository;

    /**
     * Method __construct
     *
     * @param ClassRepository        $classRepository       
     * @param CategoryRepository     $categoryRepository     
     * @param GradeRepository        $gradeRepository       
     * @param SubjectRepository      $subjectRepository      
     * @param ClassBookingRepository $classBookingRepository 
     * 
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository,
        CategoryRepository $categoryRepository,
        GradeRepository $gradeRepository,
        SubjectRepository $subjectRepository,
        ClassBookingRepository $classBookingRepository
    ) {
        $this->classRepository = $classRepository;
        $this->categoryRepository = $categoryRepository;
        $this->gradeRepository = $gradeRepository;
        $this->subjectRepository = $subjectRepository;
        $this->classBookingRepository = $classBookingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function index()
    {
        $category = $this->categoryRepository
            ->getByHandle(Category::HANDLE_EDUCATION);
        $params['parent_id'] = $category->id;
        $levels = $this->categoryRepository->getCategories($params);
        $grades = $this->gradeRepository->getAll();
        $subjects = $this->subjectRepository->getAll();
        return view(
            'admin.classes.index',
            compact(
                'levels',
                'grades',
                'subjects'
            )
        );
    }

    /**
     * Show the form for creating a new resource.
     *
     * @param Request $request 
     * 
     * @return View
     */
    public function create(Request $request)
    {
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param Request $request 
     * 
     * @return JsonResponse
     */
    public function store(Request $request)
    {
    }

    /**
     * Display the specified resource.
     *
     * @param ClassWebinar $class 
     * 
     * @return \Illuminate\Http\Response
     */
    public function show(ClassWebinar $class)
    {
        $class = $this->classRepository->getClass($class->id);
        return view(
            'admin.classes.view',
            compact('class')
        );
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param Request $request 
     * @param int     $category 
     * 
     * @return View
     */
    public function edit(Request $request, int $category)
    {
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request 
     * @param int     $class 
     * 
     * @return JsonResponse
     */
    public function update(Request $request, int $class)
    {
        try {
            $data = $request->all();
            $result = $this->classRepository->updateClass($data, $class);
            return $this->apiSuccessResponse($result);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id 
     * 
     * @return JsonResponse
     */
    public function destroy($id)
    {
    }

    /**
     * Method list
     *
     * @param Request $request [explicite description]
     *
     * @return AnonymousResourceCollection
     */
    public function list(Request $request): AnonymousResourceCollection
    {
        $params = $request->all();
        $classes = $this->classRepository->getClasses($params);
        return ClassResource::collection($classes);
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function webinar()
    {
        $category = $this->categoryRepository
            ->getByHandle(Category::HANDLE_EDUCATION);
        $params['parent_id'] = $category->id;
        $levels = $this->categoryRepository->getCategories($params);
        $grades = $this->gradeRepository->getAll();
        $subjects = $this->subjectRepository->getAll();
        return view(
            'admin.classes.webinar',
            compact(
                'levels',
                'grades',
                'subjects'
            )
        );
    }

    /**
     * Display a listing of the resource.
     *
     * @return View
     */
    public function bookings()
    {
        $params['classType'] = 'class';
        $params['title'] = 'Booked Class';
        return view('admin.classes.bookings', $params);
    }

    /**
     * Method bookingsWebinar
     *
     * @return View
     */
    public function bookingsWebinar()
    {
        $params['classType'] = 'webinar';
        $params['title'] = 'Booked Webinar';
        return view('admin.classes.bookings', $params);
    }

    /**
     * Method classBookingList
     * 
     * @param Request $request 
     * 
     * @return AnonymousResourceCollection
     */
    public function classBookingList(Request $request): AnonymousResourceCollection
    {
        $params = $request->all();
        $bookings = $this->classBookingRepository->getBookings($params);
        return ClassBookingResource::collection($bookings);
    }

    /**
     * Display the specified resource.
     *
     * @param $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function showBookingClasses($id)
    {
        $class = $this->classBookingRepository->getBooking($id);
        return view(
            'admin.classes.booking-view',
            compact('class')
        );
    }

    /**
     * Function Booking Class List
     * 
     * @param Request $request 
     * @param int     $id 
     * 
     * @return collection
     */
    public function bookingClassList(Request $request, $id)
    {
        $bookingClasses = $this->classBookingRepository->getBooking($id);
        return ClassBookingResource::collection($bookingClasses);
    }
}

<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Http\Requests\Student\ClassRequestRequest;
use App\Models\Category;
use App\Models\ClassRequestDetail;
use App\Models\Grade;
use App\Models\Subject;
use App\Repositories\CategoryRepository;
use App\Repositories\ClassRequestDetailRepository;
use App\Repositories\ClassRequestRepository;
use App\Repositories\TutorClassRequestRepository;
use App\Repositories\TutorRequestRepositoty;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ClassRequestController extends Controller
{

    protected $classRequestRepository;
    protected $classRequestDetailRepository;
    protected $userRepository;
    protected $tutorRequestRepositoty;
    protected $categoryRepository;
    protected $tutorClassRequestRepository;
    /**
     * Function __construct
     *
     * @param ClassRequestRepository $classRequestRepository [explicite description]
     * @param ClassRequestDetailRepository     $classRequestDetailRepository
     * @param UserRepository     $userRepository
     * @param TutorRequestRepositoty     $tutorRequestRepositoty
     * @param TutorClassRequestRepository $tutorClassRequestRepository [explicite description]
     *
     * @return void
     */
    public function __construct(
        ClassRequestRepository $classRequestRepository,
        ClassRequestDetailRepository $classRequestDetailRepository,
        UserRepository $userRepository,
        TutorRequestRepositoty $tutorRequestRepositoty,
        CategoryRepository $categoryRepository,
        TutorClassRequestRepository $tutorClassRequestRepository
    ) {
        $this->classRequestRepository = $classRequestRepository;
        $this->classRequestDetailRepository = $classRequestDetailRepository;
        $this->userRepository = $userRepository;
        $this->tutorRequestRepositoty = $tutorRequestRepositoty;
        $this->categoryRepository = $categoryRepository;
        $this->tutorClassRequestRepository = $tutorClassRequestRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $params['currentPage'] = 'classRequest';
        $params['title'] = trans("labels.class_request");
        return view('frontend.student.class-request.index', $params);

    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //

        $subject_data = Subject::withTranslation()->get();
        //return $class_topic =  ClassTopic::withTranslation()->get();
        $levels = Category::withTranslation()->get();
        $grades = Grade::withTranslation()->get();

        $data['currentPage'] = 'classRequest';
        $data['title'] = trans("labels.class_request");
        $data['subject_data'] = $subject_data;
        $data['levels'] = $levels;
        $data['grades'] = $grades;
        $data['categories'] = $this->categoryRepository->getParentCategories();

        return view('frontend.student.class-request.create', $data);

    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(ClassRequestRequest $request)
    {

        try {
            $post = $request->all();
            $timezone = $request->header('time-zone');
            $post['class'] = $post['class'] ?? null;
            $post['class_date'] = $post['class_date'] ?? null;
            // $post['request_time'] = Carbon::now();
            // $post['expired_time'] = Carbon::now()->addMinute('10');
            $post['status'] = "Active";
            $post['user_id'] = Auth::user()->id;
            $post['preferred_gender'] = $post['gender_preference'];
            $post['class_duration'] = $post['class_duration'] * 60;

            $this->classRequestRepository->startTimeCheck($post, $timezone);

            // get tutor list
            $tutors = $this->userRepository
                ->getTutors($post);

            if ($tutors) {
                $result = $this->classRequestRepository->createClassRequest($post);
                if (!empty($result)) {
                    $result1 = $this->tutorRequestRepositoty->createTutorRequest($result, $tutors);
                    if (!empty($result1)) {
                        return response()->json(
                            [
                                'success' => true,
                                'message' => trans('message.Notification Send'),
                                '200',
                            ]
                        );
                    }
                }
            } else {
                return response()->json(
                    ['success' => false, 'message' => "No Tutor Found"]
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
        // return $id;

        try {
            $result = $this->classRequestRepository->getClassRequest($id, '', false);
            if (!empty($result)) {

               
                $subject_data = Subject::withTranslation()->where('id', $result->subject_id)->first();
                $level = Category::withTranslation()->where('id', $result->level_id)->first();
                $grade = Grade::withTranslation()->where('id', $result->grade_id)->first();

                $class_details = ClassRequestDetail::where('class_request_id', $result->id)->get();

                $data['currentPage'] = 'classRequest';
                $data['title'] = trans("labels.class_request");
                $data['subject_data'] = $subject_data;
                $data['level'] = $level;
                $data['grade'] = $grade;
                $data['result'] = $result;
                $data['class_details'] = $class_details;

                return view('frontend.student.class-request.show', $data);
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }

    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function classRequestList(Request $request)
    {
        try {
            $userId = Auth::user()->id;
            $classrequest = $this->classRequestRepository->getAll($userId);
            $html = view(
                'frontend.student.class-request.list',
                ['classrequests' => $classrequest]
            )->render();
            return $this->apiSuccessResponse($html, trans('labels.classrequest_list'));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }

    }

    public function gettutorrequestget($id)
    {

        $params['currentPage'] = 'classRequest';
        $params['title'] = trans("labels.class_request");
        $params['id'] = $id;
        $datas = $this->tutorClassRequestRepository->getAll($id);
        $params['datas'] = $datas;
        return view('frontend.student.tutor-class-request.index', $params);

    }

    public function rejectrequest($id)
    {
        try {
            $post['status'] = 2;
            $result = $this->tutorClassRequestRepository->tutorrequestreject($post, $id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.tutor_reject'),
                    ]
                );
                return $this->apiSuccessResponse([], trans('message.update_profile'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    public function acceptrequest($id)
    {
        try {
            $post['status'] = 1;
            $result = $this->tutorClassRequestRepository->tutorRequestAccept($post, $id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.tutor_accept'),
                    ]
                );
                return $this->apiSuccessResponse([], trans('message.update_profile'));
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    public function showtutordetail($id)
    {
        //    return $id;
        $params['currentPage'] = 'classRequest';
        $params['title'] = trans("labels.class_request");
        $user = $this->userRepository->findUser($id);
        $params['user'] = $user;

        return view('frontend.student.tutor-class-request.tutor-detail', $params);
    }

}

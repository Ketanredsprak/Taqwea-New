<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use App\Repositories\ClassRepository;
use App\Repositories\CategoryRepository;
use App\Repositories\GradeRepository;
use App\Repositories\SubjectRepository;
use App\Repositories\TransactionRepository;
use Illuminate\Http\Request;
use Exception;
use Session;
use Carbon\Carbon;
use App\Repositories\ThreadRepository;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx\Rels;

/**
 * Class for student message operation
 */
class MessageController extends Controller
{
    protected $classRepository;
    protected $categoryRepository;
    protected $gradeRepository;

    /**
     * Method __construct
     *
     * @param ClassRepository       $classRepository    
     * @param CategoryRepository    $categoryRepository 
     * @param GradeRepository       $gradeRepository 
     * @param SubjectRepository     $subjectRepository    
     * @param TransactionRepository $transactionRepository 
     * @param ThreadRepository      $threadRepository 
     *
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository,
        CategoryRepository $categoryRepository,
        GradeRepository $gradeRepository,
        SubjectRepository $subjectRepository,
        TransactionRepository $transactionRepository,
        ThreadRepository $threadRepository
    ) {
        $this->classRepository = $classRepository;
        $this->categoryRepository = $categoryRepository;
        $this->gradeRepository = $gradeRepository;
        $this->subjectRepository = $subjectRepository;
        $this->transactionRepository = $transactionRepository;
        $this->threadRepository = $threadRepository;
    }

    /**
     *  Show webinars
     *
     * @param Request $request 
     * 
     * @return View
     */
    public function index(Request $request)
    {
       
        $data['class_type'] = 'class';
        $data['title'] = __('labels.chat');
        $params["class_id"] = $request->class;
        $threadRecord = $this->threadRepository->getThread($params);
        if ($threadRecord && $params["class_id"]) {
            $data["uuid"] = $threadRecord->uuid;
        }
        return view('frontend.student.message.index', $data);
    }

    /**
     * Method detail
     *
     * @param \Illuminate\Http\Request $request [explicite description]
     *
     * @return Json
     */
    public function detail(Request $request)
    {
        try {
            $data = [];

            if (isset($request->uuid) && !empty($request->uuid)) {
                $data['uuid'] = $request->uuid;
            }

            $data = $this->threadRepository->getMessageDetail($data);

            $html = view(
                'frontend.student.message.right-pannel',
                [
                    'data' => $data,
                ]
            )->render();
            return $this->apiSuccessResponse($html, '');
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method list
     * 
     * @param Request $request 
     * 
     * @return Json
     */
    public function list(Request $request)
    {
        try {
            $params = $request->all();
            $messageList = $this->threadRepository->getMessageList($params);
            $html = view(
                'frontend.student.message.left-pannel',
                compact('messageList')
            )->render();
            
            return $this->apiSuccessResponse($html, '');
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

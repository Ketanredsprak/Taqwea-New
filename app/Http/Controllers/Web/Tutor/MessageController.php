<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use App\Repositories\ThreadRepository;
use Illuminate\Http\Request;
use Exception;
use Session;
use Carbon\Carbon;

/**
 * Class for tutor message operation
 */
class MessageController extends Controller
{
    protected $threadRepository;


    /**
     * Method __construct
     *
     * @param ThreadRepository $threadRepository 
     *
     * @return void
     */
    public function __construct(
        ThreadRepository $threadRepository
    ) {
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
        $params['group_by'] = true;
        $threadParams["class_id"] = $request->class;

        /**
         * Get first thread user
         * 
         * @var object $threadRecord 
         */
        $threadRecord = $this->threadRepository->getThread($threadParams);
        if ($threadRecord && $threadParams["class_id"]) {
            $data["uuid"] = $threadRecord->uuid;
            $data["student_id"] = $threadRecord->student_id;
            $data["class_id"] = $threadParams["class_id"];
        }
        $data['messageList'] = $this->threadRepository->getMessageList($params);
        
        return view('frontend.tutor.message.index', $data);
    }
    /**
     * Method detail
     *
     * @param Request $request 
     * @param int     $uuid 
     * @param int     $studentId 
     *
     * @return Json
     */
    public function detail(Request $request,$uuid, $studentId)
    {
        try {
            $data = [];

            if (isset($uuid) && !empty($uuid)) {
                $data['uuid'] = $uuid;
            } 
            
            if (isset($studentId) && !empty($studentId)) {
                $data['studentId'] = $studentId;
            }
            
            $data = $this->threadRepository->getMessageDetail($data);

            $html = view(
                'frontend.tutor.message.right-pannel',
                [
                    'data' => $data,
                ]
            )->render();
            return $this->apiSuccessResponse($html, trans('message.class_list'));
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
                'frontend.tutor.message.left-pannel',
                compact('messageList')
            )->render();
            
            return $this->apiSuccessResponse($html, '');
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Resources\V1\MessageThreadResource;
use App\Http\Resources\V1\MessageResource;
use App\Repositories\ThreadRepository;
use Illuminate\Support\Facades\Auth;

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
     * Display a listing of the resource.
     * 
     * @param Request $request 
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $data = $request->all();
            $messageList = $this->threadRepository->getMessageList($data);
            return MessageThreadResource::collection($messageList);
        } catch (\Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method detail
     *
     * @param int $uuid  
     * @param int $studentId 
     *
     * @return Json
     */
    public function messageDetail($uuid , $studentId = 0)
    {
        try {
            if (isset($uuid) && !empty($uuid)) {
                $data['uuid'] = $uuid;
            } 
            
            if (isset($studentId) && $studentId) {
                $data['studentId'] = $studentId;
            }

            $messageList = $this->threadRepository->getMessageDetail($data);
            return new MessageResource($messageList);
        } catch (\Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

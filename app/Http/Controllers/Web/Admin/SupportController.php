<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SupportRequestRepository;
use App\Http\Requests\Admin\SupportEmailRequest;
use Exception;

/**
 * SupportController class
 */
class SupportController extends Controller
{
    protected $supportRequestRepository;

    /**
     * Method __construct
     * 
     * @param SupportRequestRepository $supportRequestRepository 
     * 
     * @return void
     */
    public function __construct(SupportRequestRepository $supportRequestRepository)
    {
        $this->supportRequestRepository = $supportRequestRepository;
    }

    /**
     * Method index
     *
     * @return void
     */
    public function index()
    {
        return view('admin.support.help-support');
    }

    /**
     * Undocumented function
     *
     * @param $id $id 
     * 
     * @return void
     */
    public function showEmailMessage($id)
    {
        try {
            $data = $this->supportRequestRepository->find($id);

            return response()->json(
                [
                    'success' => true,
                    'data' => $data,
                    'message' => ''
                ]
            );
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function supportList 
     *
     * @param Request $request 
     * 
     * @return void
     */
    public function supportList(Request $request)
    {
        $data = $this->supportRequestRepository->listSupportRequest($request);
        $supportEmailList = [];
        if (!empty($data)) {
            foreach ($data as $result) {
                $supportEmailList[] = [
                    'id' => $result->id,
                    'name' => $result->name,
                    'email' => $result->email,
                    'message' => $result->message,

                ];
            }
        }
        return response()->json(
            ['data' => $supportEmailList, 'meta' => ['total' => $data->total()]]
        );
    }

    /**
     * Function EmailReply
     *
     * @param SupportEmailRequest $request 
     * 
     * @return void
     */
    public function emailReply(SupportEmailRequest $request)
    {
        try {
            return $this->supportRequestRepository->sendReply($request->all());
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }
}

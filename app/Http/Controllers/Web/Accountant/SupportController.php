<?php

namespace App\Http\Controllers\Web\Accountant;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SupportRequestRepository;
use App\Http\Requests\Admin\SupportEmailRequest;
use App\Http\Resources\V1\SupportResource;
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
        return view('accountant.supports.index');
    }

    /**
     * Function supportList 
     *
     * @param Request $request 
     * 
     * @return Collection
     */
    public function supportList(Request $request)
    {
        $data = $this->supportRequestRepository->listSupportRequest($request);
        return SupportResource::collection($data);
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

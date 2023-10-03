<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankRequest;
use App\Http\Resources\V1\BankResource;
use App\Repositories\BankRepository;
use Exception;
use Illuminate\Http\Request;

/**
 * BankController 
 */
class BankController extends Controller
{
    protected $bankRepository;

    /**
     * Function __construct
     *
     * @param BankRepository $bankRepository 
     *
     * @return void
     */
    public function __construct(BankRepository $bankRepository)
    {
        $this->bankRepository = $bankRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $banks = $this->bankRepository->getAll();
            if (!empty($banks)) {
                return BankResource::collection($banks);
            }

        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        try {
            $bankCode = $this->bankRepository->getById($id);
            if (!empty($bankCode)) {
                return $this->apiSuccessResponse([$bankCode], '');
            }

        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 404);
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id 
     * 
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}

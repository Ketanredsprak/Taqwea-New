<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\BankRequest;
use App\Http\Resources\V1\BankResource;
use App\Repositories\BankRepository;
use Exception;
use Illuminate\Http\Request;

/**
 * BankController Class
 */
class BankController extends Controller
{
    protected $bankRepository;

    /**
     * Method __Construct
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
    public function index(Request $request)
    {
        try {
            $data = $request->all();
            $banks = $this->bankRepository->getAllBanks($data);
            if ($request->ajax()) {
                return BankResource::collection($banks);
            }
            return view('admin.banks.index');
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {

        try {
            $bank = null;
            $view = view(
                'admin.banks.__addEditBankDetails',
                compact('bank')
            );
            return $view;
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param BankRequest $request
     *
     * @return \Illuminate\Http\Response
     */
    public function store(BankRequest $request)
    {
        try {
            $data = $request->all();
            $result = $this->bankRepository->createBankDetails($data);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.bank_detail_add'),
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
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
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        try {
            $bank = $this->bankRepository->getById($id);
            $view = view(
                'admin.banks.__addEditBankDetails',
                compact('bank')
            );
            return $view;
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param BankRequest $request
     * @param int $id
     *
     * @return \Illuminate\Http\Response
     */
    public function update(BankRequest $request, $id)
    {
        try {
            $data = $request->all();
            $result = $this->bankRepository->updateBankDetails($data, $id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.bank_detail_update'),
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
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
        try {
            $result = $this->bankRepository->deleteBankDetails($id);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.bank_detail_delete'),
                    ]
                );
            }
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 422);
        }
    }

    /**
     * Function UpdateStatus
     *
     * @param Request $request [explicite description]
     *
     * @return void
     */
    public function updateStatus(Request $request)
    {
        try {
            $data = $this->bankRepository->updateBankDetails(
                ['status' => $request->status],
                $request->id
            );
            if (!empty($data)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.update_status'),
                    ]
                );
            }
        } catch (\Exception$e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }
}

<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\Admin\CommissionRequest;
use App\Http\Requests\Admin\EditSettingRequest;
use App\Http\Requests\Admin\TopUpRequest;
use App\Repositories\SettingRepository;
use App\Repositories\TopUpRepository;
use Exception;

/**
 * SettingController class
 */
class SettingController extends Controller
{

    protected $settingRepository;
    protected $topUpRepository;

    /**
     * Function __construct
     * 
     * @param SettingRepository $settingRepository 
     * 
     * @return void 
     */
    public function __construct(
        SettingRepository $settingRepository,
        TopUpRepository $topUpRepository
    ) {
        $this->settingRepository = $settingRepository;
        $this->topUpRepository = $topUpRepository;
    }

    /**
     * Function index
     *
     * @return void
     */
    public function index()
    {
        return view('admin.settings.commission');
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
     * Function store
     *
     * @param CommissionRequest $request   
     * 
     * @return void
     */
    public function store(CommissionRequest  $request)
    {
        try {
            $data = $request->all();
            $result = $this->settingRepository->store($data);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.store_commission')
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
     * @param int $id 
     * 
     * @return void
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $id 
     * 
     * @return void
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param Request $request 
     * @param int     $id 
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

    /**
     * Method getSetting
     * 
     * @return void
     */
    public function getSetting()
    {
        return view('admin.settings.edit-setting');
    }

    /**
     * Function store
     *
     * @param EditSettingRequest $request   
     * 
     * @return void
     */
    public function storeSetting(EditSettingRequest  $request)
    {
        try {
            $data = $request->all();
            $result = $this->settingRepository->store($data);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.store_setting')
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
     * Method getTopUp
     * 
     * @return void
     */
    public function getTopUp()
    {
        $data = $this->topUpRepository->first();
        return view('admin.settings.top-up', compact('data'));
    }

    /**
     * Function store
     *
     * @param TopUpRequest $request   
     * 
     * @return void
     */
    public function updateTopUp(TopUpRequest $request)
    {
        try {
            $data = $request->all();
            $result = $this->topUpRepository->updateTopUp($data);
            if (!empty($result)) {
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.update_top_up')
                    ]
                );
            }
        } catch (Exception $e) {
            return response()->json(
                ['success' => false, 'message' => $e->getMessage()]
            );
        }
    }
}

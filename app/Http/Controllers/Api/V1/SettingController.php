<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\SettingRepository;
use Exception;

class SettingController extends Controller
{
     protected $settingRepository;

    /**
     * Function __construct
     * 
     * @param SettingRepository $settingRepository 
     * 
     * @return void 
     */
    public function __construct(SettingRepository $settingRepository)
    {
        $this->settingRepository = $settingRepository;
    }

    /**
     * Function index
     *
     * @return Json
     */
    public function index()
    {
        try {
            $data['vat'] = $this->settingRepository
                ->getSettings(["key" => 'vat']);
            $data['transaction_fee'] = $this->settingRepository
                ->getSettings(["key" => 'transaction_fee']);
            
            $data['commission'] = $this->settingRepository
                ->getSettings(["key" => 'commission']);
            return $this->apiSuccessResponse($data);
            
        } catch(Exception $e) {
            return $this->apiErrorResponse($e->getMessage());
        }
    }

}

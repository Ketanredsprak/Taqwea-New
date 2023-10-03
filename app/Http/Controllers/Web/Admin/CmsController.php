<?php

namespace App\Http\Controllers\Web\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\CmsRepository;
use App\Http\Requests\Admin\CmsPageRequest;
use Exception;

/**
 * CmsController class
 */
class CmsController extends Controller
{
    protected $cmsRepository;

    /**
     * Function __construct
     * 
     * @param $cmsRepository 
     * 
     * @return void
     */
    public function __construct(CmsRepository $cmsRepository)
    {
        $this->cmsRepository = $cmsRepository;
    }

    /**
     * Function Index 
     * 
     * @param $id 
     * 
     * @return view
     */
    public function index($id)
    {
        try {
            $result = $this->cmsRepository->getCms($id);
            if (!empty($result)) {
                return view('admin.cms.cms', compact('result'));
            }
            return with(["message" => "Data not found"]);
        } catch (Exception $e) {
            return $e->getMessage();
        }
    }

    /**
     * Function cmsUpdate 
     * 
     * @param Request $request 
     * 
     * @return void
     */
    public function cmsUpdate(CmsPageRequest $request)
    {
        try {
            $id = $request->id;
            $post = $request->all();
            $result = $this->cmsRepository->cmsUpdate($post, $id);
            if (!empty($result)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.cms_page')]
                );
            }
            return response()->json(
                ['success' => false, 'message' => trans('lang.something_went_wrong')]
            );
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }
}

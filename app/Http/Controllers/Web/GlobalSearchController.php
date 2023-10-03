<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\ClassRepository;
use App\Http\Resources\V1\GlobalSearchResource;
use Exception;

class GlobalSearchController extends Controller
{
    /**
     * Method __construct
     *
     * @param ClassRepository $classRepository
     *
     * @return void
     */
    public function __construct(
        ClassRepository $classRepository
    ) {
        $this->classRepository = $classRepository;
    }

    /**
     * Method index
     *
     * @param Request $request
     *
     * @return Json
     */
    public function index(Request $request)
    {
        try {
            $params = $request->all();
            $globalSearchs = $this->classRepository->globalSearch($params);
            $html = view('frontend.global-search', compact('globalSearchs'))->render();
           
            return $this->apiSuccessResponse($html);
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function search(Request $request)
    {
        $params = $request->all();
        if (!array_key_exists('search', $params)){
            return redirect(route('home'));
        }
        $search = $this->classRepository->search($params);
        return view(
            'frontend.search',
            compact('search')
        );
    }
}

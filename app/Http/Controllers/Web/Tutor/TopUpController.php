<?php

namespace App\Http\Controllers\Web\Tutor;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\TopupTutorRepository;
use App\Repositories\TopUpRepository;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Http\Requests\Tutor\PurchaseTopUpRequest;


/**
 * TopUpController Class
 */
class TopUpController extends Controller
{

    protected $topupTutorRepository;

    protected $topUpRepository;

    /**
     * Method __construct
     * 
     * @param TopupTutorRepository $topupTutorRepository 
     * @param TopUpRepository      $topUpRepository 
     * 
     * @return void
     */
    public function __construct(
        TopupTutorRepository $topupTutorRepository,
        TopUpRepository $topUpRepository
    ) {
        $this->topupTutorRepository = $topupTutorRepository;
        $this->topUpRepository = $topUpRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        try {
            $post['tutor_id'] = Auth::user()->id;
            $topups = $this->topupTutorRepository->getTopUp($post);
            $html = view(
                'frontend.tutor.subscription.__top-up-list',
                ['topups' => $topups]
            )->render();
            return $this->apiSuccessResponse(
                $html,
                trans('message.subscription_list')
            );
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
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
     * @param Request $request 
     * 
     * @return Response
     */
    public function store(PurchaseTopUpRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param int $id 
     * 
     * @return Response
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
     * @return Response
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
     * Method list
     * 
     * @return Json
     */
    public function list()
    {
        $topUp = $this->topUpRepository->getTopUp();
        $html = view(
            'frontend.tutor.subscription.__top-up-purchase',
            ['topUp' => $topUp]
        )->render();
        return $this->apiSuccessResponse($html);
    }
}

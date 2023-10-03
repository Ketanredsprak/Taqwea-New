<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\RaiseHandResource;
use App\Models\ClassWebinar;
use App\Models\RaiseHand;
use App\Repositories\RaiseHandRepository;
use Exception;
use Illuminate\Http\Request;

class RaiseHandConroller extends Controller
{
    protected $raiseHandRepository;
    
    /**
     * Method __construct
     *
     * @param RaiseHandRepository $raiseHandRepository 
     * 
     * @return void
     */
    public function __construct(
        RaiseHandRepository $raiseHandRepository
    ) {
        $this->authorizeResource(RaiseHand::class, 'raise_hand');
        $this->raiseHandRepository = $raiseHandRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(ClassWebinar $class, Request $request)
    {
        $params['class_id'] = $class->id;
        $requests = $this->raiseHandRepository->getRaiseHandRequests($params);
        return RaiseHandResource::collection($requests);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param ClassWebinar $class 
     * @param Request      $request 
     * 
     * @return Response
     */
    public function store(ClassWebinar $class, Request $request)
    {
        $data = $request->all();
        $data['class_id'] = $class->id;
        $data['status'] = RaiseHand::STATUS_PENDING;
        $request = $this->raiseHandRepository->addRaiseHandRequest($data);
        return new RaiseHandResource($request);
    }

    /**
     * Display the specified resource.
     *
     * @param int $raise_hand 
     * 
     * @return Response
     */
    public function show(RaiseHand $raise_hand)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param ClassWebinar $class 
     * @param RaiseHand    $raise_hand 
     * @param Request      $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function update(
        ClassWebinar $class,
        RaiseHand $raise_hand,
        Request $request
    ) {
        $data = $request->all();
        $request = $this->raiseHandRepository->updateRaiseHandRequest(
            $raise_hand->id,
            $data
        );
        return new RaiseHandResource($request);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $raise_hand 
     * 
     * @return Response
     */
    public function destroy($raise_hand)
    {
        //
    }
    
}

<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\AddRatingReviewRequest;
use App\Http\Resources\V1\RatingReviewResource;
use App\Http\Resources\V1\giveFeedbackResource;
use App\Models\User;
use App\Repositories\RatingReviewRepository;
use App\Repositories\ClassBookingRepository;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class RatingReviewController extends Controller
{
    protected $ratingReviewRepository;

    protected $classBookingRepository;

    /**
     * Method __construct
     *
     * @param RatingReviewRepository $ratingReviewRepository 
     * @param ClassBookingRepository $classBookingRepository 
     * 
     * @return void
     */
    public function __construct(
        RatingReviewRepository $ratingReviewRepository,
        ClassBookingRepository $classBookingRepository
    ) {
        $this->ratingReviewRepository = $ratingReviewRepository;
        $this->classBookingRepository = $classBookingRepository;
    }

    /**
     * Display a listing of the resource.
     *
     * @param Request $request 
     * 
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        try {
            $params = $request->all();
            if (!empty($params['rating_type'])) {
                if ($params['rating_type'] == 'received') {
                    $params['to_id'] = Auth::user()->id;
                } else {
                    $params['from_id'] = Auth::user()->id;
                }
            }
            $params['groupBy'] = true;
            $ratings = $this->ratingReviewRepository
                ->getRatings($params);
            return RatingReviewResource::collection($ratings);
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param AddRatingReviewRequest $request 
     * 
     * @return Response
     */
    public function store(AddRatingReviewRequest $request)
    {
        try {
            $rating = $this->ratingReviewRepository
                ->addRating($request->all());
            return new RatingReviewResource($rating);
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
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
     * Update the specified resource in storage.
     *
     * @param Request $request 
     * @param int     $id 
     * 
     * @return Response
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
     * @return Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * Display a listing of user's ratings.
     *
     * @param Request $request 
     * @param User    $user 
     * 
     * @return \Illuminate\Http\Response
     */
    public function userRatings(Request $request, User $user)
    {
        try {
            $params = $request->all();
            $params['to_id'] = $user->id;
            $params['groupBy'] = true;
                
            $ratings = $this->ratingReviewRepository
                ->getRatings($params);
            return RatingReviewResource::collection($ratings);
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }

    /**
     * Method giveFeedback
     * 
     * @param Request $request 
     * 
     * @return Response
     */
    public function giveFeedback(Request $request)
    {
        try {
            $params = $request->all();
            $params['id'] = $params['class_id'];
            if (isset($params['search'])) {
                $params['name'] = $params['search'];
            }
           
            $users = $this->classBookingRepository->search($params);
            return  giveFeedbackResource::collection($users);
        } catch (\Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 422);
        }
    }
}

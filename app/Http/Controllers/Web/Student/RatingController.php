<?php

namespace App\Http\Controllers\Web\Student;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RatingReviewRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{

    protected $ratingReviewRepository;

    /**
     * Method __construct
     *
     * @param RatingReviewRepository $ratingReviewRepository 
     * 
     * @return void
     */
    public function __construct(
        RatingReviewRepository $ratingReviewRepository
    ) {
        $this->ratingReviewRepository = $ratingReviewRepository;
    }

    /**
     * Method Index
     * 
     * @return view
     */
    public function index()
    {
        $params['currentPage'] = 'myRating';
        $params['title'] = trans("labels.my_ratings");
        return view('frontend.student.rating.index', $params);
    }

    /**
     * Method list
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return Json
     */
    public function list(Request $request)
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
                
            $html = view(
                'frontend.student.rating.list', 
                compact('ratings', 'params')
            )
            ->render();
            return $this->apiSuccessResponse($html);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);

        }
    }
}

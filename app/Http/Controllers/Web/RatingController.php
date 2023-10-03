<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\RatingReviewRepository;
use App\Repositories\UserRepository;
use Exception;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    protected $ratingReviewRepository;
    protected $userRepository;

    /**
     * Method __construct
     *
     * @param RatingReviewRepository $ratingReviewRepository 
     * @param UserRepository         $userRepository 
     * 
     * @return void
     */
    public function __construct(
        RatingReviewRepository $ratingReviewRepository,
        UserRepository $userRepository
    ) {
        $this->ratingReviewRepository = $ratingReviewRepository;
        $this->userRepository = $userRepository;
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
        return view('frontend.rating.index', $params);
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
                'frontend.rating.list',
                compact('ratings', 'params')
            )
                ->render();

            return $this->apiSuccessResponse($html);
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Method StudentDetails 
     * 
     * @param int $id 
     * 
     * @return void
     */
    public function studentDetails(int $id)
    {
        try {
            $post['to_id'] = $id;
            $post['groupBy'] = true;
            $studentRating = $this->ratingReviewRepository->getRatings($post);
            $userDetails = $this->userRepository->findUser($id, '');
            if (!empty($studentRating)) {
                return view(
                    'frontend.tutor.class.student-details',
                    compact('studentRating', 'userDetails')
                );
            }
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }
}

<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use App\Http\Resources\V1\ClassResource;
use Illuminate\Http\Request;
use App\Repositories\RatingReviewRepository;
use App\Repositories\ClassRepository;
use App\Repositories\ClassBookingRepository;
use App\Repositories\ClassRefundRequestRepository;
use Illuminate\Support\Facades\Auth;
use Exception;
use App\Events\FeedbackEvent;

/**
 * FeedbackController Class
 */
class FeedbackController extends Controller
{
    protected $ratingReviewRepository;
    protected $classRepository;
    protected $classBookingRepository;
    protected $classRefundRequestRepository;

    /**
     * Function __construct
     * 
     * @param RatingReviewRepository       $ratingReviewRepository 
     * @param ClassRepository              $classRepository 
     * @param ClassBookingRepository       $classBookingRepository 
     * @param ClassRefundRequestRepository $classRefundRequestRepository   
     * 
     * @return void
     */
    public function __construct(
        RatingReviewRepository $ratingReviewRepository,
        ClassRepository $classRepository,
        ClassBookingRepository $classBookingRepository,
        ClassRefundRequestRepository $classRefundRequestRepository
    ) {
        $this->ratingReviewRepository = $ratingReviewRepository;
        $this->classRepository = $classRepository;
        $this->classBookingRepository = $classBookingRepository;
        $this->classRefundRequestRepository = $classRefundRequestRepository;
    }

    /**
     * Function index
     * 
     * @param $classId 
     * 
     * @return view
     */
    public function index($classId)
    {
        $class = $this->classRepository->getClass((int)$classId);
        if (!$class) {
            return redirect("/");
        }
        $class_id = $class->id;
        return view(
            'frontend.tutor.feedback.feedback',
            compact('class')
        );
    }

    /**
     * Function Search 
     * 
     * @param Request $request 
     * 
     * @return view
     */
    public function search(Request $request, $id)
    {
        try {
            $post = $request->all();
            $students = $this->classBookingRepository->search($post);
            $html = view(
                'frontend.tutor.feedback.__search-data',
                ['students' => $students]
            )->render();
            return $this->apiSuccessResponse($html, trans(''));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Function Find Student
     * 
     * @param Request $request 
     * 
     * @return view 
     */
    public function findStudent(Request $request)
    {
        try {
            $tutorId = Auth::user()->id;
            $post = $request->all();
            $student["student"] = $this->classBookingRepository->search($post);
            $html = view(
                'frontend.tutor.feedback.__student-data',
                $student
            )->render();
            return $this->apiSuccessResponse($html, trans(''));
        } catch (Exception $e) {
            return $this->apiErrorResponse($e->getMessage(), 400);
        }
    }

    /**
     * Function StoreRatingReview
     * 
     * @param Request $request 
     * 
     * @return view
     */
    public function storeRatingReview(Request $request)
    {
        try {
            $post = $request->all();
            $post['from_id'] = Auth::user()->id;
            $result = $this->ratingReviewRepository->addRating($post);
            if ($result) {
                FeedbackEvent::dispatch($result);
                return response()->json(
                    [
                        'success' => true,
                        'message' => trans('message.add_rating_and_review')
                    ]
                );
            }
        } catch (Exception $ex) {
            return $this->apiErrorResponse($ex->getMessage(), 400);
        }
    }

    /**
     * Function studentFeedback
     * 
     * @param $classId 
     * 
     * @return view
     */
    public function studentFeedback($classId)
    {
        $class = $this->classRepository->getClass((int)$classId);
        if (!$class) {
            return redirect("/");
        }
        $class_id = $class->id;
        $tutor_id = $class->tutor_id;

        $rating = $this->ratingReviewRepository
            ->getStudentByClassRating(
                $tutor_id,
                $class_id,
                Auth::user()->id
            );
        $raise_dispute = $this->classRefundRequestRepository
            ->checkRefundRequest($class_id);

        if ($rating) {
            $rating_avg = ($rating->clarity + $rating->orgnization +
                $rating->give_homework + $rating->use_of_supporting_tools
                + $rating->on_time) / 5;
            $rating_avg = round($rating_avg);
            $view = view(
                'frontend.student.feedback.show-feedback',
                compact("rating", "rating_avg", "class_id", "raise_dispute")
            );
        } else {
            $view = view(
                'frontend.student.feedback.feedback',
                compact("class_id", "tutor_id", "raise_dispute")
            );
        }
        return $view;
    }

    /**
     * Function postDisputeReason
     * 
     * @param Request $request 
     * 
     * @return view
     */
    public function postDisputeReason(Request $request)
    {
        try {
            $post = $request->all();
            $post['user'] = Auth::user();
            $result = $this->classRefundRequestRepository->createRefundRequest('', $post);
            if (!empty($result)) {
                return response()->json(
                    ['success' => true, 'message' => trans('message.dispute_reason')]
                );
            }
        } catch (Exception $ex) {
            return response()->json(
                ['success' => false, 'message' => $ex->getMessage()]
            );
        }
    }

    /**
     * Function tutorReceivedFeedback
     * 
     * @param int $classId 
     * @param int $receiverId 
     * 
     * @return view
     */
    public function tutorReceivedFeedback(int $classId, int $receiverId)
    {
        $class = $this->classRepository->getClass((int)$classId);
        if (!$class) {
            return redirect("/");
        }
        $class_id = $class->id;
        $tutor_id = $class->tutor_id;

        $rating = $this->ratingReviewRepository
            ->getStudentByClassRating(
                $tutor_id,
                $class_id,
                $receiverId
            );
        $raise_dispute = $this->classRefundRequestRepository
            ->checkRefundRequest($class_id);

        if ($rating) {
            $rating_avg = ($rating->clarity + $rating->orgnization +
                $rating->give_homework + $rating->use_of_supporting_tools
                + $rating->on_time) / 5;
            $rating_avg = round($rating_avg);
            return view(
                'frontend.tutor.feedback.received-feedback',
                compact("rating", "rating_avg", "class_id", "raise_dispute")
            );
        }
    }
}

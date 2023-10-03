<?php

namespace App\Http\Resources\V1;

use App\Models\ClassBooking;
use App\Models\ClassWebinar;
use App\Models\RatingReview;
use App\Models\User;
use App\Models\Wallet;
use App\Models\RewardPoint;
use App\Models\TutorPayout;
use App\Models\TransactionItem;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param Request $request
     *
     * @return array
     */
    public function toArray($request)
    {
        /**
         * User
         *
         * @var $loggedInUser User
         **/
        $loggedInUser = Auth::user();
        $routes = ['login', 'signup', 'social-login'];
        $current = Route::current()->getName();
        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'user_type' => $this->user_type,
            'gender' => $this->gender,
            'phone_number' => $this->phone_number,
            'profile_image_url' => $this->profile_image_url,
            'bio' => $this->bio ?? '',
            'address' => $this->address,
            'is_verified' => $this->is_verified,
            'is_approved' => $this->is_approved,
            'is_profile_completed' => $this->is_profile_completed,
            'status' => $this->status,
            'referral_code' => $this->referral_code,
            'address' => $this->address,
            'rating' => RatingReview::getAverageRating($this->id),
            'access_token' => $this->when(
                $this->device
                    && in_array($current, $routes),
                function () {
                    return $this->device->access_token;
                }
            ),
            'user_levels' => UserLevelResource::collection($this->levels),
            'user_grades' => UserGradeResource::collection($this->grades),
            'user_subjects' => UserSubjectResource::collection($this->subjects),
            'user_general_knowledge' => UserGeneralKnowledgeResource::collection(
                $this->generalKnowledge
            ),
            'user_languages' => UserLanguageResource::collection($this->languages),
            $this->mergeWhen(
                $loggedInUser
                    && ($loggedInUser->isTutor() || $this->id !== Auth::user()->id),
                [
                    'tutor_detail' => new TutorResource($this->tutor),
                    'tutor_subscription' => new TutorSubscriptionResource($this->tutorSubscriptions),
                    'tutor_certificates' => TutorCertificateResource::collection(
                        $this->certificates
                    ),
                    'tutor_educations' => TutorEducationResource::collection(
                        $this->educations
                    ),
                    'blogs' => BlogResource::collection($this->blogs),
                    'classes_completed' => ClassWebinar::classCount($this->id),
                    'total_classes' => ClassWebinar::classCount(
                        $this->id,
                        ClassWebinar::TYPE_CLASS,
                        false
                    ),
                    'blogs_count' => count($this->blogs),
                    'total_webinars' => ClassWebinar::classCount(
                        $this->id,
                        ClassWebinar::TYPE_WEBINAR,
                        false
                    ),
                    'webinar_completed' => ClassWebinar::classCount(
                        $this->id,
                        ClassWebinar::TYPE_WEBINAR
                    ),
                    'translations' => $this->translations,
                    'approval_status' => $this->approval_status,
                    'rejected_reason' => ($this->tutor)?$this->tutor->reject_reason:'',
                ]
            ),
            $this->mergeWhen(
                $loggedInUser
                    && ($loggedInUser->isStudent() || $this->id !== Auth::user()->id),
                [
                    'total_booking_classes' => ClassBooking::bookingClassesCount(
                        $this->id
                    ),
                ]
            ),
            $this->mergeWhen(
                $loggedInUser
                    &&
                    $loggedInUser->isAdmin(),
                function () {
                    return [
                        'created_at' => $this->created_at,
                        'amount' => 0,
                        'approval_status' => $this->approval_status
                    ];
                }
            ),
            $this->mergeWhen(
                $loggedInUser
                    &&
                    $loggedInUser->isAccountant(),
                function () {
                    $calculation = TransactionItem::totalSaleCommission($this->id);
                    $totalPaid = TutorPayout::totalPayout($this->id);
                    $totalFine = Transaction::totalFine($this->id);
                    return [
                        'created_at' => $this->created_at,
                        'amount' => 0,
                        'approval_status' => $this->approval_status,
                        'total_earning' => number_format($totalPaid, 2),
                        'total_admin_commission' => number_format($calculation->total_admin_commission, 2),
                        'total_sale' => number_format($calculation->total_sale, 2),
                        'total_paid_tutor' => $totalPaid,
                        'total_due' => str_replace(',', '', number_format(($calculation->total_earning - $totalPaid - $totalFine), 2)),
                        'total_points' => RewardPoint::getUserPoints($this->id),
                    ];
                }
            ),
            "login_type" => ($this->userSocialLogin) ?
                User::SOCIAL_LOGIN : User::NORMAL_LOGIN,
            "referral" => $this->when(
                (Auth::check() && $this->id == Auth::user()->id),
                function () {
                    return [
                        'code' => $this->referral_code,
                        'point' => config('constants.referral.points'),
                        'earn' => config('constants.referral.sar_value'),
                    ];
                }
            ),
            'availablePoint' => RewardPoint::getUserPoints($this->id),
            'walletBalance' => Wallet::availableBalance($this->id),
            "payment_earning" =>  $this->when(
                ((Auth::check() && $this->id == Auth::user()->id && $loggedInUser->isTutor()) || (Auth::check() && $loggedInUser->isAdmin())),
                function () {
                    $calculation = TransactionItem::totalSaleCommission($this->id);
                    $totalPaid = TutorPayout::totalPayout($this->id);
                    $totalFine = Transaction::totalFine($this->id);
                    return [
                        'total_earning' => number_format($calculation->total_earning, 2),
                        'total_sale' => number_format($calculation->total_sale, 2),
                        'total_payment' => $totalPaid,
                        'total_due' => number_format(($calculation->total_earning - $totalPaid - $totalFine), 2),
                        'current_fine' => $totalFine,
                        'commission' => $calculation->total_admin_commission,                       
                    ];
                }
            ),

            'student_purchase' => $this->when(
                ((Auth::check())),
                function () {
                    return [
                        'count_blog' => TransactionItem::studentPurchases($this->id, 'blog'),
                        'count_class' => TransactionItem::studentPurchases($this->id, 'class'),
                        'count_webinar' => TransactionItem::studentPurchases($this->id, 'webinar'),
                    ];
                }
            ),
        ];
    }
}

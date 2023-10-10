<?php

namespace App\Repositories;

use App\Mail\ChangePassword;
use Illuminate\Container\Container as Application;
use App\Mail\ForgotPassword;
use App\Mail\ResetPassword;
use App\Mail\SignUpUser;
use App\Mail\TwoFactorAuthentication;
use App\Mail\VerifyAccount;
use Prettus\Repository\Eloquent\BaseRepository;
use Prettus\Repository\Criteria\RequestCriteria;
use App\Models\User;
use App\Models\TransactionItem;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Database\Eloquent\ModelNotFoundException;
use Illuminate\Support\Collection;
use App\Models\UserTranslation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use App\Events\TutorSignUpSubscriptionEvent;
use App\Events\TutorSignUpEvent;
use App\Events\ReferralCodeUsedEvent;

/**
 * Class UserRepository.
 */
class UserRepository extends BaseRepository
{
    protected $socialLoginRepository;

    protected $tutorRepository;

    protected $userSubjectRepository;

    protected $userLanguageRepository;

    protected $userGradeRepository;

    protected $userGeneralKnowledgeRepository;

    protected $userLevelRepository;

    protected $rewardPointsRepository;

    protected $tutorSubscriptionRepository;


    protected $subscriptionRepository;
    protected $notificationRepository;

    /**
     * Method __construct
     *
     * @param Application                    $app
     * @param UserSocialLoginRepository      $socialLoginRepository
     * @param TutorRepository                $tutorRepository
     * @param UserSubjectRepository          $userSubjectRepository
     * @param UserLanguageRepository         $userLanguageRepository
     * @param UserGradeRepository            $userGradeRepository
     * @param UserGeneralKnowledgeRepository $userGeneralKnowledgeRepository
     * @param UserLevelRepository            $userLevelRepository
     * @param RewardPointsRepository         $rewardPointsRepository
     * @param TutorSubscriptionRepository    $tutorSubscriptionRepository
     * @param SubscriptionRepository         $subscriptionRepository
     * @param NotificationRepository         $notificationRepository
     *
     * @return void
     */
    public function __construct(
        Application $app,
        UserSocialLoginRepository $socialLoginRepository,
        TutorRepository $tutorRepository,
        UserSubjectRepository $userSubjectRepository,
        UserLanguageRepository $userLanguageRepository,
        UserGradeRepository $userGradeRepository,
        UserGeneralKnowledgeRepository $userGeneralKnowledgeRepository,
        UserLevelRepository $userLevelRepository,
        RewardPointsRepository $rewardPointsRepository,
        TutorSubscriptionRepository $tutorSubscriptionRepository,
        SubscriptionRepository $subscriptionRepository,
		NotificationRepository $notificationRepository
    ) {
        parent::__construct($app);
        $this->socialLoginRepository = $socialLoginRepository;
        $this->tutorRepository = $tutorRepository;
        $this->userSubjectRepository = $userSubjectRepository;
        $this->userLanguageRepository = $userLanguageRepository;
        $this->userGradeRepository = $userGradeRepository;
        $this->userGeneralKnowledgeRepository = $userGeneralKnowledgeRepository;
        $this->userLevelRepository = $userLevelRepository;
        $this->rewardPointsRepository = $rewardPointsRepository;
        $this->tutorSubscriptionRepository = $tutorSubscriptionRepository;
        $this->subscriptionRepository  = $subscriptionRepository;
        $this->notificationRepository = $notificationRepository;
    }
    /**
     * Specify Model class name
     *
     * @return string
     */
    public function model()
    {
        return User::class;
    }

    /**
     * Boot up the repository, pushing criteria
     *
     * @return void
     */
    public function boot()
    {
        $this->pushCriteria(app(RequestCriteria::class));
    }

    /**
     * Method getUserByAttribute
     *
     * @param array $data [explicite description]
     *
     * @return User
     */
    public function getUserByAttribute($data)
    {
        if (!isset($data['email'])) {
            $data['email']  = "";
        }

        $query = $this->where(
            function ($query) use ($data) {
                if (@$data['user_id']) {
                    $query->where('id', $data['user_id']);
                } else {
                    $query->where('email', $data['email']);
                }
                if (!empty($data['phone_number'])) {
                    $query->orWhere('phone_number', $data['phone_number']);
                }
            }
        );

        if (!empty($data['otp'])) {
            $query->where('otp', $data['otp']);
        }
        return $query->first();
    }

    /**
     * Method getRecentUsers
     *
     * @param string $type
     *
     * @return Collection
     */
    public function getRecentUsers(
        string $type = User::TYPE_STUDENT
    ) {
        return $this->where('user_type', $type)
            ->orderBy('created_at', 'desc')
            ->limit(5)
            ->get();
    }

    /**
     * Method getDashboardCount
     *
     * @param string $for
     *
     * @return mixed
     */
    public function getDashboardCount(
        string $for = ''
    ) {
        $where = "";
        $join = "";
        $whereJoin = "";
        $tutorEarning = '';
        if ($for == "month") {
            $currentMonth = Carbon::now()->month;
            $where .= " AND MONTH(created_at) = $currentMonth";
        }

        if (Auth::check() && Auth::user()->user_type == User::TYPE_TUTOR) {
            $user_id = Auth::user()->id;
            $join .= 'Join transaction_items
                on transaction_items.student_id = users.id';

            $whereJoin .= " AND ( transaction_items.blog_id in (SELECT id
                                                            FROM `blogs`
                                                            where tutor_id = $user_id
                                                        )
                                    OR transaction_items.class_id in (SELECT id
                                                            FROM `class_webinars`
                                                            where tutor_id = $user_id
                                                        )
                                )

            ";

            $tutorEarning = DB::raw(
                "(SELECT SUM(amount)
                FROM users
                " . $join . "
                WHERE user_type = '" . User::TYPE_STUDENT . "'
                " . $where . "$whereJoin
                AND
                transaction_items.status =
                    '" . TransactionItem::STATUS_CONFIRMED . "'

                )
                AS tutor_earning"
            );
        }

        $query =  $this->select(
            DB::raw(
                "(SELECT COUNT(id)
                    FROM users
                    WHERE user_type = '" . User::TYPE_TUTOR . "'
                    $where) AS tutor_count"
            ),
            DB::raw(
                "(SELECT COUNT(DISTINCT(users.id))
                FROM users
                " . $join . "
                WHERE user_type = '" . User::TYPE_STUDENT . "'
                " . $where . "$whereJoin )
                AS student_count"
            )
        );

        /**
         * For tutor earning calculate
         */
        if ($tutorEarning) {
            $query->addSelect($tutorEarning);
        }

        return $query->first();
    }

    /**
     * Method findUser
     *
     * @param int   $id     [explicite description]
     * @param array $params [explicite description]
     *
     * @return User|Exception|ModelNotFoundException
     */
    public function findUser($id = '', $params = [])
    {
        try {
            $query =  $this->select('*');
            if ($id) {
                $query->where('id', $id);
            }

            if (!empty($params['referral_code'])) {
                $query->where('referral_code', $params['referral_code']);
            }
            /**
             * User
             *
             * @var $loggedInUser User
             **/
            $loggedInUser = Auth::user();

            if ($loggedInUser && $loggedInUser->isStudent()) {
                $query->with(
                    [
                        'blogs' =>
                        function ($q) use ($loggedInUser) {
                            $q->whereNotIn(
                                'id',
                                function ($query) use ($loggedInUser) {
                                    $query->select('blog_id')
                                        ->from('transaction_items')
                                        ->where('student_id', $loggedInUser->id)
                                        ->whereNotNull('blog_id');
                                }
                            );
                        }
                    ]
                );
            }

            return $query->first();
        } catch (ModelNotFoundException $e) {
            throw new ModelNotFoundException(trans('error.user_not_found'), 404);
        } catch (Exception $e) {
            throw new Exception(trans('error.server_error'));
        }
    }

    /**
     * Method getUsers
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getUsers(array $params)
    {
        $sortFields = [
            'id' => 'id',
            'name' => 'name',
            'gender' => 'gender',
            'phone_number' => 'phone_number',
            'type_subscription' => 'subscription_translations.subscription_id',
            'total_classes' => 'class_count',
            'total_webinars' => 'webinar_count',
            'blogs_count' => 'blog_count',
            'created_at' => 'created_at'
        ];
        $language = getUserLanguage($params);
        $size = $params['size'] ?? config('repository.pagination.limit');
        $loggedInUser = Auth::user();
        $query = $this->withTranslation();
        if (Auth::check() && $loggedInUser->isAccountant() ||  isset($params['report'])) {
            $query->select(
                'users.*',
                DB::raw(
                    "(select count(id)
                      FROM blogs
                      WHERE blogs.tutor_id = users.id )
                      as blog_count"
                ),
                DB::raw(
                    "(select count(id)
                      FROM class_webinars as cw
                      WHERE cw.tutor_id = users.id AND
                       cw.class_type ='class' AND cw.status != 'pending')
                      as class_count"
                ),
                DB::raw(
                    "(select count(id)
                    FROM class_webinars as cw
                    WHERE cw.tutor_id = users.id AND
                     cw.class_type = 'webinar' AND cw.status != 'pending' )
                    as webinar_count"
                )
            )->leftjoin(
                'tutor_subscriptions',
                'users.id',
                'tutor_subscriptions.user_id'
            )->leftjoin(
                'subscriptions',
                'subscriptions.id',
                'tutor_subscriptions.subscription_id'
            )->leftjoin(
                'subscription_translations',
                'subscription_translations.subscription_id',
                'subscriptions.id'
            )->where('tutor_subscriptions.status', 'active')->groupBy('users.id');
        }
        if ($language && Auth::check() && $loggedInUser->isAccountant()) {
            $query->whereRaw(
                "if(subscription_translations.language IS NOT NULL,
                subscription_translations.language= '" . $language . "',
                true )"
            );
        }

        if (!empty($params['user_type'])) {
            $query->where('user_type', $params['user_type']);
        }

        if (!empty($params['from_date'])) {
            $query->whereDate('users.created_at', '>=', $params['from_date']);
        }

        if (!empty($params['to_date'])) {
            $query->whereDate('users.created_at', '<=', $params['to_date']);
        }

        if (!empty($params['gender'])) {
            $query->where('gender', $params['gender']);
        }

        if (isset($params['is_approved'])) {
            $query->where('is_approved', $params['is_approved']);
        }

        if (isset($params['subscription'])) {
            $query->with(
                [
                    'tutorSubscriptions' =>
                    function ($q) {
                        $q->where('status', '=', 'active');
                    }
                ]
            );
        }

        if (!empty($params['type_of_subscription'])) {
            $query->whereHas(
                'tutorSubscriptions',
                function ($q) use ($params) {
                    $q->where('subscription_id', $params['type_of_subscription'])
                        ->where('status', '=', 'active');
                }
            );
        }

        if (!empty($params['approval_status'])) {
            if ($params['approval_status'] == 'incomplete') {
                $query->where('is_profile_completed', 0);
            } else {
                $query->where('approval_status', $params['approval_status'])
                    ->where('is_profile_completed', 1);
            }
        }

        if (!empty($params['rating'])) {
            $query->whereHas(
                'ratingReviews',
                function ($q) use ($params) {
                    $q->havingRaw('ROUND(AVG(rating)) ='. $params['rating']);
                }
            );
        }

        if (!empty($params['status'])) {
            $query->where('users.status', $params['status']);
        }

        if (!empty($params['search'])) {
            $query->where(
                function ($qry) use ($params) {
                    $qry->orWhereTranslationLike(
                        'name',
                        "%" . $params['search'] . "%"
                    )
                        ->orWhere('users.id', 'like', "%" . $params['search'] . "%")
                        ->orWhere(
                            'phone_number',
                            'like',
                            "%" . $params['search'] . "%"
                        )
                        ->orWhere('email', 'like', "%" . $params['search'] . "%");
                }
            );
        }

        $sort = $sortFields['id'];
        $direction = 'desc';

        if (array_key_exists('sortColumn', $params)) {
            if (isset($sortFields[$params['sortColumn']])) {
                $sort = $sortFields[$params['sortColumn']];
            }
        }
        if (array_key_exists('sortDirection', $params)) {
            $direction = $params['sortDirection'] == 'desc' ? 'desc' : 'asc';
        }
        if (in_array($sort, ['name'])) {
            $query->orderByTranslation($sort, $direction);
        } else {
            $query->orderBy($sort, $direction);
        }
        $query = $this->userFilters($query, $params);
        if (isset($params['is_paginate'])) {
            return $query->get();
        } else {
            return $query->paginate($size);
        }
    }

    /**
     * Method createUser
     *
     * @param array $data     [explicite description]
     * @param bool  $sendOtp  [Whether we have to send otp or not]
     * @param bool  $isSocial [if user user is social user]
     *
     * @return User
     */
    public function createUser(
        array $data,
        bool $sendOtp = true,
        bool $isSocial = false
    ) {

        try {
            DB::beginTransaction();

            if (!$isSocial) {
                if (!empty($data['profile_image'])) {
                    $data['profile_image'] = uploadFile(
                        $data['profile_image'],
                        'profile_image'
                    );
                }
                $data['password'] = Hash::make($data['password']);
            } else {
                $data['is_verified'] = 1;
                $data['status'] = User::STATUS_ACTIVE;
            }
            $user = $this->updateOrCreate(
                [
                    'email' => $data['email']
                ],
                $data
            );

            if ($isSocial) {
                $data['user_id'] = $user->id;
                $socialUser = $this->socialLoginRepository->createSocialLogin($data);
                $user = $socialUser->user;
            }

            if ($sendOtp) {
                if (!empty(@$data['email'])) {
                    $params['email'] = $data['email'];
                }
                if (!empty(@$data['user_id'])) {
                    $params['user_id'] = $data['user_id'];
                }
                $user = $this->sendOtp($params, 'registration');
            } elseif (!$isSocial) {
                $params['email'] = $data['email'];
                $params['user_id'] = $user->id;
                $user = $this->signUpEmail($params);
            }

            // Assign default subscription plan
            if ($user->is_profile_completed == 0
                && $user->user_type == User::TYPE_TUTOR
            ) {
                $this->assignDefaultPlan($user);
            }

            if (isset($data["referral_code"]) && !empty($data["referral_code"])) {
                $data['user'] = $user;
                $userData['from_id'] = $user->id;
                $this->sendReferralNotification($data);
                $this->upateUserPointsByReferal($data["referral_code"], $userData);
            }

            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw ($e);
        }
    }

    /**
     * Method updateUser
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return User
     */
    public function updateUser(array $data, int $id)
    {
        try {
            DB::beginTransaction();
            $user = $this->findUser($id);

            if (!empty($data['profile_image'])) {
                $data['profile_image'] = uploadFile(
                    $data['profile_image'],
                    'profile_image'
                );
                deleteFile($user->profile_image);
            } else {
                unset($data['profile_image']);
            }

            /**
             * Remove social login
             */
            if (isset($data["email"])
                && !empty($data["email"])
                && $data["email"] != $user->email
                && $user->userSocialLogin
            ) {
                $this->socialLoginRepository->destroy($user->userSocialLogin->id);
            }

            $this->_updateTutorProfile($user, $data);

            if (!empty($data["approval_status"])
                && $data["approval_status"] == User::APPROVAL_STATUS_APPROVED
                && $user->user_type == User::TYPE_TUTOR
            ) {
                TutorSignUpSubscriptionEvent::dispatch($user);
            }
            // Assign default subscription plan
            if ($user->user_type == null
                && $data['user_type'] == User::TYPE_TUTOR
            ) {
                $this->assignDefaultPlan($user);
                TutorSignUpEvent::dispatch($user);
            } elseif ($user->user_type == null) {
                $param['email'] = $user->email;
                $param['user_id'] = $user->id;
                $this->signUpEmail($param);
            }

            if (isset($data["referral_code"]) && !empty($data["referral_code"])) {
                $data['user'] = $user;
                $userData['from_id'] = $user->id;
                $this->sendReferralNotification($data);
                $this->upateUserPointsByReferal($data["referral_code"], $userData);
            }

            DB::commit();
            return $this->update($data, $user->id);
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Method completeProfile
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return User
     */
    public function completeProfile(array $data, int $id): User
    {
        try {
            DB::beginTransaction();

            $user = $this->findUser($id);

            if (!empty($data['profile_image'])) {
                $data['profile_image'] = uploadFile(
                    $data['profile_image'],
                    'profile_image'
                );
                deleteFile($user->profile_image);
            } else {
                unset($data['profile_image']);
            }

            /**
             * Remove social login
             */
            if (isset($data["email"])
                && !empty($data["email"])
                && $data["email"] != $user->email
                && $user->userSocialLogin
            ) {
                $this->socialLoginRepository->destroy($user->userSocialLogin->id);
            }

            $data['updated_at'] = Carbon::now();

            $user = $this->update($data, $user->id);

            $this->_updateTutorProfile($user, $data);


            DB::commit();
            return $user;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }

    /**
     * Method _updateTutorProfile
     *
     * @param User  $user [explicite description]
     * @param array $data [explicite description]
     *
     * @return void
     */
    private function _updateTutorProfile(User $user, array $data)
    {
        if ($user && $user->user_type === User::TYPE_TUTOR) {
            $user->tutor = $this->tutorRepository->updateTutor($user, $data);
        }
        if (isset($data['subjects'])) {
            $this->userSubjectRepository->updateSubjects(
                $user,
                $data
            );
        }

        if (isset($data['levels'])) {
            $this->userLevelRepository->updateLevels(
                $user,
                $data
            );
        }

        if (isset($data['grades'])) {
            $this->userGradeRepository->updateGrades(
                $user,
                $data
            );
        }

        if (isset($data['general_knowledge'])) {
            $this->userGeneralKnowledgeRepository->updateGeneralKnowledge(
                $user,
                $data
            );
        }

        if (isset($data['languages'])) {
            $this->userLanguageRepository->updateLanguages(
                $user,
                $data
            );
        }
    }

    /**
     * Method forgotPassword
     *
     * @param array $data [explicite description]
     *
     * @throws Exception
     * @return User
     */
    public function forgotPassword($data)
    {
        return $this->sendOtp($data, 'forgot_password');
    }

    /**
     * Method forgotPassword
     *
     * @param array $data [explicite description]
     *
     * @throws Exception
     * @return User
     */
    public function optVerification($data)
    {
        return $this->sendOtp($data, 'otp-verification');
    }

    /**
     * Function signUpEmail
     *
     * @param $post
     *
     * @return user
     */
    public function signUpEmail($post)
    {
        $user = $this->getUserByAttribute($post);
        try {
            $emailTemplate = $this->getOtpTemplate('signup', $user);
            sendMail($post["email"], $emailTemplate);
            return $user;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Method sendOtp
     *
     * @param array       $post
     * @param string|null $type
     *
     * @return User
     */
    public function sendOtp($post, $type)
    {
        DB::beginTransaction();

        $user = $this->getUserByAttribute($post);

        if ($type == 'change-email') {
            $user = Auth::user();
        }
        if (!$user) {
            throw new Exception(trans('message.user_not_found'));
        }

        try {
            $temp = ($type == 'two_factor_auth') ? true : false;
            $data['otp'] = generateOtp($temp);
            $data['updated_at'] = Carbon::now();
            $user = $this->update($data, $user->id);

            if (isset($post["user_id"])) {
                $user->email = $post["email"];
            }

            DB::commit();
            if ($type) {
                if ($type == 'change-email') {
                    $emailTemplate = $this->getOtpTemplate('registration', $user);
                    sendMail($post["email"], $emailTemplate);
                } else {
                    $emailTemplate = $this->getOtpTemplate($type, $user);
                    sendMail($user, $emailTemplate);
                }
            }
            return $user;
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }

    /**
     * Method verifyOtp
     *
     * @param $post $post [explicite description]
     *
     * @return User
     */
    public function verifyOtp($post)
    {
        try {
            DB::beginTransaction();

            $user = $this->where('otp', $post['otp'])->first();
            if (!empty($user)) {
                $oneHourBefore = Carbon::now()->subHour()->format('Y-m-d H:i:s');
                if ($user->updated_at < $oneHourBefore) {
                    throw new Exception(trans('message.otp_expired'));
                }
                $data['is_verified'] = 1;
                //Update is verified and change status to active on registration
                if (!empty($post['type']) && $post['type'] == 'registration') {
                    $data['otp'] = null;
                    if ($user->status == User::STATUS_INACTIVE) {
                        $currentTime = Carbon::now()->toDateTimeString();
                        $data['account_verified_at'] = $currentTime;
                    }
                    $param['email']= $user->email;
                    $param['user_id']=$user->id;
                    $this->signUpEmail($param);
                    if ($user->user_type == User::TYPE_TUTOR) {
                        TutorSignUpEvent::dispatch($user);
                    }
                } elseif (!empty($post['type'])
                    && $post['type'] == 'two_factor_auth'
                ) {
                    $data['otp'] = null;
                } elseif (!empty($post['type'])
                    && $post['type'] == 'update_profile'
                ) {
                    $data['otp'] = null;
                }
                $this->update($data, $user->id);
                DB::commit();
                return $user;
            }

            throw new Exception(trans('message.invalid_otp'));
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }


    /**
     * Method resetPassword
     *
     * @param $post $post [explicite description]
     *
     * @return void
     */
    public function resetPassword($post)
    {
        try {
            DB::beginTransaction();
            $user = $this->where('otp', $post['otp'])->first();

            if (!empty($user)) {
                //Reset Password
                $data['password'] = Hash::make($post['new_password']);
                $data['otp'] = null;
                $user = $this->update($data, $user->id);

                DB::commit();
                $emailTemplate = new ResetPassword($user);
                sendMail($user->email, $emailTemplate);
                return $user;
            }

            throw new Exception(trans('message.invalid_otp'));
        } catch (Exception $ex) {
            DB::rollback();
            throw $ex;
        }
    }

    /**
     * Method getOtpTemplate
     *
     * @param string $type [explicite description]
     * @param User   $user [explicite description]
     *
     * @return Mailable|null
     */
    public function getOtpTemplate(string $type, User $user)
    {
        $emailTemplate = null;
        if ($type == 'registration') {
            $emailTemplate = new VerifyAccount($user);
        } elseif ($type == 'forgot_password') {
            $emailTemplate = new ForgotPassword($user);
        } elseif ($type == 'two_factor_auth') {
            $emailTemplate = new TwoFactorAuthentication($user);
        } elseif ($type == 'update_profile') {
            $emailTemplate = new VerifyAccount($user);
        } elseif ($type == 'signup') {
            $emailTemplate = new SignUpUser($user);
        }
        return $emailTemplate;
    }

    /**
     * Method getSocialUser
     *
     * @param array $params [explicite description]
     *
     * @return User|null
     */
    public function getSocialUser(array $params)
    {
        $socialUser = $this->socialLoginRepository->getDetails($params);

        if (!$socialUser) {
            return null;
        }
        return $socialUser->user;
    }

    /**
     * Method getFeaturedTutors
     *
     * @param array $params [explicite description]
     *
     * @return Collection
     */
    public function getFeaturedTutors(array $params)
    {
        $query = $this->withTranslation()
            ->with('tutor')
            ->whereHas(
                'tutor',
                function ($subQuery) {
                    $subQuery->where('is_featured', 1);
                }
            );
        $query = $this->userFilters($query, $params);
        $limit = $params['size'] ?? config('repository.pagination.limit');
        return $query->paginate($limit);
    }

    /**
     * User filter
     *
     * @param $query
     * @param $params
     *
     * @return Object
     */
    public function userFilters($query, $params)
    {
        if (isset($params['level'])) {
            $query->whereHas(
                'levels',
                function ($q) use ($params) {
                    if (is_array($params['level'])) {
                        $q->whereIn('category_id', $params['level']);
                    } else {
                        $q->where('category_id', $params['level']);
                    }
                }
            );
        }

        if (isset($params['grade'])) {
            $query->whereHas(
                'grades',
                function ($q) use ($params) {
                    if (is_array($params['grade'])) {
                        $q->whereIn('grade_id', $params['grade']);
                    } else {
                        $q->where('grade_id', $params['grade']);
                    }
                }
            );
        }

        if (isset($params['subject'])) {
            $query->whereHas(
                'subjects',
                function ($q) use ($params) {
                    if (is_array($params['subject'])) {
                        $q->whereIn('subject_id', $params['subject']);
                    } else {
                        $q->where('subject_id', $params['subject']);
                    }
                }
            );
        }

        if (isset($params['generalknowledge'])) {
            $query->whereHas(
                'generalKnowledge',
                function ($q) use ($params) {
                    if (is_array($params['generalknowledge'])) {
                        $q->whereIn('category_id', $params['generalknowledge']);
                    } else {
                        $q->where('category_id', $params['generalknowledge']);
                    }
                }
            );
        }

        if (isset($params['language'])) {
            $query->whereHas(
                'languages',
                function ($q) use ($params) {
                    if (is_array($params['language'])) {
                        $q->whereIn('category_id', $params['language']);
                    } else {
                        $q->where('category_id', $params['language']);
                    }
                }
            );
        }

        if ((@$params['min_experience'] >= 0) && @$params['max_experience']) {
            $query->whereHas(
                'tutor',
                function ($q) use ($params) {
                    $q->whereRAW('ROUND(experience) >=?', [$params['min_experience']]);
                    $q->whereRAW('ROUND(experience) <=?', [$params['max_experience']]);
                }
            );
        } elseif (isset($params['min_experience']) && @$params['min_experience'] >= 0
        ) {
            $query->whereHas(
                'tutor',
                function ($q) use ($params) {
                    $q->where('experience', '>=', $params['min_experience']);
                }
            );
        }

        if (isset($params['featured']) && $params['featured'] == "Yes") {
            $query->whereHas(
                'tutor',
                function ($q) use ($params) {
                    $q->where('is_featured', 1);
                }
            );
        }

        return $query;
    }

    /**
     * Method changePasswordEmail
     *
     * @param array $post [ecplicite description]
     *
     * @return void
     */
    public function changePassword(array $post)
    {
        $user = $this->updateUser(
            ['password' => bcrypt($post['new_password'])],
            $post['id']
        );
        if ($user && !empty($user->device->access_token)) {
            foreach ($user->devices as $device) {
                invalidateTokenString($device->access_token);
            }
        }

        if ($user && isset($post['is_notify'])) {
            $userName = $user->name;
            $emailData = [
                'name' => $userName,
                'password' => $post['new_password']
            ];
            $emailTemplate = new ChangePassword($emailData);
            sendMail($user->email, $emailTemplate);

            return true;
        }
        return true;
    }

    /**
     * Method upateUserPointsByReferal
     *
     * @param string $referralCode [explicite description]
     * @param array  $userData     [explicite description]
     *
     * @return void
     */
    public function upateUserPointsByReferal(string $referralCode, array $userData)
    {
        try {
            $user = $this->where('referral_code', $referralCode)->first();
            if ($user) {
                $data['user_id'] = $user->id;
                $data['type'] = 'credit';
                $data['points'] = config('constants.referral.points');
                $data['from_id'] = $userData['from_id'];
                $result = $this->rewardPointsRepository->createRewardPoint($data);
                if ($result) {
                    return true;
                }
            }
            return false;
        } catch (Exception $ex) {
            throw $ex;
        }
    }

    /**
     * Method assignDefaultPlan
     *
     * @param object $user
     *
     * @return void()
     */
    public function assignDefaultPlan($user)
    {
        $data["user"] = $user;
        $data["plan_id"] = 0;

        $subscription = $this->subscriptionRepository->getDefaultSubscription();

        if ($subscription) {
            $data["plan_id"] = $subscription['id'];
        }
        $this->tutorSubscriptionRepository->purchasePlan($data);
    }

    /**
     * Method sendReferralNotification
     *
     * @param array $data
     *
     * @return void
     */
    public function sendReferralNotification(array $data)
    {
        ReferralCodeUsedEvent::dispatch($data);
    }


    /**
     * Method deleteUser
     *
     * @param $id int
     *
     * @return bool
     */
    public function deleteUser($id)
    {
        try {
            throw_if(
                (Auth::user()->id != $id),
                Exception::class,
                trans('error.user_not_found')
            );
            $user = $this->findUser($id);
            $user->delete();
            return true;
        } catch (Exception $e) {
            Log::debug("delete user error ", ['id'=>$id, 'exception'=>$e]);
            throw $e;
        }
    }


    //15-09-2023

    public function getTutors(array $params)
    {
//  dd($params);
        $query = $this->withTranslation();
        $query->select(
            'users.*'
            );

            if(!empty($params['category_id']) && $params['category_id'] == '1'){
                if (!empty($params['level_id'])) {
                   $query->leftjoin(
                        'user_levels',
                        'users.id',
                        'user_levels.user_id'
                    );
                }
            }

            if(!empty($params['category_id']) && $params['category_id'] == '1'){
                if (!empty($params['subject_id'])) {
                    $query->leftjoin(
                        'user_subjects',
                        'users.id',
                        'user_subjects.user_id'
                    );
                }
            }
          

            // if (!empty($params['grade_id'])) {
            //     // $query->rightjoin(
            //     //     'user_grades',
            //     //     'users.id',
            //     //     'user_grades.user_id'
            //     // );
            // }

            if(!empty($params['category_id']) && $params['category_id'] == '2'){
               if (!empty($params['level_id'])) {
                        $query->leftjoin(
                        'user_general_knowledges',
                        'users.id',
                        'user_general_knowledges.user_id'
                    );
                }
            }

            if(!empty($params['category_id']) && $params['category_id'] == '3'){
                if (!empty($params['level_id'])) {
                    $query->leftjoin(
                        'user_languages',
                        'users.id',
                        'user_languages.user_id'
                    );
                    
                }
            }

        $query->where('users.user_type', 'tutor')->where('users.is_available', '1');
       
        if(!empty($params['preferred_gender']) && $params['preferred_gender'] != "both"){
                $query->where('users.gender', $params['preferred_gender']);
        }

        if(!empty($params['category_id']) && $params['category_id'] == '1'){
            if (!empty($params['level_id'])) {
               $query->where('user_levels.category_id', $params['level_id']);
            }
            if (!empty($params['subject_id'])) {
               $query->where('user_subjects.subject_id', $params['subject_id']);
            }
            // if (!empty($params['grade_id'])) {
            //     $query->where('user_grades.grade_id', $params['grade_id']);
            // }
        }



        if(!empty($params['category_id']) && $params['category_id'] == '2'){
            if (!empty($params['level_id'])) {
                $query->where('user_general_knowledges.category_id', $params['level_id']);
            }
        }
        if(!empty($params['category_id']) && $params['category_id'] == '3'){
            if (!empty($params['level_id'])) {
                $query->where('user_languages.category_id', $params['level_id']);
            }
        }

        // if (!empty($params['is_approved'])) {
        //     $query->where('users.is_approved', $params['is_approved']);
        // }
        // if (!empty($params['status'])) {
        //     $query->where('users.status', $params['status']);
        // }
        $tutors = $query->get();

        if(count($tutors) > 0){
            return $tutors;
        }else{
            return false;
        }
    }



    
     /**
     * Method updateUser
     *
     * @param array $data [explicite description]
     * @param int   $id   [explicite description]
     *
     * @return User
     */
    public function changeUserStaus()
    {
        
        try {
            DB::beginTransaction();
                if(Auth::user()->is_available == 1)
                {
                   $is_available = 0;
                }
                else
                {
                    $is_available = 1;
                }
            DB::commit();
            $data = User::find($id);
            $data->is_available = $is_available;
            $data->update();
            return $data;
        } catch (Exception $e) {
            DB::rollBack();
            throw $e;
        }
    }


}

<?php

namespace App\Observers;

use App\Models\User;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use App\Repositories\ClassRepository;
use App\Repositories\BlogRepository;

class UserObserver
{
    protected $userRepository;
    protected $classRepository;
    protected $blogRepository;
    /**
     * Method __construct
     *
     * @param UserRepository $userRepository [explicite description]
     *
     * @return void
     */
    public function __construct(
        UserRepository $userRepository,
        ClassRepository $classRepository,
        BlogRepository $blogRepository
    ) {
        $this->userRepository = $userRepository;
        $this->classRepository = $classRepository;
        $this->blogRepository = $blogRepository;
    }

    /**
     * Handle the user "created" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function created(User $user)
    {
        $name = $user->name;
        $user->referral_code = generateReferralCode();
        if ($user->user_role && $user->user_role === User::TYPE_STUDENT) {
            $user->is_verified = 1;
            $user->is_profile_completed = 1;
        }

        if (!$user->translate(config('app.fallback_locale'))) {
            $user->setDefaultLocale('en');
            $user->name = $name;
        }
        $user->saveWithoutEvents();
    }

    /**
     * Handle the user "updated" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function updated(User $user)
    {
        $profileCompleted = false;
        if ($user->user_type == User::TYPE_STUDENT) {
            if ($user->levels
                && $user->subjects
                && $user->languages
                && $user->generalKnowledge
            ) {
                $profileCompleted = true;
            }
        } elseif ($user->user_type == User::TYPE_TUTOR) {

            if (!is_null($user->translate('ar')) && !is_null($user->translate('ar')->bio)) {
                $user->translate('en')->bio = $user->translate('ar')->bio;
                $user->saveWithoutEvents();
            }

            if ($user->bio
                && count($user->educations)
            ) {
                $profileCompleted = true;
            }
        }

        if (!$user->is_profile_completed && $profileCompleted) {
            $user->is_profile_completed = 1;
            $user->saveWithoutEvents();
        }

        $oldEmail = $user->getOriginal('email');
        if (Auth::check()
            && Auth::user()->user_type == User::TYPE_ADMIN
            && $user->email != $oldEmail
        ) {
            $user->is_force_logout = 1;
            $user->saveWithoutEvents();
        }

        if ($user->status == User::STATUS_INACTIVE) {
            if ($user->device && $user->device->access_token) {
                invalidateTokenString($user->device->access_token);
            }
        }
    }

    /**
     * Handle the user "deleted" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function deleted(User $user)
    {
        // updating the tutor
        if ($user->isTutor()) {
            $getAllUpcomingClass = [
                'class_status' => 'upcoming',
                'is_paginate' => true,
            ];
            $classes = $this->classRepository->getClasses($getAllUpcomingClass);
            if (count($classes) > 0) {
                foreach ($classes as $class) {
                    $data = [
                        'is_system' => true,
                        'user_id' => $user->id,
                        'class_id' => $class->id,
                    ];
                    $cancelClass = $this->classRepository->cancelClass($data);
                }
            }
            $this->blogRepository->deleteUsersBlog($user->id);
        }
    }

    /**
     * Handle the user "restored" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function restored(User $user)
    {
        //
    }

    /**
     * Handle the user "force deleted" event.
     *
     * @param User $user
     *
     * @return void
     */
    public function forceDeleted(User $user)
    {
        //
    }
}

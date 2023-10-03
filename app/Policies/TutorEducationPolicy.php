<?php

namespace App\Policies;

use App\Models\TutorEducation;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TutorEducationPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any tutor certificates.
     *
     * @param User $user 
     * 
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return true;
    }

    /**
     * Determine whether the user can view the tutor certificate.
     *
     * @param User           $user 
     * @param TutorEducation $tutorEducation 
     * 
     * @return mixed
     */
    public function view(User $user, TutorEducation $tutorEducation)
    {
        return true;
    }

    /**
     * Determine whether the user can create tutor certificates.
     *
     * @param User $user 
     * 
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->id > 0 && $user->user_type == User::TYPE_TUTOR;
    }

    /**
     * Determine whether the user can update the tutor certificate.
     *
     * @param User           $user 
     * @param TutorEducation $tutorEducation 
     * 
     * @return mixed
     */
    public function update(User $user, TutorEducation $tutorEducation)
    {
        //
    }

    /**
     * Determine whether the user can delete the tutor certificate.
     *
     * @param User           $user 
     * @param TutorEducation $tutorEducation 
     * 
     * @return mixed
     */
    public function delete(User $user, TutorEducation $tutorEducation)
    {
        return $user->id == $tutorEducation->tutor_id;
    }

    /**
     * Determine whether the user can restore the tutor certificate.
     *
     * @param User           $user 
     * @param TutorEducation $tutorEducation 
     * 
     * @return mixed
     */
    public function restore(User $user, TutorEducation $tutorEducation)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the tutor certificate.
     *
     * @param User           $user 
     * @param TutorEducation $tutorEducation 
     * 
     * @return mixed
     */
    public function forceDelete(User $user, TutorEducation $tutorEducation)
    {
        //
    }
}

<?php

namespace App\Policies;

use App\Models\TutorCertificate;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class TutorCertificatePolicy
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
     * @param User             $user 
     * @param TutorCertificate $tutorCertificate 
     * 
     * @return mixed
     */
    public function view(User $user, TutorCertificate $tutorCertificate)
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
        return $user->id > 0;
    }

    /**
     * Determine whether the user can update the tutor certificate.
     *
     * @param User             $user 
     * @param TutorCertificate $tutorCertificate 
     * 
     * @return mixed
     */
    public function update(User $user, TutorCertificate $tutorCertificate)
    {
        //
    }

    /**
     * Determine whether the user can delete the tutor certificate.
     *
     * @param User             $user 
     * @param TutorCertificate $tutorCertificate 
     * 
     * @return mixed
     */
    public function delete(User $user, TutorCertificate $tutorCertificate)
    {
        return $user->id == $tutorCertificate->tutor_id;
    }

    /**
     * Determine whether the user can restore the tutor certificate.
     *
     * @param User             $user 
     * @param TutorCertificate $tutorCertificate 
     * 
     * @return mixed
     */
    public function restore(User $user, TutorCertificate $tutorCertificate)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the tutor certificate.
     *
     * @param User             $user 
     * @param TutorCertificate $tutorCertificate 
     * 
     * @return mixed
     */
    public function forceDelete(User $user, TutorCertificate $tutorCertificate)
    {
        //
    }
}

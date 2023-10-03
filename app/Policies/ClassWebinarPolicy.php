<?php

namespace App\Policies;

use App\Models\ClassWebinar;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClassWebinarPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any class webinars.
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
     * Determine whether the user can view the class webinar.
     *
     * @param User         $user  
     * @param ClassWebinar $classWebinar 
     * 
     * @return mixed
     */
    public function view(User $user, ClassWebinar $classWebinar)
    {
        return true;
    }

    /**
     * Determine whether the user can create class webinars.
     *
     * @param User $user 
     * 
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isTutor();
    }

    /**
     * Determine whether the user can update the class webinar.
     *
     * @param User         $user 
     * @param ClassWebinar $classWebinar 
     * 
     * @return mixed
     */
    public function update(User $user, ClassWebinar $classWebinar)
    {
        return $user->id == $classWebinar->tutor_id;
    }

    /**
     * Determine whether the user can delete the class webinar.
     *
     * @param User         $user 
     * @param ClassWebinar $classWebinar 
     * 
     * @return mixed
     */
    public function delete(User $user, ClassWebinar $classWebinar)
    {
        return $user->id == $classWebinar->tutor_id;
    }

    /**
     * Determine whether the user can restore the class webinar.
     *
     * @param User         $user 
     * @param ClassWebinar $classWebinar 
     * 
     * @return mixed
     */
    public function restore(User $user, ClassWebinar $classWebinar)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the class webinar.
     *
     * @param User         $user 
     * @param ClassWebinar $classWebinar 
     * 
     * @return mixed
     */
    public function forceDelete(User $user, ClassWebinar $classWebinar)
    {
        //
    }
}

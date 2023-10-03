<?php

namespace App\Policies;

use App\Models\ExtraHourRequest;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ExtraHourRequestPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any extra hour request.
     *
     * @param User $user 
     * 
     * @return mixed
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the extra hour request.
     *
     * @param User      $user 
     * @param RaiseHand $raiseHand 
     * 
     * @return mixed
     */
    public function view(User $user, ExtraHourRequest $extraHourRequest)
    {
        //
    }

    /**
     * Determine whether the user can create extra hour request.
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
     * Determine whether the user can update the extra hour request.
     *
     * @param User      $user 
     * @param ExtraHourRequest $extraHourRequest 
     * 
     * @return mixed
     */
    public function update(User $user, ExtraHourRequest $extraHourRequest)
    {
        return $user->isStudent();
    }

    /**
     * Determine whether the user can delete the extra hour request.
     *
     * @param User      $user 
     * @param ExtraHourRequest $extraHourRequest 
     * 
     * @return mixed
     */
    public function delete(User $user, ExtraHourRequest $extraHourRequest)
    {
        //
    }

    /**
     * Determine whether the user can restore the extra hour request.
     *
     * @param User      $user 
     * @param ExtraHourRequest $extraHourRequest 
     * 
     * @return mixed
     */
    public function restore(User $user, ExtraHourRequest $extraHourRequest)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the raise hand.
     *
     * @param User      $user 
     * @param ExtraHourRequest $extraHourRequest 
     * 
     * @return mixed
     */
    public function forceDelete(User $user, ExtraHourRequest $extraHourRequest)
    {
        //
    }
}

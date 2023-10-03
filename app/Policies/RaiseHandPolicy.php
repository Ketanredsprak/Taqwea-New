<?php

namespace App\Policies;

use App\Models\User;
use App\Models\RaiseHand;
use Illuminate\Auth\Access\HandlesAuthorization;

class RaiseHandPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any raise hands.
     *
     * @param User $user 
     * 
     * @return mixed
     */
    public function viewAny(User $user)
    {
        return $user->isTutor();
    }

    /**
     * Determine whether the user can view the raise hand.
     *
     * @param User      $user 
     * @param RaiseHand $raiseHand 
     * 
     * @return mixed
     */
    public function view(User $user, RaiseHand $raiseHand)
    {
        return $user->isTutor();
    }

    /**
     * Determine whether the user can create raise hands.
     *
     * @param User $user 
     * 
     * @return mixed
     */
    public function create(User $user)
    {
        return $user->isStudent();
    }

    /**
     * Determine whether the user can update the raise hand.
     *
     * @param User      $user 
     * @param RaiseHand $raiseHand 
     * 
     * @return mixed
     */
    public function update(User $user, RaiseHand $raiseHand)
    {
        return ($user->isTutor() || $user->isStudent());
    }

    /**
     * Determine whether the user can delete the raise hand.
     *
     * @param User      $user 
     * @param RaiseHand $raiseHand 
     * 
     * @return mixed
     */
    public function delete(User $user, RaiseHand $raiseHand)
    {
        //
    }

    /**
     * Determine whether the user can restore the raise hand.
     *
     * @param User      $user 
     * @param RaiseHand $raiseHand 
     * 
     * @return mixed
     */
    public function restore(User $user, RaiseHand $raiseHand)
    {
        //
    }

    /**
     * Determine whether the user can permanently delete the raise hand.
     *
     * @param User      $user 
     * @param RaiseHand $raiseHand 
     * 
     * @return mixed
     */
    public function forceDelete(User $user, RaiseHand $raiseHand)
    {
        //
    }
}

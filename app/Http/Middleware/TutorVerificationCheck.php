<?php

namespace App\Http\Middleware;
use Illuminate\Support\Facades\Auth;
use Closure;

/**
 * Class for check tutor verification check
 */
class TutorVerificationCheck
{
    /**
     * Handle an incoming request.
     *
     * @param \Illuminate\Http\Request $request 
     * @param \Closure                 $next 
     * 
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->checkUserVerification(Auth::guard('web')->user())) {
            return redirect('tutor/logout');
        }

        if (!$this->checkUserProfileComplete(Auth::guard('web')->user())) {
            return redirect('tutor/complete-profile');
        }

        if (!$this->checkUserProfileApproved(Auth::guard('web')->user())) {
            return redirect('tutor/verification-pending');
        }

        return $next($request);
    }

    /**
     * Check user is verified or not
     * 
     * @param $user 
     * 
     * @return int
     */
    protected function checkUserVerification($user)
    {
        if ($user->is_verified) {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    }

    /**
     * Check user is verified or not
     * 
     * @param $user 
     * 
     * @return int
     */
    protected function checkUserProfileComplete($user)
    {
        if ($user->is_profile_completed) {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    }

    /**
     * Check user is approved or not
     * 
     * @param $user 
     * 
     * @return int
     */
    protected function checkUserProfileApproved($user)
    {
        if ($user->is_approved) {
            $response = true;
        } else {
            $response = false;
        }
        return $response;
    }
}

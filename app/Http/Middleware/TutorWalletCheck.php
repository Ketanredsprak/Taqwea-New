<?php

namespace App\Http\Middleware;

use Illuminate\Support\Facades\Auth;
use Closure;
use App\Models\Wallet;

class TutorWalletCheck
{
    /**
     * Handle an incoming request.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \Closure  $next
     * @return mixed
     */
    public function handle($request, Closure $next)
    {
        if (!$this->checkWalletBalance(Auth::guard('web')->user())) {
            return redirect('tutor/wallet');
        }
        return $next($request);
    }

    /**
     * Method checkWalletBalance
     * 
     * @param object $user 
     * 
     * @return bool
     */
    public function checkWalletBalance($user):bool
    {
        $balance =  Wallet::availableBalance($user->id);
        if ($balance < 0) {
            return false;
        }
        return true;
    }
}

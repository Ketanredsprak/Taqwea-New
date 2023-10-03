<?php

namespace App\Http\Controllers\Web;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Share;

/**
 * ReferController class
 */
class ReferralCodeController extends Controller
{
    protected $userRepository;

    /**
     * Method __construct 
     * 
     * @param UserRepository $userRepository 
     * 
     * @return void
     */
    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }
    /**
     * Display a listing of the resource.
     * 
     * @param \Illuminate\Http\Request $request [explicite description]
     * 
     * @return View
     */
    public function index(Request $request)
    {
        $params['currentPage'] = 'referAndEarn';
        $params['title'] = trans("labels.refer_earn");

        $user = Auth::guard('web')->user();
        $params['data'] = $user;
        $url = URL::route('show/signup', ['referral_code' => $user->referral_code]);
        $shareLinks = Share::page(
            urlencode($url),
            __('message.referral_message_text'),
        )
            ->facebook()
            ->twitter()
            ->linkedin()
            ->whatsapp()
            ->getRawLinks();
        $params['shareLinks'] = $shareLinks;

        return view(
            'frontend.referral-code.index',
            $params
        );
    }
}

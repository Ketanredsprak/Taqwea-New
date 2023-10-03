<li class="nav-item nav-item--user dropdown">
    <a class="dropdown-toggle nav-link" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="{{ Auth::user()->profile_image_url }}" alt="user" class="userImg img-fluid" />
    </a>

    <div class="dropdown-menu" aria-labelledby="userDropdown">
        <a class="userInfo d-flex align-items-center" href="{{ route('tutor.profile.edit') }}">
            <div class="userInfo__img">
                <img src="{{ Auth::user()->profile_image_url }}" alt="user" class="img-fluid" />
            </div>
            <div class="userInfo__name text-truncate">
                {{ ucfirst(Auth::user()->name) }}
            </div>
        </a>
        <div class="sub-menu">
            <a class="dropdown-item" href="{{route('tutor/dashboard')}}">
                <span class="dropdown-icon"><em class="icon-dashboard"></em></span>
                <span class="dropdown-txt">{{ __('labels.dashboard') }}</span>
            </a>
            <a class="dropdown-item" href="{{ route('tutor.classes.index') }}">
                <span class="dropdown-icon"><em class="icon-class-booking"></em></span>
                <span class="dropdown-txt">{{ __('labels.my_classes') }}</span>
            </a>
            <a class="dropdown-item" href="{{ route('tutor.webinars.index') }}">
                <span class="dropdown-icon"><em class="icon-webinar-booking"></em></span>
                <span class="dropdown-txt">{{ __('labels.my_webinars') }}</span>
            </a>
            <a class="dropdown-item" href="{{ route('tutor.referral-code.index')}}">
                <span class="dropdown-icon"><em class="icon-refer"></em></span>
                <span class="dropdown-txt">{{ __('labels.refer_earn') }}</span>
            </a>
            <a class="dropdown-item" href="{{route('tutor.rating.index')}}">
                <span class="dropdown-icon"><em class="icon-rating"></em></span>
                <span class="dropdown-txt">{{ __('labels.my_ratings') }}</span>
            </a>
            <a class="dropdown-item" href="{{route('tutor.subscription.index')}}">
                <span class="dropdown-icon"><em class="icon-subscription"></em></span>
                <span class="dropdown-txt">{{ __('labels.subscription') }}</span>
            </a>
            <a class="dropdown-item" href="{{route('tutor.classrequest.index')}}">
                <span class="dropdown-icon"><em class="icon-rating"></em></span>
                <span class="dropdown-txt">{{__('labels.tutor_class_request') }}</span>
            </a>

            @if(Auth::user()->userSocialLogin)
            <a class="dropdown-item" href="javascript:void(0)">
                @else
                <a class="dropdown-item" href="{{ route('tutor.change-password.index') }}">
                    @endif
                    <span class="dropdown-icon"><em class="icon-lock"></em></span>
                    <span class="dropdown-txt">{{ __('labels.change_password') }}</span>
                </a>
                <a class="dropdown-item" href="{{ route('tutor.payment-method.index') }}">
                    <span class="dropdown-icon"><em class="icon-card"></em></span>
                    <span class="dropdown-txt">{{ __('labels.payment_method') }}</span>
                </a>
                <a class="dropdown-item" href="{{ route('tutor.wallet.index') }}">
                    <span class="dropdown-icon"><em class="icon-wallet"></em></span>
                    <span class="dropdown-txt">{{ __('labels.wallet') }}</span>
                </a>
                <a class="dropdown-item" href="{{ route('tutor.transactions.index') }}">
                    <span class="dropdown-icon"><em class="icon-dollar"></em></span>
                    <span class="dropdown-txt">{{ __('labels.my_transactions') }}</span>
                </a>
                <a class="dropdown-item" href="{{route('contact-us')}}">
                    <span class="dropdown-icon"><em class="icon-support"></em></span>
                    <span class="dropdown-txt">{{ __('labels.support') }}</span>
                </a>
                <a class="dropdown-item" href="{{ url('faq') }}">
                    <span class="dropdown-icon"><em class="icon-question"></em></span>
                    <span class="dropdown-txt">{{ __('labels.faq') }}</span>
                </a>
                <a class="dropdown-item" href="{{ route('tutor/logout') }}">
                    <span class="dropdown-icon"><em class="icon-logout"></em></span>
                    <span class="dropdown-txt">{{ __('labels.logout') }}</span>
                </a>
        </div>
    </div>
</li>
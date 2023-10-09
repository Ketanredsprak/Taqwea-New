<li class="nav-item nav-item--user dropdown">
    <a class="dropdown-toggle nav-link" href="#" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
        <img src="{{ Auth::user()->profile_image_url }}" alt="user" class="userImg img-fluid" />
    </a>

    <div class="dropdown-menu" aria-labelledby="userDropdown">
        <a class="userInfo d-flex align-items-center" href="{{ route('student.profile.edit') }}">
            <div class="userInfo__img">
                <img src="{{ Auth::user()->profile_image_url }}" alt="user" class="img-fluid" />
            </div>
            <div class="userInfo__name text-truncate text-capitalize">
                {{ ucfirst(Auth::user()->name) }}
            </div>
        </a>
     <div class="sub-menu">  
        <a class="dropdown-item" href="{{route('student/dashboard')}}">
            <span class="dropdown-icon"><em class="icon-dashboard"></em></span>
            <span class="dropdown-txt">{{ __('labels.dashboard') }}</span>
        </a>
        <a class="dropdown-item" href="{{route('student.classes.index')}}">
            <span class="dropdown-icon"><em class="icon-class-booking"></em></span>
            <span class="dropdown-txt">{{ __('labels.my_classes') }}</span>
        </a>
        <a class="dropdown-item" href="{{ route('student.webinars.index') }}">
            <span class="dropdown-icon"><em class="icon-webinar-booking"></em></span>
            <span class="dropdown-txt">{{ __('labels.my_webinars') }}</span>
        </a>
        <a class="dropdown-item" href="{{ route('student.blog') }}">
            <span class="dropdown-icon"><em class="icon-play"></em></span>
            <span class="dropdown-txt">{{ __('labels.purchase_blog_video') }}</span>
        </a>
        <a class="dropdown-item" href="{{ route('student.referral-code.index')}}">
            <span class="dropdown-icon"><em class="icon-refer"></em></span>
            <span class="dropdown-txt">{{ __('labels.refer_earn') }}</span>
        </a>
        <a class="dropdown-item" href="{{route('student.rating.index')}}">
            <span class="dropdown-icon"><em class="icon-rating"></em></span>
            <span class="dropdown-txt">{{__('labels.my_ratings') }}</span>
        </a>
        <a class="dropdown-item" href="{{route('student.classrequest.index')}}">
            <span class="dropdown-icon"><em class="icon-pencil"></em></span>
            <span class="dropdown-txt">{{__('labels.class_request') }}</span>
        </a>
        @if(Auth::user()->userSocialLogin)
        <a class="dropdown-item" href="javascript:void(0)">
            @else
            <a class="dropdown-item" href="{{route('student.change-password.index')}}">
                @endif
                <span class="dropdown-icon"><em class="icon-lock"></em></span>
                <span class="dropdown-txt">{{ __('labels.change_password') }}</span>
            </a>
            <a class="dropdown-item" href="{{route('student.payment-method.index')}}">
                <span class="dropdown-icon"><em class="icon-card"></em></span>
                <span class="dropdown-txt">{{ __('labels.payment_method') }}</span>
            </a>
            <a class="dropdown-item" href="{{ route('student.wallet.index') }}">
                <span class="dropdown-icon"><em class="icon-wallet"></em></span>
                <span class="dropdown-txt">{{ __('labels.wallet') }}</span>
            </a>
            <a class="dropdown-item" href="{{ route('student.transactions.index') }}">
                <span class="dropdown-icon"><em class="icon-dollar"></em></span>
                <span class="dropdown-txt">{{ __('labels.my_transactions') }}</span>
            </a>
            <a class="dropdown-item" href="{{ url('faq') }}">
                <span class="dropdown-icon"><em class="icon-question"></em></span>
                <span class="dropdown-txt">{{ __('labels.faq') }}</span>
            </a>
            <a class="dropdown-item" href="{{ route('student/logout') }}">
                <span class="dropdown-icon"><em class="icon-logout"></em></span>
                <span class="dropdown-txt">{{ __('labels.logout') }}</span>
            </a>
        </div> 
    </div>
</li>
<div class="commonSideBar common-shadow bg-white">
    <a href="#" id="closeMenu" class="linkPrimary closeMenu d-xl-none">&times;</a>
    <aside class="commonSideBar__inner">
        <ul class="list-unstyled">
            <li>
                <a href="{{ route('tutor.profile.edit') }}" class="{{ ($currentPage =='editProfile')?'active':'' }}"><em class="icon-user-icon"></em><span>{{ __('labels.edit_profile') }}</span></a>
            </li>
            <li>
                <a href="{{ route('tutor.classes.index') }}" class="{{ ($currentPage =='myClasses')?'active':'' }}"><em class="icon-class-booking"></em><span>{{ __('labels.my_classes') }}</span></a>
            </li>
            <li>
                <a href="{{ route('tutor.webinars.index') }}" class="{{ ($currentPage =='myWebinars')?'active':'' }}"><em class="icon-webinar-booking"></em><span>{{ __('labels.my_webinars') }}</span></a>
            </li>
            <li>
                <a href="{{ route('tutor.blogs.index') }}" class="{{ ($currentPage =='myBlog')?'active':'' }}"><em class="icon-play"></em><span>{{ __('labels.my_blog_video') }}</span></a>
            </li>
            <li>
                <a href="{{route('tutor.referral-code.index')}}" class="{{($currentPage == 'referAndEarn') ? 'active':''}}"><em class="icon-refer"></em><span>{{ __('labels.refer_earn') }}</span></a>
            </li>
            <li>
                <a href="{{route('tutor.rating.index')}}" class="{{ ($currentPage =='myRating')?'active':'' }}"><em class="icon-rating"></em><span>{{ __('labels.my_ratings') }}</span></a>
            </li>
            <li>
                <a href="{{route('tutor.subscription.index')}}" class="{{ ($currentPage == 'subscription') ? 'active' : '' }}"><em class="icon-subscription"></em><span>{{ __('labels.subscription') }}</span></a>
            </li>
            <li>
                @if(Auth::user()->userSocialLogin)
                <a href="javascript:void(0)"><em class="icon-lock"></em><span>{{ __('labels.change_password') }}</span></a>
                @else
                <a href="{{ route('tutor.change-password.index') }}" class="{{ ($currentPage =='changePassword')?'active':'' }}"><em class="icon-lock"></em><span>{{ __('labels.change_password') }}</span></a>
                @endif
            </li>
            <li>
                <a href="{{ route('tutor.payment-method.index') }}" class="{{ ($currentPage =='paymentMethod')?'active':'' }}"><em class="icon-card"></em><span>{{ __('labels.payment_method') }}</span></a>
            </li>
            <li>
                <a href="{{ route('tutor.wallet.index') }}" class="{{ ($currentPage =='myWallet')?'active':'' }}"><em class="icon-wallet"></em><span>{{ __('labels.wallet') }}</span></a>
            </li>
            <li>
                <a href="{{ route('tutor.transactions.index') }}" class="{{ ($currentPage =='myTransactions')?'active':'' }}"><em class="icon-dollar"></em><span>{{ __('labels.my_transactions') }}</span></a>
            </li>
            <li>
                <a href="{{ route('tutor.classrequest.index') }}" class="{{ ($currentPage =='TutorClassRequest')?'active':'' }}"><em class="icon-bell"></em><span>{{ __('labels.my_classrequest') }}</span></a>
            </li>

        </ul>
    </aside>
</div>
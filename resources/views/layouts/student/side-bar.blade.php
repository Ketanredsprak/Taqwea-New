<div class="commonSideBar common-shadow bg-white sideMenu">
    <a href="javascript:void(0);" id="closeMenu" class="linkPrimary closeMenu d-xl-none">&times;</a>
    <aside class="commonSideBar__inner">
        <ul class="list-unstyled">
            <li>
                <a href="{{route('student.profile.edit')}}" class="{{ ($currentPage =='editProfile')?'active':'' }}"><em class="icon-user-icon"></em><span>{{ __('labels.edit_profile') }}</span></a>
            </li>
            <li>
                <a href="{{route('student.classes.index')}}" class="{{ ($currentPage =='myClasses')?'active':'' }}"><em class="icon-class-booking"></em><span>{{ __('labels.my_classes') }}</span></a>
            </li>
            <li>
                <a href="{{route('student.webinars.index')}}" class="{{ ($currentPage =='myWebinars')?'active':'' }}"><em class="icon-webinar-booking"></em><span>{{ __('labels.my_webinars') }}</span></a>
            </li>
            <li>
                <a href="{{ route('student.blog') }}" class="{{ ($currentPage =='blogsPurchase')?'active':'' }} "><em class="icon-play"></em><span>{{ __('labels.purchase_blog_video') }}</span></a>
            </li>
            <li>
                <a href="{{route('student.referral-code.index')}}" class="{{($currentPage == 'referAndEarn') ? 'active':''}}"><em class="icon-refer"></em><span>{{ __('labels.refer_earn') }}</span></a>
            </li>
            <li>
                <a href="{{route('student.rating.index'),$currentPage}}" class="{{ ($currentPage =='myRating')?'active':'' }}"><em class="icon-rating"></em><span>{{__('labels.my_ratings') }}</span></a>
            </li>
            <li>
                @if(Auth::user()->userSocialLogin)
                <a href="javascript:void(0)"><em class="icon-lock"></em><span>{{ __('labels.change_password') }}</span></a>
                @else
                <a href="{{route('student.change-password.update')}}" class="{{ ($currentPage =='changePassword')?'active':'' }}"><em class="icon-lock"></em><span>{{ __('labels.change_password') }}</span></a>
                @endif
            </li>
            <li>
                <a href="{{ route('student.payment-method.index') }}" class="{{ ($currentPage =='paymentMethod')?'active':'' }}"><em class="icon-card"></em><span>{{ __('labels.payment_method') }}</span></a>
            </li>
            <li>
                <a href="{{ route('student.wallet.index') }}" class="{{ ($currentPage =='myWallet')?'active':'' }}"><em class="icon-wallet"></em><span>{{ __('labels.wallet') }}</span></a>
            </li>
            <li>
                <a href="{{ route('student.transactions.index') }}" class="{{ ($currentPage =='myTransactions')?'active':'' }}"><em class="icon-dollar"></em><span>{{ __('labels.my_transactions') }}</span></a>
            </li>

            <li>
                <a href="{{ route('student.classrequest.index') }}" class="{{ ($currentPage =='classRequest')?'active':'' }}"><em class="icon-pencil"></em><span>{{ __('labels.class_request') }}</span></a>
            </li>
            {{-- <li>
                <a href="{{ route('student.tutorclassrequest.index') }}" class="{{ ($currentPage =='classRequest')?'active':'' }}"><em class="icon-pencil"></em><span>{{ __('labels.tutor_class_request') }}</span></a>
            </li> --}}


        </ul>
    </aside>
</div>
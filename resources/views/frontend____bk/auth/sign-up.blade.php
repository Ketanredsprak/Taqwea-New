@extends('layouts.frontend.app')
@section('title',__('labels.sign_up'))
@push('css')
<link href="{{ asset('assets/css/frontend/auth.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<main class="mainContent">
    <div class="authPage bg-green">
        <div class="authPage-content d-flex">
            <div class="authPage-content_left d-flex flex-column">
                <div class="authSlider my-auto" id="authSlider">
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.search_qualified_tutors') }}</h2>
                            <p>{{ __('labels.we_have_qualified_tutors_to_teach') }} <br> {{ __('labels.make_that_subject_easy') }}</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.book_classes') }}</h2>
                            <p>{{ __('labels.book_the_desired_class') }} <br> {{ __('labels.of_class_and_tutor_ratings') }}</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.payment') }}</h2>
                            <p>{{ __('labels.quick_and_easy_payment') }} <br> {{ __('labels.class_booking') }}</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.start_learning') }}</h2>
                            <p>{{ __('labels.start_your_class_and_enjoy_learning') }} <br> {{ __('labels.with_taqwea') }}</p>
                        </div>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="{{ asset('assets/images/auth.png') }}" class="img-fluid" alt="{{ __('lables.auth') }}">
                </div>
            </div>
            <div class="authPage-content_right">
                <a href="{{ route('home') }}" class="linkDark font-sm d-inline-flex align-items-center backLink"><span class="icon-left-arrow mr-2"></span> {{ __('labels.back') }}</a>
                <div class="boxContent my-auto">
                    <div class="boxContent-inner">
                        <div class="boxContent-nav text-center">
                            <ul class="nav nav-pills d-inline-flex">
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript:void(0);">{{ __('labels.signup') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link" href="{{ route('show/login') }}">{{ __('labels.login') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="boxContent-form position-relative">
                            <form action="{{ route('signup') }}" method="post" id="signUpForm" novolidate>
                                <h5 class="boxContent_subhead font-eb">{{ __('labels.signup_as') }}</h5>
                                <div class="form-group">
                                    <div class="custom-control custom-radio d-inline-flex">
                                        <input type="radio" name="user_role" value="student" id="customRadio1" name="signup" aria-describedby="user_role-error" class="custom-control-input" {{ (@$_GET['role'] == 'student')?'checked':'' }}>
                                        <label class="custom-control-label font-bd" for="customRadio1">{{ __('labels.student') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-flex ml-5">
                                        <input type="radio" name="user_role" value="tutor" id="customRadio2" name="signup" class="custom-control-input" {{ (@$_GET['role']=='tutor')?'checked':'' }}>
                                        <label class="custom-control-label font-bd" for="customRadio2">{{ __('labels.tutor') }}</label>
                                    </div>
                                    <div>
                                        <span id="user_role-error" class="invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('labels.name') }}</label>
                                    <input name="name" type="text" class="form-control" dir="rtl" placeholder="{{ __('labels.enter_name') }}" autocomplete="nope">
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('labels.email_id') }}</label>
                                    <input name="email" type="email" class="form-control" dir="rtl" placeholder="{{ __('labels.enter_email_id') }}" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label">{{ __('labels.mobile_number') }}</label>
                                        {{--<span class="font-sm">{{ __('labels.optional') }}</span>--}}
                                    </div>
                                    <input name="phone_number" type="text" dir="rtl" class="form-control only-number" maxlength="12" placeholder="{{ __('labels.mobile_number') }}" autocomplete="off">
                                </div>
                                <div class="form-group">
                                    <label class="form-label d-block">{{__('labels.gender')}}</label>
                                    <div class="custom-control custom-radio d-inline-flex">
                                        <input type="radio" name="gender" value="male" id="male" name="signup" class="custom-control-input" aria-describedby="gender-error">
                                        <label class="custom-control-label font-bd" for="male">{{__('labels.male')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-flex ml-5">
                                        <input type="radio" name="gender" value="female" id="female" name="signup" class="custom-control-input">
                                        <label class="custom-control-label font-bd" for="female">{{__('labels.female')}}</label>
                                    </div>
                                    <div>
                                        <span id="gender-error" class="invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label">{{ __('labels.referral_code') }}</label>
                                        <span class="font-sm">{{ __('labels.optional') }}</span>
                                    </div>
                                    <input name="referral_code" type="text" dir="rtl" value="{{@$referralCode}}" class="form-control" placeholder="{{ __('labels.referral_code') }}">
                                </div>

                                <div class="form-group form-group-icon">
                                    <label class="form-label">{{ __('labels.password') }}</label>
                                    <input name="password" type="password" dir="rtl" class="form-control" placeholder="{{ __('labels.enter_password') }}" autocomplete="off">
                                    <a href="javascript:void(0);" id="showPassword" class="icon"><span class="icon-eye"></span></a>
                                </div>
                                <div class="form-group form-group-icon">
                                    <label class="form-label">{{ __('labels.confirm_password') }}</label>
                                    <input name="confirm_password" type="password" dir="rtl" class="form-control" placeholder="{{ __('labels.confirm_password') }}" autocomplete="off">
                                    <a href="javascript:void(0);" id="showPassword2" class="icon"><span class="icon-eye"></span></a>
                                </div>

                                <div class="submitBtn">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input name="terms_of_service" type="checkbox" class="custom-control-input" id="customCheck1" aria-describedby="terms_of_service-error">
                                        <label class="custom-control-label" for="customCheck1">{{ __('labels.accept') }} <a href="{{ url('terms-and-condition') }}" target="_blank" class="linkPrimary">{{ __('labels.terms_conditions') }}</a></label>
                                        <div>
                                            <span id="terms_of_service-error" class="invalid-feedback"></span>
                                        </div>
                                    </div>

                                    <button type="submit" class="btn btn-primary btn-block btn-lg ripple-effect" id="signUpBtn">{{ __('labels.signup') }}</button>
                                </div>
                                <div class="orSaperator position-relative text-center">
                                    <div class="orSaperator_text d-inline-flex font-bd position-relative">{{__('labels.or')}}</div>
                                </div>

                                <ul class="list-inline text-center mb-0 socialLogin">
                                    <li class="list-inline-item">
                                        <a href="{{ url('login/google') }}">
                                            <img src="{{ asset('assets/images/google.svg') }}" alt="google">
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{ url('login/apple') }}">
                                            <img src="{{ asset('assets/images/apple.svg') }}" alt="apple">
                                        </a>
                                    </li>
                                    <li class="list-inline-item">
                                        <a href="{{ url('login/twitter') }}">
                                            <img src="{{ asset('assets/images/twitter.svg') }}" alt="twitter">
                                        </a>
                                    </li>
                                </ul>
                            </form>
                            {!! JsValidator::formRequest('App\Http\Requests\Auth\SignupRequest', '#signUpForm') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('frontend.image-cropper-modal')
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/auth/signup.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/image-cropper.js')}}"></script>
@endpush

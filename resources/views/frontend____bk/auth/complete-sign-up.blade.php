@extends('layouts.frontend.app')
@section('title',__('labels.sign_up'))
@push('css')
<link href="{{ asset('assets/css/frontend/auth.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<main class="mainContent">
    <div class="authPage">
        <div class="authPage-content bg-green d-flex">
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
                        <div class="boxContent-head text-center">
                            <h1 class="boxContent-head_title font-eb">{{ __('labels.complete_sign_up') }}</h1>
                            <p>{{ __('labels.new_to_lms_create_your_account') }}</p>
                        </div>
                        <div class="boxContent-form position-relative">
                            <form action="{{ route('signup') }}" method="post" id="completeSignUpForm" novolidate>
                                <input type="hidden" name="id" value="{{ $user->id }}">
                                <h5 class="boxContent_subhead font-eb">{{ __('labels.signup_as') }}</h5>
                                <div class="form-group">
                                    <div class="custom-control custom-radio d-inline-flex">
                                        <input type="radio" value="student" id="customRadio1" name="user_role" class="custom-control-input" aria-describedby="user_role-error" {{ (@$user->user_type=='student')?'checked':'' }}>
                                        <label class="custom-control-label font-bd" for="customRadio1">{{ __('labels.student') }}</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-flex ml-5">
                                        <input type="radio" value="tutor" id="customRadio2" name="user_role" class="custom-control-input" {{ (@$user->user_type=='tutor')?'checked':'' }}>
                                        <label class="custom-control-label font-bd" for="customRadio2">{{ __('labels.tutor') }}</label>
                                    </div>
                                    <div>
                                        <span id="user_role-error" class="invalid-feedback"></span>
                                    </div>
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('labels.name') }}</label>
                                    <input name="name" value="{{ @$user->name }}" type="text" class="form-control" placeholder="{{ __('labels.enter_name') }}" {{ (@$user->name)?'disabled':'' }}>
                                    @if(@$user->name)
                                    <input name="name" value="{{ @$user->name }}" type="hidden" class="form-control">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label">{{ __('labels.email_id') }}</label>
                                    <input name="email" value="{{ @$user->email }}" type="email" class="form-control" placeholder="{{ __('labels.enter_email_id') }}" {{ (@$user->email)?'disabled':'' }}>
                                    @if(@$user->email)
                                    <input name="email" value="{{ @$user->email }}" type="hidden" class="form-control">
                                    @endif
                                </div>
                                <div class="form-group">
                                    <label class="form-label d-block">{{__('labels.gender')}}</label>
                                    <div class="custom-control custom-radio d-inline-flex">
                                        <input type="radio" name="gender" value="male" id="male" name="signup" class="custom-control-input" aria-describedby="gender-error" {{ (@$user->gender=='male')?'checked':'' }}>
                                        <label class="custom-control-label font-bd" for="male">{{__('labels.male')}}</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-flex ml-5">
                                        <input type="radio" name="gender" value="female" id="female" name="signup" class="custom-control-input" {{ (@$user->gender=='female')?'checked':'' }}>
                                        <label class="custom-control-label font-bd" for="female">{{__('labels.female')}}</label>
                                    </div>
                                    <br>
                                    <span id="gender-error" class="invalid-feedback"></span>
                                </div>
                                <div class="form-group">
                                    <div class="d-flex justify-content-between">
                                        <label class="form-label">{{ __('labels.referral_code') }}</label>
                                        <span class="font-sm">{{ __('labels.optional') }}</span>
                                    </div>
                                    <input name="referral_code" type="text" class="form-control" placeholder="{{ __('labels.referral_code') }}">
                                </div>
                                <div class="submitBtn">
                                    <div class="custom-control custom-checkbox mb-3">
                                        <input name="terms_of_service" type="checkbox" class="custom-control-input" id="customCheck1" aria-describedby="terms_of_service-error">
                                        <label class="custom-control-label" for="customCheck1">{{ __('labels.accept') }} <a href="{{ url('terms-and-condition') }}" target="_blank" class="linkPrimary">{{ __('labels.terms_conditions') }}</a></label>
                                        <div>
                                            <span id="terms_of_service-error" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg ripple-effect" id="completeSignUpBtn">{{ __('labels.submit') }}</button>
                                </div>
                            </form>
                            {!! JsValidator::formRequest('App\Http\Requests\Auth\CompleteSignupRequest', '#completeSignUpForm') !!}
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
<script type="text/javascript" src="{{asset('assets/js/frontend/auth/complete-signup.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/image-cropper.js')}}"></script>
@endpush
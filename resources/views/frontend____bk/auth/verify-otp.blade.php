@extends('layouts.frontend.app')
@section('title', __('labels.verify_otp'))
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
                @if($type=='registration')
                <a href="{{ route('show/signup', ['userRole' => 'tutor']) }}" class="linkDark font-sm d-inline-flex align-items-center backLink"><span class="icon-left-arrow mr-2"></span> {{__('labels.back')}}</a>
                @endif
                @if($type=='forgot_password')
                <a href="{{ route('frontend/forgot-password') }}" class="linkDark font-sm d-inline-flex align-items-center backLink"><span class="icon-left-arrow mr-2"></span>{{__('labels.back_to_forgot')}}</a>
                @endif
                <div class="boxContent my-auto">
                    <div class="boxContent-inner boxContent-inner-varifyOtp">
                        <div class="boxContent-head text-center">
                            <h1 class="boxContent-head_title font-eb">{{ __('labels.verification_code') }}</h1>
                            <p>{{ __('labels.please_type_the_verification_code') }} {{ obfuscateEmail($user->email) }}</p>
                            <p style="color:red">{{__('labels.opt_email_worrying')}}</p>
                        </div>
                        <div class="timer font-bd text-center" id="timer"></div>
                        <div class="boxContent-form position-relative">
                            <form action="" id="verifyOtpForm">
                                <input type="hidden" name="token" value="{{ $token }}">
                                <input type="hidden" name="type" value="{{ $type }}">
                                <div class="form-group otp-group d-flex" dir="ltr">
                                    <input type="text" name="otp[1]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="" required>
                                    <input type="text" name="otp[2]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="" required>
                                    <input type="text" name="otp[3]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="" required>
                                    <input type="text" name="otp[4]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="" required>
                                </div>
                                <div class="submitBtn">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg ripple-effect" id="verifyOtpBtn">{{ __('labels.verify_code') }}</button>
                                </div>
                            </form>
                            <div class="boxContent-bottom text-center">
                                <p>{{ __('labels.i_dont_receive_any_code') }}</p>
                                <a href="javascript:void(0);" class="linkPrimary font-bd" id="resendOtp" onclick="resendOtp('{{ $user->email }}', '{{ $type }}')" style="display: none;">{{ __('labels.resend_code') }}</a>
                            </div>
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
<script type="text/javascript" src="{{asset('assets/js/frontend/auth/verify-otp.js')}}"></script>
@endpush
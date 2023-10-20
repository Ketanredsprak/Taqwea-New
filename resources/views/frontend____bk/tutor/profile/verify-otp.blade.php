@extends('layouts.tutor.app')
@section('title', 'Verify OTP')
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
                            <h2 class="font-eb">Search Qualified Tutors</h2>
                            <p>We have qualified tutors to teach you the subject and <br> make that subject easy for you.</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">Book Classes</h2>
                            <p>Book the desired class based on the agenda <br> of class and tutor ratings.</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">Payment</h2>
                            <p>Quick and easy payment for <br> class booking.</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">Start Learning</h2>
                            <p>Start your class and enjoy learning <br> with Taqwea.</p>
                        </div>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="{{ asset('assets/images/auth.png') }}" class="img-fluid" alt="auth">
                </div>
            </div>
            <div class="authPage-content_right">
                <a href="{{ url('tutor/profile/edit') }}" class="linkDark font-sm d-inline-flex align-items-center backLink"><span class="icon-left-arrow mr-2"></span> Back </a>
                <div class="boxContent my-auto">
                    <div class="boxContent-inner boxContent-inner-varifyOtp">
                        <div class="boxContent-head text-center">
                            <h1 class="boxContent-head_title font-eb">Verification Code</h1>
                            <p>Please type the verification code sent to your email id {{ obfuscateEmail($email) }}</p>
                        </div>
                        <div class="timer font-bd text-center" id="timer"></div>
                        <div class="boxContent-form position-relative">
                            <form action="" method="POST" id="verifyOtpForm" novalidate>
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group otp-group d-flex">
                                    <input type="text" name="otp[1]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="">
                                    <input type="text" name="otp[2]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="">
                                    <input type="text" name="otp[3]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="">
                                    <input type="text" name="otp[4]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="">
                                </div>
                                <div class="submitBtn">
                                    <button type="submit" class="btn btn-primary btn-block btn-lg ripple-effect" id="verifyOtpBtn">Verify Code</button>
                                </div>
                            </form>
                            <div class="boxContent-bottom text-center">
                                <p>I didn’t receive any code!</p>
                                <a href="javascript:void(0);" class="linkPrimary font-bd" id="resendOtp" onclick="resendOtp('{{ $email }}', 'change-email')" style="display: none;">Resend Code</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/verify-otp.js')}}"></script>
@endpush
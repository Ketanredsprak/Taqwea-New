@extends('layouts.admin.app')
@section('title','Login')
@section('content')

<!-- content @s -->
<div class="nk-content ">
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
        <div class="brand-logo pb-4 text-center">
            <a href="index.php" class="logo-link">
                <img class="logo-img-lg" src="{{ asset('assets/images/logo.svg') }}" alt="Taqwea Logo">
            </a>
        </div>
        <div class="card shadow-none">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h5 class="nk-block-title">Verification</h5>
                        <div class="nk-block-des">
                            <p>Enter the verification code we have just sent you on your email.</p>
                        </div>
                    </div>
                </div>
                <form id="otp-verification-frm" method="post" action="{{URL::TO('admin/opt-verification')}}" novalidate>
                    {{csrf_field()}}
                    <div class="form-group otp-group d-flex">
                        <input type="text" name="otp[1]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="">
                        <input type="text" name="otp[2]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="">
                        <input type="text" name="otp[3]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="">
                        <input type="text" name="otp[4]" class="text-center form-control otp-control otp-input" maxlength="1" placeholder="">
                    </div>
                    <div class="form-group text-center">
                        <input type="hidden" name="email" class="form-control" value="{{ session()->get('email') }}" id="user-email" />
                        <input type="hidden" name="otp" class="form-control" id="otp" />
                        <input type="hidden" name="type" value="two_factor_auth" class="form-control" />

                        <a class="link link-primary resend-otp" href="javascript:void(0);">Resend OTP</a>
                    </div>

                    <div class="form-group">
                        <button type="button" id="otp-verify" class="btn btn-lg btn-primary btn-block rounded-0 shadow-none ">Verify</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\OtpVerificationRequest','#otp-verification-frm') !!}
            </div>
        </div>
    </div>
</div>
<!-- wrap @e -->

@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/admin/auth/otp-verification.js')}}"></script>
@endpush
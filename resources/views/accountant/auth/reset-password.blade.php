@extends('layouts.accountant.app')
@section('title','Reset Password')
@section('content')
<div class="nk-wrap nk-wrap-nosidebar">
    <div class="nk-content ">
        <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
            <div class="brand-logo pb-4 text-center">
                <a href="javascript:void(0)" class="logo-link">
                    <img class="logo-img-lg" src="{{ asset('assets/images/logo.svg') }}" alt="Taqwea Logo">
                </a>
            </div>
            <div class="card shadow-none">
                <div class="card-inner card-inner-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h5 class="nk-block-title">Reset Password</h5>
                        </div>
                    </div>
                    <form id="confirmOtpFrm" method="post" action="{{URL::TO('accountant\post-reset-password')}}" novalidate>
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="form-label-group">
                                <label class="form-label" for="otp">Verify OTP <span class="text-danger">(4 digit OTP has been
                                        sent to your email address)</span></label>
                            </div>
                            <input type="hidden" name="email" value="{{ session()->get('email') }}" id="userEmail" />
                            <input type="text" class="form-control form-control-lg" id="otp" value="{{old('otp')}}" name="otp" placeholder="Enter OTP">
                            <div class="mt-1 resend-otp"><a class="link link-primary" href="javascript:void(0);">Resend OTP</a></div>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label class="form-label" for="newPassword">New Password</label>
                            </div>
                            <div class="form-control-wrap">
                                <a href="#" class="form-icon form-icon-right passcode-switch" data-target="newPassword">
                                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                </a>
                                <input type="password" value="{{old('new_password')}}" class="form-control form-control-lg" id="newPassword" placeholder="Enter new password" name="new_password">
                            </div>
                        </div>
                        <div class="form-group passwordInfo">
                            <h6>Password contains:</h6>
                            <p class="done"><em class="icon ni ni-check"></em> A capital letter &amp; a small letter.</p>
                            <p class="done"><em class="icon ni ni-check"></em> A special character &amp; a number.</p>
                            <p><em class="icon ni ni-check"></em> 8-32 characters long.</p>
                        </div>
                        <div class="form-group">
                            <div class="form-label-group">
                                <label class="form-label" for="confirmPassword">Confirm New Password</label>
                            </div>
                            <div class="form-control-wrap">
                                <a href="#" class="form-icon form-icon-right passcode-switch" data-target="confirmPassword">
                                    <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                    <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                                </a>
                                <input type="password" value="{{old('confirm_password')}}" class="form-control form-control-lg" id="confirmPassword" placeholder="Confirm new password" name="confirm_password">
                            </div>
                        </div>
                        <div class="form-group">
                            <button id="confirmOtpBtn" class="btn btn-lg btn-primary btn-block">Reset Password</button>
                        </div>
                    </form>
                    {!! JsValidator::formRequest('App\Http\Requests\Admin\ResetPasswordRequest','#confirmOtpFrm') !!}
                </div>
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script >
    var email = "{{session()->get('email')}}";
</script>
<script type="text/javascript" src="{{asset('assets/js/accountant/auth/reset-password.js')}}"></script>
@endpush
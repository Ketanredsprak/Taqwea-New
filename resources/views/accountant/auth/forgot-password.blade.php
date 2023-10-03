@extends('layouts.accountant.app')
@section('title','Forgot-Password')
@section('content')
<div class="nk-wrap nk-wrap-nosidebar">
    <div class="nk-content ">
        <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
            <div class="brand-logo pb-4 text-center">
                <a href="javascript:void(0)" class="logo-link">
                    <img class="logo-img-lg" src="{{ asset('assets/images/logo.png') }}" alt="Taqwea Logo">
                </a>
            </div>
            <div class="card shadow-none">
                <div class="card-inner card-inner-lg">
                    <div class="nk-block-head">
                        <div class="nk-block-head-content">
                            <h4 class="nk-block-title">Forgot Password</h4>
                            <div class="nk-block-des">
                                <p>Password reset instructions will be sent to the registered Email</p>
                            </div>
                        </div>
                    </div>
                    <form id="sendOtpFrm" method="post" action="{{Route('forgot-password')}}" novalidate>
                        {{csrf_field()}}
                        <div class="form-group">
                            <div class="form-label-group">
                                <label class="form-label" for="email">Email Address</label>
                            </div>
                            <input type="text" class="form-control form-control-lg" id="email" name="email"
                                placeholder="Enter email address">
                        </div>
                        <div class="form-group">
                            <button id="sendOtpBtn" type="button" onclick="forgotPassword()"
                                class="btn btn-lg btn-primary btn-block">Send Email</button>
                        </div>
                        <div class="form-group text-center">
                         <a class="link link-primary" href="{{url('accountant/login')}}">Back to login</a>
                        </div>
                    </form>
                    {!! JsValidator::formRequest('App\Http\Requests\Admin\VerifyEmailRequest','#sendOtpFrm') !!}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="{{ asset('assets/js/accountant/auth/forget-password.js') }}"></script>
@endpush
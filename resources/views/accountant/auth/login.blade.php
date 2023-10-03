@extends('layouts.accountant.app')
@section('title','Login')
@section('content')
<div class="nk-content ">
    <div class="nk-block nk-block-middle nk-auth-body  wide-xs">
        <div class="brand-logo pb-4 text-center">
            <a href="index.php" class="logo-link">
                <img class="logo-img-lg" src="{{asset('assets/images/logo.png')}}" alt="taqwea">
            </a>
        </div>
        <div class="card shadow-none">
            <div class="card-inner card-inner-lg">
                <div class="nk-block-head">
                    <div class="nk-block-head-content">
                        <h4 class="nk-block-title">Sign In</h4>
                    </div>
                </div>
                <form id="accountantLoginForm" method="post" action="{{URL::TO('accountant/submitLogin')}}" novolidate>
                    {{csrf_field()}}
                    <input type="hidden" name="tz" id="tz">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="default-01">Email Address</label>
                        </div>
                        <input type="text" name="email" class="form-control form-control-lg rounded-0 shadow-none" id="default-01" placeholder="Enter email address">
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="password">Password</label>
                            <a class="link link-primary" href="{{URL::TO('accountant\forgot-password')}}">Forgot Password?</a>
                        </div>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>

                            <input type="password" name="password" class="form-control form-control-lg rounded-0" id="password" placeholder="Enter password">

                        </div>
                    </div>
                    <div class="form-group">
                        <button id="accountantLoginBtn" type="submit" class="btn btn-lg btn-primary btn-block rounded-0 shadow-none">Sign In</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\LoginRequest', '#accountantLoginForm') !!}
            </div>
        </div>
    </div>
</div>

@endsection
@push('scripts')
<script src="{{ asset('assets/js/accountant/auth/login.js') }}"></script>
@endpush
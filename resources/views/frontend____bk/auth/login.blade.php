@extends('layouts.frontend.app')
@section('title',__('labels.login'))
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
                            <p>{{ __('labels.we_have_qualified_tutors_to_teach') }} <br> {{ __('labels.make_that_subject_easy') }} </p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.book_classes') }}</h2>
                            <p>{{ __('labels.book_the_desired_class') }} <br> {{ __('labels.of_class_and_tutor_ratings') }} </p>
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
                                    <a class="nav-link" href="{{ route('show/signup') }}">{{ __('labels.sign_up') }}</a>
                                </li>
                                <li class="nav-item">
                                    <a class="nav-link active" href="javascript:void(0);">{{ __('labels.login') }}</a>
                                </li>
                            </ul>
                        </div>
                        <div class="boxContent-form position-relative">
                            <form action="" method="post" id="studentLoginForm" novolidate>
                                <input type="hidden" name="item_id" value="{{ @$_GET['item_id'] }}" />
                                <input type="hidden" name="item_type" value="{{ @$_GET['item_type'] }}" />
                                <div class="form-group">
                                    <label class="form-label">{{ __('labels.email_id') }}</label>
                                    <input name="email" type="email" class="form-control" dir="rtl" placeholder="{{ __('labels.enter_email_id') }}">
                                </div>
                                <div class="form-group form-group-icon mb-0">
                                    <label class="form-label">{{ __('labels.password') }}</label>
                                    <input name="password" type="password" class="form-control" dir="rtl" placeholder="{{ __('labels.enter_password') }}">
                                    <a href="javascript:void(0);" id="showPassword" class="icon"><span class="icon-eye"></span></a>
                                </div>
                                <div class="text-right mt-3">
                                    <a href="{{ route('frontend/forgot-password') }}" class="font-bd linkPrimary">{{ __('labels.forgot_password') }}</a>
                                </div>
                                <div class="submitBtn">
                                    <button type="submit" id="studentLoginBtn" class="btn btn-primary btn-block btn-lg ripple-effect mx-auto mw-300">{{ __('labels.login') }}</button>
                                </div>
                                <div class="orSaperator position-relative text-center">
                                    <div class="orSaperator_text d-inline-flex font-bd position-relative">{{ __('labels.or') }}</div>
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
                            {!! JsValidator::formRequest('App\Http\Requests\Auth\LoginRequest', '#studentLoginForm') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/auth/login.js')}}"></script>
@endpush

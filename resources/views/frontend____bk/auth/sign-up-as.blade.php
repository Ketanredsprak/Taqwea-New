@extends('layouts.frontend.app')
@section('title',__('labels.signup_as'))
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
                <div class="boxContent my-auto">
                    <div class="chooseSignUp text-center">
                        <div class="boxContent-head">
                            <h1 class="boxContent-head_title font-eb">{{ __('labels.signup_as') }}</h1>
                            <p>{{ __('labels.please_select_one_to_proceed') }}</p>
                        </div>
                        <form action="">
                            <div class="chooseSignUp-check">
                                <input type="radio" value="student" name="chooseType" id="student" class="d-none">
                                <label for="student" class="chooseSignUp-check_label">
                                    <span class="icon-user"></span>
                                    <div class="font-bd title">{{ __('labels.student') }}</div>
                                    <div class="check"><span class="icon-right"></span></div>
                                </label>
                            </div>
                            <div class="chooseSignUp-check">
                                <input type="radio" value="tutor" name="chooseType" id="tutor" class="d-none" checked>
                                <label for="tutor" class="chooseSignUp-check_label">
                                    <span class="icon-user"></span>
                                    <div class="font-bd title">{{ __('labels.tutor') }}</div>
                                    <div class="check"><span class="icon-right"></span></div>
                                </label>
                            </div>
                            <div class="submitBtn">
                                <button type="button" class="btn btn-primary btn-block btn-lg ripple-effect mx-auto mw-300" id="proceedBtn">{{ __('labels.proceed') }}</button>
                            </div>
                            <div class="boxContent-bottom">
                                <p class="textGray">{{ __('labels.already_had_an_account') }} <a href="{{ route('login') }}" class="linkPrimary font-bd">{{ __('labels.login') }}</a></p>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('frontend.image-cropper-modal')
@endsection
@push('scripts')
<script >
    $("#proceedBtn").click(function() {
        var userRole = $("input[name=chooseType]:checked").val();
        var url = "{{route('show/signup', ['userRole'=>'%userRole%'])}}";
        url = url.replace('%userRole%', userRole);
        window.location.href = url;
    });
</script>
@endpush
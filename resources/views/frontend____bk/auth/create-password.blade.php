@extends('layouts.frontend.app')
@section('title',__('labels.create_password'))
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
                    <div class="boxContent-inner">
                        <div class="boxContent-head text-center">
                            <h1 class="boxContent-head_title font-eb">{{ __('labels.create_password') }}</h1>
                            <p>{{ __('labels.create_password_and_then_login') }}</p>
                        </div>
                        <div class="boxContent-form position-relative">
                            <form action="{{ url('forgot-password/create-password') }}" id="createPasswordFrom" novolidate>
                                <input type="hidden" name="token" value="{{ $token }}">
                                <div class="form-group form-group-icon">
                                    <label class="form-label">{{ __('labels.password') }}</label>
                                    <input name="new_password" type="password" class="form-control" placeholder="{{ __('labels.enter_password') }}">
                                    <a href="javascript:void(0);" id="showPassword" class="icon"><span class="icon-eye"></span></a>
                                </div>
                                <div class="form-group form-group-icon">
                                    <label class="form-label">{{ __('labels.confirm_password') }}</label>
                                    <input name="confirm_password" type="password" class="form-control" placeholder="{{ __('labels.confirm_password') }}">
                                    <a href="javascript:void(0);" id="showPassword2" class="icon"><span class="icon-eye"></span></a>
                                </div>
                                <div class="submitBtn">
                                    <button class="btn btn-primary btn-block btn-lg ripple-effect mx-auto mw-300" id="createPasswordBtn">{{ __('labels.set_password') }}</button>
                                </div>
                            </form>
                            {!! JsValidator::formRequest('App\Http\Requests\Auth\CreatePasswordRequest', '#createPasswordFrom') !!}
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
<script type="text/javascript" src="{{asset('assets/js/frontend/auth/forgot-password.js')}}"></script>
@endpush
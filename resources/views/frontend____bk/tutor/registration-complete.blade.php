@extends('layouts.tutor.app')
@section('title', 'Verification Pending')
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
                            <h2 class="font-eb">{{__('labels.search_qualified_tutors')}}</h2>
                            <p>{{__('labels.we_have_qualified_tutors_to_teach')}} <br> {{__('labels.make_that_subject_easy')}}.</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{__('labels.book_classes')}}</h2>
                            <p>{{__('labels.book_the_desired_class')}} <br> {{__('labels.of_class_and_tutor_ratings')}}.</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{__('labels.payment')}}</h2>
                            <p>{{__('labels_quick_and_easy_payment')}} <br> {{__('labels.class_booking')}}.</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{__('labels.start_learning')}}</h2>
                            <p>{{__('labels.start_your_class_and_enjoy_learning')}} <br> {{__('labels.with_taqwea')}}.</p>
                        </div>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="{{ asset('assets/images/auth.png') }}" class="img-fluid" alt="auth">
                </div>
            </div>
            <div class="authPage-content_right">
                <div class="boxContent my-auto">
                    <div class="boxContent-inner boxContent--img">
                        <img src="{{ asset('assets/images/profile-verified.png') }}" class="img-fluid" alt="profile-verified">
                    </div>
                    <div class="boxContent-text text-center">
                        <h3 class="font-bd">{{__('labels.congratulations')}}</h3>
                        <p class="font-sm">{{__('labels.your_successfully_registration')}}.</p>
                        <a class="btn btn-primary ripple-effect w-100" href="{{ route('tutor/complete/profile') }}">{{__('labels.complete_your_profile')}}</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/verification-pending.js')}}"></script>
@endpush
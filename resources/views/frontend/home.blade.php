@extends('layouts.frontend.app')
@section('title',__('labels.home'))
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
@section('content')
<main class="mainContent pt-0">
    <div class="homePage">
        <section class="banner">
            <img src="{{ asset('assets/images/banner.jpg') }}" alt="banner" class="img-fluid d-none d-md-block mx-auto" />
            <div class="container-fluid">
                <div class="banner__cnt">
                    <span class="turn">{{ __('labels.turn_to_learning_LMS_Online') }}</span>
                    <h1>
                        <span> {{ __('labels.worlds') }} </span> {{ __('labels.largest') }} </br>
                        {{ __('labels.learning_platform') }}
                    </h1>
                    <p>{{ __('labels.get_unlimited_access_to_structured') }}</p>

                    <a class="btn btn-primary ripple-effect btn-tutor" href="{{route('show/signup',['role' =>'tutor'])}}">{{ __('labels.become_tutor') }}</a>
                    <a class="btn btn-secondary ripple-effect" href="{{route('show/signup')}}">{{ __('labels.start_learning') }}</a>
                    <br><br><a class="btn btn-info btn-sm ripple-effect  btn-tutor" href="{{ route('student.classrequest.create') }}">Create Class Request</a>
                </div>
            </div>
        </section>
        <section class="learningPrograms">
            <div class="container-fluid">
                <div class="learningPrograms__inner">
                    <div class="learningPrograms__top">
                        <h2>{{ __('labels.comprehensive_learning_programs_for_all_students') }}</h2>
                        <p>{{ __('labels.choose_from_online_video', ['attribute' => '130,000' ]) }}</p>
                    </div>
                    <div class="container-fluid">
                        <div class="row">
                            <div class="col-sm-6 col-lg-3 learningPrograms__box">
                                <div class="learningPrograms__boxCnt d-flex">
                                    <div class="learningPrograms__icon">
                                        <img alt="live-stream-icon" src="{{ asset('assets/images/live-streaming.svg') }}" />
                                    </div>
                                    <div class="learningPrograms__cnt">
                                        <h3>{{ __('labels.daily_live_classes') }}</h3>
                                        <p>
                                            {{ __('labels.chat_with_educators_ask_question_answer') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3 learningPrograms__box">
                                <div class="learningPrograms__boxCnt d-flex">
                                    <div class="learningPrograms__icon">
                                        <img alt="practice-icon" src="{{ asset('assets/images/practice.svg') }}" />
                                    </div>
                                    <div class="learningPrograms__cnt">
                                        <h3>{{ __('labels.practice_and_revise') }}</h3>
                                        <p>
                                            {{ __('labels.learning_is_not_just_limited') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3 learningPrograms__box">
                                <div class="learningPrograms__boxCnt d-flex">
                                    <div class="learningPrograms__icon">
                                        <img alt="learn-anytime-icon" src="{{ asset('assets/images/learn-anytime.svg') }}" />
                                    </div>
                                    <div class="learningPrograms__cnt">
                                        <h3>{{ __('labels.learn_anytime_anywhere') }}</h3>
                                        <p>
                                            {{ __('labels.one_subscription_gets_you_access') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                            <div class="col-sm-6 col-lg-3 learningPrograms__box">
                                <div class="learningPrograms__boxCnt d-flex">
                                    <div class="learningPrograms__icon">
                                        <img alt="satisfaction-icon" src="{{ asset('assets/images/satisfaction.svg') }}" />
                                    </div>
                                    <div class="learningPrograms__cnt">
                                        <h3>{{ __('labels.satisfaction_is_guaranteed') }}</h3>
                                        <p>
                                            {{ __('labels.with_the_lms_online_satisfaction_guarantee') }}
                                        </p>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </div>
            </div>
            <a href="javascript:void(0);" class="scrollDown"><em class="icon-arrow-down-long"></em></a>
        </section>

       {{-- <section class="inspiringSolutions">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-sm-7 inspiringSolutions__left">
                        <h2>
                            {{ __('labels.dream_big') }} <img src="{{ asset('assets/images/live.svg') }}" alt="live" /> </br>
                            {{ __('labels.inspiring_solutions') }}
                        </h2>
                        <p>
                            {{ __('labels.you_are_in_the_driver_seat') }} </br> {{ __('labels.experience_to_help_them') }}

                        </p>
                    </div>
                    <div class="col-sm-5 inspiringSolutions__right">
                        <img src="{{ asset('assets/images/star-badge.svg') }}" alt="reviews" />
                        <div class="reviewsCount">(281614 {{ __('labels.reviews') }})</div>
                        <p>{{ __('labels.rated') }} <span> 4.8 {{__('labels.out_of')}} 5 </span> {{ __('labels.stars') }} </br> {{ __('labels.by_our_customers') }}</p>
                        <a class="btn btn-primary ripple-effect scrollDownReview">{{ __('labels.read_reviews') }}</a>
                    </div>
                </div>
            </div>
        </section>--}}

        <section class="successwithUs sectionPad">
            <div class="container">
                <div class="heading d-flex justify-content-between align-items-end flex-wrap">
                    <div class="heading__left">
                        <h2 class="sectionHeading">{{__('labels.start_your_success_with_us')}}</h2>
                        <!-- <p class="headingPera mb-0">Classes List <span class="tag">Webinars List</span></p> -->
                    </div>
                    <div class="heading__right">
                        <a class="show-all" href="{{route('classes')}}">{{__('labels.show_all')}}</a>
                    </div>
                </div>
                <div class="common-tabs">
                    <ul class="nav nav-tabs">
                        <li class="nav-item" role="presentation">
                            <a class="nav-link classListType active" data-toggle="tab" data-type="class" href="#class">{{__('labels.classes')}}</a>
                        </li>
                        <li class="nav-item" role="presentation">
                            <a class="nav-link classListType" data-toggle="tab" data-type="webinar" href="#webinar">{{__('labels.webinars')}}</a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" role="tabpanel">
                        <div class="listSliderClass commonSlider" id="class">
                        </div>
                        <div class="row">
                            <div class="col-12" id="classNotFound" style="display:none">
                                <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                            </div>
                        </div>

                    </div>
                    <div class="tab-pane fade show active" role="tabpanel">
                        <div class="listSliderClass commonSlider" id="webinar">
                        </div>
                        <div class="row">
                            <div class="col-12" id="webinarNotFound" style="display:none">
                                <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>

        <section class="onlineSchool sectionPad">
            <div class="container">
                <div class="heading text-center">
                    <h2 class="sectionHeading">{{ __('labels.build_and_grow_your_online_school') }}</h2>
                    {{--<p class="headingPera mb-0">{{ __('labels.build_and_grow_your_online_school') }}</p>--}}
                </div>

                <div class="onlineSchool__boxes">
                    <svg class="onlineSchool__img" xmlns="http://www.w3.org/2000/svg" xmlns:xlink="http://www.w3.org/1999/xlink" viewBox="0 0 851 883">
                        <defs>
                            <style>
                                .a {
                                    fill: #fff;
                                    stroke: #ededed;
                                    stroke-dasharray: 9 5;
                                }

                                .a,
                                .d {
                                    stroke-width: 2px;
                                }

                                .b {
                                    stroke: #eecd35;
                                    opacity: 0.095;
                                    fill: url(#a);
                                }

                                .c {
                                    fill: url(#b);
                                }

                                .d,
                                .j {
                                    fill: none;
                                }

                                .d {
                                    stroke: #ffc495;
                                    opacity: 0.345;
                                }

                                .e {
                                    fill: url(#c);
                                }

                                .f {
                                    fill: #fff8d8;
                                }

                                .g {
                                    font-size: 19px;
                                    font-family: NunitoSans-SemiBold, Nunito Sans;
                                    font-weight: 600;
                                }

                                .h {
                                    font-size: 55px;
                                    font-family: NunitoSans-Black, Nunito Sans;
                                    font-weight: 800;
                                }

                                .i {
                                    stroke: none;
                                }
                            </style>
                            <radialGradient id="a" cx="0.5" cy="0.5" r="0.5" gradientTransform="translate(1) rotate(90)" gradientUnits="objectBoundingBox">
                                <stop offset="0" stop-color="#eecd35" />
                                <stop offset="0.414" stop-color="#eecd35" />
                                <stop offset="0.724" stop-color="#eecd35" />
                                <stop offset="1" stop-color="#eecd35" />
                            </radialGradient>
                            <linearGradient id="b" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox">
                                <stop offset="0" stop-color="#fff" />
                                <stop offset="0.202" stop-color="#fff" />
                                <stop offset="0.744" stop-color="#fff" stop-opacity="0.745" />
                                <stop offset="1" stop-color="#fff" stop-opacity="0" />
                            </linearGradient>
                            <linearGradient id="c" x1="0.5" x2="0.5" y2="1" gradientUnits="objectBoundingBox">
                                <stop offset="0" stop-color="#fff" />
                                <stop offset="0.202" stop-color="#fff" />
                                <stop offset="0.537" stop-color="#fff" stop-opacity="0.745" />
                                <stop offset="1" stop-color="#fff" stop-opacity="0" />
                            </linearGradient>
                        </defs>
                        <g transform="translate(-549 -848)">
                            <g class="a" transform="translate(583 981)">
                                <circle class="i" cx="375" cy="375" r="375" />
                                <circle class="j" cx="375" cy="375" r="374" />
                            </g>
                            <g transform="translate(26 5)">
                                <g transform="translate(680.306 1132.159)">
                                    <g class="b" transform="translate(-0.306 -0.159)">
                                        <circle class="i" cx="244" cy="244" r="244" />
                                        <circle class="j" cx="244" cy="244" r="243.5" />
                                    </g>
                                    <rect class="c" width="851" height="712" transform="translate(-157.306 -289.159)" />
                                    <g class="d" transform="translate(-0.306 -0.159)">
                                        <circle class="i" cx="244" cy="244" r="244" />
                                        <circle class="j" cx="244" cy="244" r="243" />
                                    </g>
                                </g>
                                <rect class="e" width="600" height="453" transform="translate(632 1082)" />
                                <circle class="f" cx="133" cy="133" r="133" transform="translate(804 1243)" /><text class="g" transform="translate(939 1396)">
                                    <tspan x="-51.927" y="19">{{ __('labels.customer') }} </tspan>
                                    <tspan x="-62.291" y="44">{{ __('labels.connection') }}</tspan>
                                </text><text class="h" transform="translate(937 1371)">
                                    <tspan x="-76.01" y="0">100%</tspan>
                                </text>
                            </g>
                        </g>
                    </svg>



                    <div class="onlineSchoolBox onlineSchoolBox--happystudent">
                        <div class="onlineSchoolBox__img">
                            <img src="{{ asset('assets/images/happy-student.jpg') }}" alt="{{ __('labels.happy_students') }}" class="img-fluid" />
                            <img src="{{ asset('assets/images/happy-student-icon.svg') }}" alt="{{ __('labels.happy_students') }}" class="img-fluid icon" />

                        </div>
                        <h3>{{ __('labels.happy_students') }}</h3>
                        {{--<p>Lorem Ipsum Dolor Sit Amet, Consetetur Sadipscing Elitr</p>--}}
                    </div>


                    <div class="onlineSchoolBox onlineSchoolBox--tutor">
                        <div class="onlineSchoolBox__img">
                            <img src="{{ asset('assets/images/world-wide-tutor.jpg') }}" alt="{{ __('labels.worldwide_tutor') }}" class="img-fluid" />
                            <img src="{{ asset('assets/images/world-wide-tutor-icon.svg') }}" alt="{{ __('labels.worldwide_tutor') }}" class="img-fluid icon" />

                        </div>
                        <h3>{{ __('labels.worldwide_tutor') }}</h3>
                        {{--<p>Lorem Ipsum Dolor Sit Amet, Consetetur Sadipscing Elitr</p>--}}
                    </div>


                    <div class="onlineSchoolBox onlineSchoolBox--livelearning">
                        <div class="onlineSchoolBox__img">
                            <img src="{{ asset('assets/images/live-learning.jpg') }}" alt="{{ __('labels.hours_of_live_learning') }}" class="img-fluid" />
                            <img src="{{ asset('assets/images/live-learning-icon.svg') }}" alt="{{ __('labels.hours_of_live_learning') }}" class="img-fluid icon" />

                        </div>
                        <h3>{{ __('labels.hours_of_live_learning') }}</h3>
                       {{-- <p>Lorem Ipsum Dolor Sit Amet, Consetetur Sadipscing Elitr</p>--}}
                    </div>


                </div>

            </div>
        </section>
        @if(!empty($tutors) && count($tutors))
        <section class="famousTeachers sectionPad">
            <div class="container">
                <div class="heading d-flex justify-content-between align-items-end flex-wrap">
                    <div class="heading__left">
                        <h2 class="sectionHeading">{{ __('labels.study_with_the_Best') }} </br>{{ __('labels.famous_teachers') }}</h2>
                        <p class="headingPera mb-0">{{ __('labels.we_bring_you_the_best_Worldwide') }}</p>
                    </div>
                    <div class="heading__right">
                        <a class="show-all" href="{{ route('tutors') }}">{{ __('labels.show_all') }}</a>
                    </div>
                </div>
                <div class="famousTeachersSlider commonSlider">
                    @forelse($tutors as $tutor)
                    <div class="famousTeachersSlider__item">
                        <div class="teacherGridBox">
                            <div class="userInfo d-flex align-items-center">
                                <div class="userInfo__img">
                                    <img src="{{ $tutor->profile_image_url }}" alt="teacher" class="img-fluid" />
                                </div>
                                <div class="userInfo__cnt">
                                    <div class="userInfo__name text-truncate">
                                        {{$tutor->translateOrDefault()->name}}
                                    </div>
                                    <!-- <a class="btn btn-circle ripple-effect" href="javascript:void(0);"><em class="icon-chat"></em></a> -->
                                    <div class="userInfo__rating">
                                        @if ($tutor->rating)
                                        <div class="userInfo__rating d-flex">
                                            <div class="rateStar w-auto" data-rating="{{$tutor->rating}}"></div>
                                        </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="teacherGridBox__middle d-flex justify-content-between">
                                <div class="classInfo">
                                    <div class="classInfo__label">
                                        {{__('labels.experience')}}
                                    </div>
                                    <div class="classInfo__cnt">
                                        {{ isset($tutor->tutor->experience) ? $tutor->tutor->experience : 0}}
                                    </div>
                                </div>
                                <div class="classInfo">
                                    <div class="classInfo__label">
                                        {{__('labels.classes')}}
                                    </div>
                                    <div class="classInfo__cnt">
                                        {{$tutor->total_classes}}
                                    </div>
                                </div>
                                <div class="classInfo">
                                    <div class="classInfo__label">
                                        {{__('labels.webinars')}}
                                    </div>
                                    <div class="classInfo__cnt">
                                        {{$tutor->total_webinars}}
                                    </div>
                                </div>
                            </div>
                            <div class="teacherGridBox__footer d-flex justify-content-between">
                                <a class="btn btn-primary btn-primary--outline ripple-effect" href="{{route('classes.schedules')}}?tutor={{ Crypt::encrypt($tutor->id) }}">{{ __('labels.view_courses') }}</a>
                                <a class="btn btn-primary ripple-effect" href="{{ route('featured.tutors.show', ['tutor' => $tutor->id]) }}">{{__('labels.view_details')}}</a>
                            </div>
                        </div>
                    </div>
                    @empty
                    <div class="row">
                        <div class="col-12">
                            <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                        </div>
                    </div>
                    @endforelse

                </div>
        </section>
        @endif


        <section class="downloadApp sectionPad">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-md-6 col-sm-6 downloadApp__left">
                        <span class="downloadApp__topTitle">{{ __('labels.android_IOS') }}</span>
                        <h2 class="downloadApp__title">
                            {{ __('labels.join_over', ['attribute' => '8 million']) }} </br>{{ __('labels.creators_around') }} </br> {{ __('labels.the_world') }}
                        </h2>
                        <p>{{ __('labels.download_our_app_now') }}</p>
                        <a href="{{getSetting('google_link')}}" target="_blank" class="google-play-btn"><img src="{{ asset('assets/images/google-play-btn.jpg') }}" alt="google-play" class="img-fluid" /></a>
                        <a href="{{getSetting('app_store_link')}}" target="_blank" class="app-play-btn"><img src="{{ asset('assets/images/app-store-btn.jpg') }}" alt="app-store" class="img-fluid" /></a>
                    </div>
                    <div class="col-md-6 col-sm-6 downloadApp__right">
                        <img src="{{ asset('assets/images/android-ios.jpg') }}" alt="android-ios" class="img-fluid" />
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12">
                        <div class="videoCall">
                            <img src="{{ asset('assets/images/video-call.jpg') }}" alt="video-call" class="img-fluid" />
                        </div>
                    </div>
                </div>
            </div>
        </section>

        @include('frontend.testimonial._show-testimonial')

    </div>
</main>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/home/home.js')}}"></script>
@endpush

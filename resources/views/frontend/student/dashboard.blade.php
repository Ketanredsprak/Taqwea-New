@extends('layouts.student.app')
@section('title',__('labels.dashboard'))
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
@section('content')

<main class="mainContent">
    <div class="dashboard dashboard--student bg-green">
        <section class="commonBanner position-relative d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="commonBanner-head">
                            <h2 class="font-bl"><span>{{__('labels.worlds')}}</span> {{__('labels.largest')}} <br> {{__('labels.learning_platform')}}</h2>
                            <p>{{__('labels.get_unlimited_access_to_structured')}}</p>
                        </div>
                    </div>
                </div>
                <div class="commonBanner-img d-none d-md-block">
                    <img src="{{ asset('assets/images/banner-img.jpg') }}" alt="banner-img">
                </div>
            </div>
        </section>
        <section class="totalList position-relative">
            <div class="container">
                <div class="totalList-content common-shadow">
                   <div class="row">
                      <div class="col-12">
                         <div class="btn-row text-center">
                            <a class="btn btn-primary ripple-effect" href="{{ route('student.classrequest.create') }}">{{ __('labels.add_class_request') }}</a>
                            <a class="btn btn-secondary ripple-effect" href="{{ route('student.classrequest.index') }}">{{ __('labels.view_class_request') }}</a>
                              {{-- <a class="btn btn-light ripple-effect" href="{{ route('tutor.blogs.create') }}">{{ __('labels.add_blog') }}</a> --}}
                         </div>
                      </div>
                   </div>
                </div>
             </div>
            </section>
        <section class="classLevel">
            <div class="container">
                <div class="commonHead">
                    <h2 class="commonHead_title font-eb">{{ __('labels.class_level') }}</h2>
                    <p class="textGray">{{__('labels.your_in_the_driver_seat')}}</p>
                </div>
                <div class="row">
                    @foreach($categories as $category)
                    <div class="col-sm-6 col-md-4 col-lg-3">
                        <div class="classLevel-item common-shadow font-bd"><a href="{{route('classes')}}?id={{$category->id}}">{{$category->translateOrDefault()->name}}</a></div>
                    </div>
                    @endforeach
                </div>
            </div>
        </section>
        <section class="classList successwithUs sectionPad bg-transparent">
            <div class="container">
                <div class="commonHead d-flex flex-wrap justify-content-between align-items-end">
                    <div class="commonHead-left">
                        <h2 class="commonHead_title font-eb">{{__('labels.recent_classes')}}</h2>
                        <p class="textGray">{{__('labels.get_unlimited_access_to_structured')}}
                        </p>
                    </div>
                    <div class="commonHead-right mt-2">
                        <a class="linkPrimary text-uppercase font-eb" href="{{ route('classes') }}">{{__('labels.show_all')}}</a>
                    </div>
                </div>
                @if(!empty($classes) && count($classes))
                <div class="listSlider commonSlider">
                    @foreach($classes as $class)
                    <div class="listSlider-item">
                        <div class="gridList">
                            <div class="gridList__img">
                                @if(isset($class->subject->subject_name))
                                <div class="subject">{{ $class->subject->translateOrDefault()->subject_name }}</div>
                                @endif

                                <img src="{{ $class->class_image_url }}" alt="list-image" class="img-fluid" />
                                <div class="info d-flex align-items-center justify-content-between">
                                    <div class="info__left">
                                        <div class="userInfo__name text-truncate">
                                            @if (isset($class->tutor->name))
                                            {{$class->tutor->translateOrDefault()->name}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="info__right">
                                        <span class="price">
                                            {{ __('labels.sar') }}
                                            <span class="font-bd">{{ (!empty($class->total_fees))?number_format($class->total_fees, 2): number_format(round(($class->duration/60)*$class->hourly_fees,2),2) }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="gridList__cnt">
                                <h4 class="gridList__title">{{ $class->translateOrDefault()->class_name }}</h4>
                                <span class="gridList__info">{{ count(@$class->bookings) }}/{{$class->no_of_attendee}} {{__('labels.students')}}</span>
                                <span class="gridList__info">{{ getDuration($class->duration) }} {{__('labels.duration')}}</span>
                            </div>

                            <div class="gridList__footer d-flex justify-content-between">
                                <div class="gridList__footer__left" dir="{{config('constants.date_format_direction')}}">
                                    <div class="date">{{ convertDateToTz($class->start_time, 'UTC', 'd M Y') }} </div>
                                    <div class="time">{{ convertDateToTz($class->start_time, 'UTC', 'h:i A') }}</div>
                                </div>

                                <div class="gridList__footer__left">
                                    <a class="btn btn-primary ripple-effect" href="{{route('classes/show', ['class' => $class->slug])}}">{{__('labels.view_details')}}</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                    </div>
                </div>
                @endif
            </div>
        </section>

        <section class="famousTeachers sectionPad">
            <div class="container">
                <div class="heading d-flex justify-content-between align-items-end flex-wrap">
                    <div class="heading__left">
                        <h2 class="sectionHeading">{{__('labels.study_with_the_Best')}} </br>{{__('labels.famous_teachers')}}</h2>
                        <p class="headingPera mb-0">{{__('labels.we_bring_you_the_best_Worldwide')}}</p>
                    </div>
                    <div class="heading__right">
                        <a class="show-all" href="{{ route('tutors') }}">{{__('labels.show_all')}}</a>
                    </div>
                </div>
                @if(!empty($tutors) && count($tutors))
                <div class="famousTeachersSlider commonSlider">
                    @foreach($tutors as $tutor)
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
                    @endforeach
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                    </div>
                </div>
                @endif
        </section>

        <section class="webinarList successwithUs sectionPad bg-transparent">
            <div class="container">
                <div class="commonHead d-flex flex-wrap justify-content-between align-items-end">
                    <div class="commonHead-left">
                        <h2 class="commonHead_title font-eb">{{__('labels.webinars')}}</h2>
                        <p class="textGray">{{__('labels.get_unlimited_access_to_structured')}}
                        </p>
                    </div>
                    <div class="commonHead-right mt-2">
                        <a class="linkPrimary text-uppercase font-eb" href="{{ route('webinars') }}">{{__('labels.show_all')}}</a>
                    </div>
                </div>
                @if(!empty($webinars) && count($webinars))
                <div class="listSlider commonSlider">
                    @foreach($webinars as $webinar)
                    <div class="listSlider-item">
                        <div class="gridList">
                            <div class="gridList__img">
                                @if(isset($webinar->subject->subject_name))
                                <div class="subject">{{ $webinar->subject->translateOrDefault()->subject_name }}</div>
                                @endif
                                <img src="{{ $webinar->class_image_url }}" alt="list-image" class="img-fluid" />
                                <div class="info d-flex align-items-center justify-content-between">
                                    <div class="info__left">
                                        <div class="userInfo__name text-truncate">
                                            @if (isset($webinar->tutor->name))
                                            {{$webinar->tutor->translateOrDefault()->name}}
                                            @endif
                                        </div>
                                    </div>
                                    <div class="info__right">
                                        <span class="price">
                                            {{ __('labels.sar') }}
                                            <span class="font-bd">{{ (!empty($webinar->total_fees))?$webinar->total_fees:$webinar->hourly_fees.'/'.__('labels.hour') }}</span>
                                        </span>
                                    </div>
                                </div>
                            </div>

                            <div class="gridList__cnt">
                                <h4 class="gridList__title">{{ $webinar->translateOrDefault()->class_name }}</h4>
                                <span class="gridList__info">{{ count(@$webinar->bookings) }}/{{$webinar->no_of_attendee}} {{__('labels.students')}}</span>
                                <span class="gridList__info">{{ getDuration($webinar->duration) }} {{__('labels.duration')}}</span>
                            </div>

                            <div class="gridList__footer d-flex justify-content-between">
                                <div class="gridList__footer__left" dir="{{config('constants.date_format_direction')}}">
                                    <div class="date">{{ convertDateToTz($webinar->start_time, 'UTC', 'd M Y') }} </div>
                                    <div class="time">{{ convertDateToTz($webinar->start_time, 'UTC', 'h:i A') }}</div>
                                </div>

                                <div class="gridList__footer__left">
                                    <a class="btn btn-primary ripple-effect" href="{{route('webinars/show', ['class' => $webinar->slug])}}">{{__('labels.view_details')}}</a>
                                </div>
                            </div>

                        </div>
                    </div>
                    @endforeach
                </div>
                @else
                <div class="row">
                    <div class="col-12">
                        <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                    </div>
                </div>
                @endif
            </div>
        </section>
    </div>
</main>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/dashboard.js')}}"></script>
@endpush

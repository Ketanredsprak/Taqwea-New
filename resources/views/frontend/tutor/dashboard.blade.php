@extends('layouts.tutor.app')
@section('title',__('labels.dashboard'))
@section('content')
<main class="mainContent">
    <div class="dashboard dashboard--Tutor bg-green">
        <section class="commonBanner position-relative d-flex align-items-center">
            <div class="container">
                <div class="row">
                    <div class="col-md-6">
                        <div class="commonBanner-head">
                            <h2 class="font-bl"><span>{{ __('labels.worlds') }}</span> {{ __('labels.largest') }} <br> {{ __('labels.learning_platform') }}</h2>
                            <p> {{ __('labels.get_unlimited_access_to_structured') }}</p>
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
                  <div class="col-6 col-xl-2">
                     <div class="totalList-content_box text-center">
                        <img src="{{ asset('assets/images/total-classes.svg') }}" alt="{{ __('labels.total_classes') }}">
                        <div class="detail">
                           <span class="sub-title">{{ __('labels.total_classes') }}</span>
                           <h5>{{$counts['class_count'] ?? 0}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-6 col-xl-2">
                     <div class="totalList-content_box text-center">
                        <img src="{{ asset('assets/images/total-webinar.svg') }}" alt="{{ __('labels.total_webinars') }}">
                        <div class="detail">
                           <span class="sub-title">{{ __('labels.total_webinars') }}</span>
                           <h5>{{$counts['webinar_count'] ?? 0}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-6 col-xl-2">
                     <div class="totalList-content_box text-center">
                        <img src="{{ asset('assets/images/total-blogs.svg') }}" alt="{{ __('labels.total_blogs') }}">
                        <div class="detail">
                            <span class="sub-title">{{ __('labels.total_blogs') }}</span>
                            <h5>{{$counts['blog_count'] ?? 0}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-6 col-xl-2">
                     <div class="totalList-content_box text-center">
                        <img src="{{ asset('assets/images/total-student.svg') }}" alt="{{ __('labels.total_students') }}">
                        <div class="detail">
                           <span class="sub-title">{{ __('labels.total_students') }}</span>
                           <h5>{{$counts['students'] ?? 0}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-6 col-xl-2">
                     <div class="totalList-content_box text-center">
                        <img src="{{ asset('assets/images/total-due.svg') }}" alt="{{ __('labels.total_dues') }}">
                        <div class="detail">
                        <span class="sub-title">{{ __('labels.total_dues') }}</span>
                        <h5><span class="font-rg">SAR</span> {{ number_format($counts['dues'], 2) ?? 0}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-6 col-xl-2">
                     <div class="totalList-content_box text-center">
                        <img src="{{ asset('assets/images/total-earning.svg') }}" alt="{{ __('labels.total_earning') }}">
                        <div class="detail">
                           <span class="sub-title">{{ __('labels.total_earning') }}</span>
                           <h5><span class="font-rg">SAR</span> {{ number_format($counts['earnings'], 2) ?? 0}}</h5>
                        </div>
                     </div>
                  </div>
                  <div class="col-12">
                     <div class="btn-row text-center">
                        <a class="btn btn-primary ripple-effect" href="{{ route('tutor.classes.create') }}">{{ __('labels.add_class') }}</a>
                        <a class="btn btn-secondary ripple-effect" href="{{ route('tutor.webinars.create') }}">{{ __('labels.add_webinar') }}</a>
                        <a class="btn btn-light ripple-effect" href="{{ route('tutor.blogs.create') }}">{{ __('labels.add_blog') }}</a>
                        <a class="btn btn-dark ripple-effect" href="{{ route('tutor.classrequest.index') }}">{{ __('labels.view_class_request') }}</a>
                     </div>
                  </div>
               </div>
            </div>
         </div>
        </section>
        <section class="classList successwithUs sectionPad bg-transparent">
            <div class="container">
                <div class="commonHead d-flex flex-wrap justify-content-between align-items-end">
                    <div class="commonHead-left">
                        <h2 class="commonHead_title font-eb">{{ __('labels.today_classes_list') }}</h2>
                        <p class="textGray">{{ __('labels.your_in_the_driver_seat') }}
                        </p>
                    </div>
                    <div class="commonHead-right mt-2">
                        <a class="linkPrimary text-uppercase font-eb" href="{{ route('tutor.classes.index') }}">{{ __('labels.show_all') }}</a>
                    </div>
                </div>
                @if(!empty($classes) && count($classes))
                <div class="listSlider commonSlider">
                    @foreach($classes as $class)
                    <div class="listSlider-item">
                        <div class="gridList">
                            <div class="gridList__img">
                            @if(@$class->subject->subject_name)
                            <div class="subject"> {{ $class->subject->translateOrDefault()->subject_name }}</div>
                            @endif
                                <img src="{{ $class->class_image_url }}" class="img-fluid" />
                                <div class="info d-flex align-items-center justify-content-between">
                                    <div class="info__left">
                                        <div class="userInfo__name text-truncate">
                                            {{$class->tutor->translateOrDefault()->name ?? ''}}
                                        </div>
                                    </div>
                                    <div class="info__right">
                                        <span class="price">{{ __('labels.sar') }}  <span class="font-bd">{{ (!empty($class->total_fees))?number_format($class->total_fees, 2): number_format(round(($class->duration/60)*$class->hourly_fees,2),2) }}</span></span>
                                    </div>
                                </div>
                            </div>

                            <div class="gridList__cnt">
                                <h4 class="gridList__title">{{ $class->translateOrDefault()->class_name }}</h4>
                                <span class="gridList__info">{{ @$class->bookings_count }}/5 {{__('labels.students')}}</span>
                                <span class="gridList__info">{{ getDuration($class->duration) }} {{__('labels.duration')}}</span>
                            </div>

                            <div class="gridList__footer d-flex justify-content-between">
                                <div class="gridList__footer__left" dir="{{config('constants.date_format_direction')}}">
                                    <div class="date">{{ convertDateToTz($class->start_time, 'UTC', 'd M Y') }}</div>
                                    <div class="time">{{ convertDateToTz($class->start_time, 'UTC', 'h:i A') }}</div>
                                </div>
                                <div class="gridList__footer__left">
                                    <a class="btn btn-primary ripple-effect" href="{{route('tutor.classes.detail', ['slug' => $class->slug])}}">{{__('labels.view_details')}}</a>
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

        <section class="webinarList successwithUs sectionPad bg-transparent">
            <div class="container">
                <div class="commonHead d-flex flex-wrap justify-content-between align-items-end">
                    <div class="commonHead-left">
                        <h2 class="commonHead_title font-eb">{{ __('labels.today_webinars_list') }}</h2>
                        <p class="textGray">{{ __('labels.your_in_the_driver_seat') }}
                        </p>
                    </div>
                    <div class="commonHead-right mt-2">
                        <a class="linkPrimary text-uppercase font-eb" href="{{ route('tutor.webinars.index') }}">{{ __('labels.show_all') }}</a>
                    </div>
                </div>
                @if(!empty($webinars) && count($webinars))
                <div class="listSlider commonSlider">
                    @foreach($webinars as $webinar)
                    <div class="listSlider-item">
                        <div class="gridList">
                            <div class="gridList__img">
                                @if(@$webinar->subject->subject_name)
                                <div class="subject"> {{ $webinar->subject->translateOrDefault()->subject_name }}</div>
                                @endif
                                <img src="{{ $webinar->class_image_url }}" class="img-fluid" />
                                <div class="info d-flex align-items-center justify-content-between">
                                    <div class="info__left">
                                        <div class="userInfo__name text-truncate">
                                            {{$webinar->tutor->translateOrDefault()->name ?? ''}}
                                        </div>
                                    </div>
                                    <div class="info__right">
                                        <span class="price">{{ __('labels.sar') }}  <span class="font-bd">{{ (!empty($webinar->total_fees))?number_format($webinar->total_fees, 2): number_format(round(($webinar->duration/60)*$webinar->hourly_fees,2),2) }}</span></span>
                                    </div>
                                </div>
                            </div>

                            <div class="gridList__cnt">
                                <h4 class="gridList__title">{{$webinar->translateOrDefault()->class_name}}</h4>
                                <span class="gridList__info">{{ count(@$webinar->bookings) }}/5 {{__('labels.students')}}</span>
                                <span class="gridList__info">{{ getDuration($webinar->duration) }} {{__('labels.duration')}}</span>
                            </div>

                            <div class="gridList__footer d-flex justify-content-between">
                                <div class="gridList__footer__left" dir="{{config('constants.date_format_direction')}}">
                                    <div class="date">{{ convertDateToTz($webinar->start_time, 'UTC', 'd M Y') }}</div>
                                    <div class="time">{{ convertDateToTz($webinar->start_time, 'UTC', 'h:i A') }}</div>
                                </div>
                                <div class="gridList__footer__left">
                                    <a class="btn btn-primary ripple-effect" href="{{route('tutor.webinars.detail', ['slug' => $webinar->slug])}}">{{__('labels.view_details')}}</a>
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
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/dashboard.js')}}"></script>
@endpush

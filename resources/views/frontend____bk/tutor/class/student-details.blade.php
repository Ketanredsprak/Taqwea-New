@extends('layouts.tutor.app')
@section('title', __('labels.student_detail'))
@section('content')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
<main class="mainContent">
    <div class="detailPage detailPage--studentDetail commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('labels.home')}} </a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('labels.student_detail')}}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{__('labels.student_detail')}}</h3>
            </div>
        </section>
        <section class="detailPageCnt">
            <div class="detailPageCnt__inner">
                <div class="subject">
                    <div class="container">
                        <div class="row">
                            <div class="col-lg-8">
                                <div class="subject__ratings commonBox">
                                    <h5 class="h-24">{{__('labels.reviews')}}</h5>
                                    <div class="ratingCommentBox" nice-scroll>
                                        @forelse($studentRating as $rating)
                                        <div class="ratingCommentBox__box">
                                            <div class="d-flex align-items-center">
                                                <div class="userInfo">
                                                    <div class="userInfo__img">
                                                        <img src="{{$rating->from->profile_image_url}}" alt="Lindsay Marsh">
                                                    </div>
                                                </div>
                                                <div class="userView">
                                                    <div class="d-flex justify-content-between flex-wrap">
                                                        <div class="userView__cnt">
                                                            <h6 class="font-bd text-truncate">{{$rating->from->name}}</h6>
                                                            <div class="d-flex">
                                                                <div class="rateStar w-auto" data-rating="{{$rating->rating}}"></div>
                                                            </div>
                                                        </div>
                                                        <div class="userView__ratingSec">
                                                            <p class="font-sm" dir="{{config('constants.date_format_direction')}}">{{convertDateToTz($rating->created_at ,'','d M Y')}}</p>

                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="ratingCommentBox__content">
                                                <h6 class="font-bd">{{$rating->class->class_name}}</h6>
                                                <p> {{$rating->review}} </p>
                                            </div>
                                        </div>
                                        @empty
                                        <div class="">
                                            <div class="alert alert-danger mb-0">{{ __('labels.record_not_found') }}</div>
                                        </div>
                                        @endforelse
                                    </div>
                                </div>
                            </div>
                            @if(!empty($userDetails))
                            <div class="col-lg-4">
                                <div class="subject__right commonBox">
                                    <div class="tutorInfo">
                                        <div class="tutorInfo__img">
                                            <img src="{{$userDetails->profile_image_url}}" alt="Marcia Sachs">
                                        </div>
                                        <div class="tutorInfo__name">
                                            {{$userDetails->name}}
                                        </div>
                                        <div class="tutorInfo__ratingSec d-flex align-items-center justify-content-center">
                                            <div class="rateStar w-auto" data-rating="{{getAverageRating($userDetails->id)}}"></div>
                                        </div>
                                        <div class="tutorInfo__text">
                                            <p class="font-rg mb-0">
                                            </p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>

@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/rating.js')}}"></script>
@endpush
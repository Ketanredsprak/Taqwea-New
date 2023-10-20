@extends('layouts.tutor.app')
@section('title', __('labels.student_list'))
@section('content')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
<main class="mainContent">
    <div class="studentListPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{__('labels.home')}}</a></li>
                            <li class="breadcrumb-item">@if(@$bookings[0]->class->class_type == 'class')
                                <a href="{{ route('tutor.classes.index') }}">{{ __('labels.my_classes') }}</a>
                                @else
                                <a href="{{ route('tutor.webinars.index') }}">{{ __('labels.my_webinars') }}</a>
                                @endif
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{__('labels.student_list')}}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{__('labels.student_list')}}</h3>
            </div>
        </section>
        <div class="container">
            <div class="listingBox common-shadow">
                <div class="common-table" nice-scroll>
                    <div class="table-responsive">
                        <table class="table">
                                @foreach($bookings as $student)
                                <tr>
                                    <td>
                                        <div class="userInfo d-flex align-items-center">
                                            <div class="userInfo_img">
                                                <img src="{{$student->student->profile_image_url}}" class="rounded-circle" alt="user-image">
                                            </div>
                                            <div class="userInfo_detail">
                                                <h5 class="userInfo_name">{{$student->student->name}}</h5>
                                                <div class="userInfo_rating d-flex align-items-center ">
                                                    <div class="rateStar w-auto" data-rating="{{ getAverageRating($student->student->id)}}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="text-right"><a href="{{route('tutor.student.details', ['id' => $student->student->id])}}" class="linkPrimary font-bd">{{__('labels.view_details')}}</a></td>
                                </tr>
                                @endforeach
                        </table>
                    </div>
                </div>
            </div>
        </div>
        {{ $bookings->links() }}
    </div>
</main>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/rating.js')}}"></script>
@endpush
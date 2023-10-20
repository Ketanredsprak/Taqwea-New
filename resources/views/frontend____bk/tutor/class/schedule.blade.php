@extends('layouts.tutor.app')
@section('title',  __('labels.tutor_schedule'))
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.css">
@endpush
@section('content')
<main class="mainContent">
    <div class="schedulePage bg-green">
       
        <section class="pageTitle">
                <div class="container">
                <div class="d-sm-flex align-items-center justify-content-between">
                        <div class="pageTitle__leftSide">
                            <div class="commonBreadcrumb">
                                <nav aria-label="breadcrumb">
                                    <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('labels.home')}}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{$schedule}}</li>
                                    </ol>
                                </nav>
                            </div>
                            <h3 class="h-32 pageTitle__title">{{$schedule}}</h3>
                        </div>
                        <div class="pageTitle__rideSide">
                            <div class="boxContent-nav text-center mb-0">
                                <ul class="nav nav-pills d-inline-flex">
                                    <li class="nav-item">
                                        <a class="nav-link active calendar-event" href="#" data-calender-type='georgian'>{{__('labels.georgian')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link calendar-event" href="#" data-calender-type='hijri'>{{__('labels.hijri')}}</a>
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
               
            </section>
        @include('frontend.class.calendar')
        
        <input type="hidden" value="{{$class_type}}" id="classType">
        <div class="column-2" id="classList">
    </div>
</main>
@endsection
@push('scripts')
<script>
    var tutor = "";
    var availableDates = @json($availableDate);
    var locale = "{{config('app.locale')}}";
</script>
    <script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.3.1/main.min.js"></script>
    <script type="text/javascript" src="{{asset('assets/js/frontend/calendar.js')}}"></script>
    <script type="text/javascript" src="{{asset('assets/js/frontend/schedule.js')}}"></script>
@endpush

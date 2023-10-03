@php
if(Auth::check() && Auth::user()->isTutor()){
$layout = 'layouts.tutor.app';
}elseif(Auth::check() && Auth::user()->isStudent()){
$layout = 'layouts.student.app';
}
@endphp
@extends($layout)
@section('title', $title)
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
@section('content')
<main class="mainContent">
    <div class="myRatingsPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{$title}}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{$title}}</h3>
            </div>
        </section>
        <section class="myRatingsPage__inner">
            <div class="container">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
                </div>
                <div class="flexRow d-xl-flex">
                    <div class="column-1">
                        @if(Auth::check() && Auth::user()->isTutor())
                        @include('layouts.tutor.side-bar')
                        @elseif(Auth::check() && Auth::user()->isStudent())
                        @include('layouts.student.side-bar')
                        @endif

                    </div>
                    <div class="column-2">
                        <div class="myRatingsPage__list subject common-shadow bg-white p-30">
                            <div class="common-tabs mb-3 mb-lg-4">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link ratingListType active" data-type="received" data-toggle="tab" href="#received">{{__('labels.received')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link ratingListType" data-toggle="tab" data-type="given" href="#given">{{__('labels.given')}}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="received" role="tabpanel">

                                </div>
                                <div class="tab-pane fade" id="given" role="tabpanel">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
@push('scripts')
@if(Auth::check() && Auth::user()->isTutor())
<script>
    var ratingUrl = "{{ route('tutor.rating.list') }}";
</script>
@elseif(Auth::check() && Auth::user()->isStudent())
<script>
    var ratingUrl = "{{ route('student.rating.list') }}";
</script>
@endif
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/rating.js')}}"></script>
@endpush
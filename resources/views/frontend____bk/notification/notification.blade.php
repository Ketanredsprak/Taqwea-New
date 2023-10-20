@php
if(Auth::check() && Auth::user()->isTutor()){
$layout = 'layouts.tutor.app';
}elseif(Auth::check() && Auth::user()->isStudent()){
$layout = 'layouts.student.app';
}
@endphp

@extends($layout)
@section('title', __('labels.notification'))
@section('content')
<main class="mainContent">
    <div class="notificationPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.notification')}}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.notification')}}</h3>
            </div>
        </section>
        <section class="notificationInner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12 col-lg-10 offset-lg-1">
                        @if($data->count())
                        @foreach($data as $notification)
                        <div class="infoItem d-flex align-items-center">
                            <div class="infoItem__img">
                                <img src="{{ asset('assets/images/notification-thumbnail.jpg') }}" alt="notification" class="img-fluid" />
                            </div>
                            <div class="infoItem__cnt" dir="{{config('constants.date_format_direction')}}">
                                <p class="mb-0">{{$notification->notification_message}}</p>
                                <span class="time">{{convertDateToTz($notification->created_at, 'UTC', 'd M Y h:i A')  }}</span>
                            </div>
                        </div>
                        @endforeach
                        @else
                        <div class="alert alert-icon alert-danger" role="alert">
                            <em class="icon ni ni-alert-circle"></em>
                            <strong>{{ __('labels.notification_not_found')}}</strong>
                        </div>
                        <!-- .nk-notification -->
                        @endif
                    </div>
                    <div class="custom-pagination d-flex align-items-center justify-content-between">
                        {{ $data->links() }}
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
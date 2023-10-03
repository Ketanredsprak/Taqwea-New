@extends('layouts.admin.app')
@section('title','Notification')
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Notifications</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Notifications</h3>
                        </div><!-- .nk-block-head-content -->

                    </div><!-- .nk-block-between -->
                </div>
                <div class="card card-full notification-page">
                    @if($notifications && $notifications->count())
                    <div class="notification-wrap">
                        @foreach($notifications as $notification)
                        <div class="notification-item">
                            <p>{{$notification->notification_message}}</p>
                            <span>{{ convertDateToTz($notification->created_at)}}</span>
                        </div>
                        @endforeach
                    </div>
                    @else
                    <div class="alert alert-icon alert-danger" role="alert">
                        <em class="icon ni ni-alert-circle"></em>
                        <strong>No Notifications found!</strong>
                    </div>
                    @endif
                </div>
                <div class="custom-pagination d-flex align-items-center justify-content-between">
                    {{ $notifications->links() }}
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
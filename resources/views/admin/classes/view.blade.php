@extends('layouts.admin.app')
@section('title','Class Detail')
@section('content')
<div class="nk-content viewPage">
    <div class="container-xl wide-lg">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm pageHead">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ ($class->class_type == 'webinar') ? url('admin/webinars') : route('classes.index')}}">{{ ($class->class_type == 'webinar') ? 'Webinar' : 'Class'}}</a></li>
                                    <li class="breadcrumb-item active">{{ ($class->class_type == 'webinar') ? 'Webinar Details' : 'Class Details'}} </li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">{{ ($class->class_type == 'webinar') ? 'Webinar Details' : 'Class Details'}}</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{ ($class->class_type == 'webinar') ? url('admin/webinars') : route('classes.index')}}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-between -->
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="card-content">
                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#otherInfo" role="tab" aria-controls="otherInfo" aria-selected="false">
                                            <span>{{ ($class->class_type == 'webinar') ? 'Webinar Details' : 'Class Details'}}</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#studentList" role="tab" aria-controls="studentList" aria-selected="false">
                                            <span>Student List</span>
                                        </a>
                                    </li>
                                    <li class="nav-item nav-item-trigger d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                    </li>
                                </ul><!-- .nav-tabs -->
                                <div class="tab-content mt-0" id="pills-tabContent">
                                    <div class="tab-pane mt-0 fade active show" id="otherInfo" role="tabpanel" aria-labelledby="otherInfo">
                                        <div class="card-inner">
                                            <div class="nk-block">
                                                <div class="profile-ud-list">
                                                    {{-- <div class="profile-ud-item w-100 mb-3">
                                                        <span class="sub-text">Class Name</span>
                                                        <p>{{$class->class_name}}</p>
                                                </div> --}}

                                                <div class="profile-ud-item w-100">
                                                    <span class="sub-text">Description</span>
                                                    <p>{!! $class->class_description !!}</p>
                                                </div>
                                            </div><!-- .profile-ud-list -->
                                        </div><!-- .nk-block -->
                                    </div>
                                </div>

                                <div class="tab-pane mt-0 fade" id="studentList" role="tabpanel" aria-labelledby="studentList">
                                    <div class="card-inner p-0 common-table">
                                        <table class="datatable-init table">
                                            <thead>
                                                <tr>
                                                    <th class="w_70 nosort">ID</th>
                                                    <th>Student Name</th>
                                                    <th>Date of Registration</th>
                                                    <th>Amount Paid</th>
                                                    <th class="nosort text-center w_100 actions">Action</th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                @forelse ($class->bookings as $booking)
                                                <tr>
                                                    <td>{{$loop->iteration}}</td>
                                                    <td>
                                                        <div class="user-card">
                                                            <div class="user-avatar">
                                                                <img src="{{$booking->student->profile_image_url}}" alt="">
                                                            </div>
                                                            <div class="user-info">
                                                                <span class="tb-lead">{{$booking->student->name}}</span>
                                                                <span class="d-block">{{$booking->student->email}}</span>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>{{convertDateToTz($booking->student->created_at,'UTC','m/d/Y')}}</td>
                                                    <td>{{$booking->transactionItem->total_amount}}</td>
                                                    <td>
                                                        <a href="{{route('admin.bookings-class', ['id' => $booking->id])}}" class="btn btn-primary btn-sm"><em class="icon ni ni-eye"></em> <span>View</span></a>
                                                    </td>
                                                </tr>
                                                @empty

                                                @endforelse
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>

                        </div><!-- .card-content -->
                        <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-right toggle-break-lg" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                            <div class="card-inner-group" data-simplebar>
                                <div class="card-inner">
                                    <div class="user-card user-card-s2">
                                        <div class="user-avatar lg bg-primary">
                                            <img src="{{$class->tutor->profile_image_url}}" alt="tutor's Profile Image">
                                        </div>
                                        <div class="user-info">
                                            <!--  <div class="badge badge-outline-light badge-pill ucap">
                                                    Pediatrician</div> -->
                                            <h5>{{$class->tutor->name}}</h5>
                                            <span class="sub-text">{{$class->tutor->email}}</span>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                                <div class="card-inner">

                                    <div class="row g-3">
                                        <div class="col-6">
                                            <span class="sub-text">Class Name:</span>
                                            <span>{{$class->class_name}}
                                            </span>
                                        </div>
                                        @if ($class->class_type == "class")
                                        <div class="col-6">
                                            <span class="sub-text">Class Capacity:</span>
                                            <span>{{$class->no_of_attendee}}
                                            </span>
                                        </div>
                                        @endif
                                        <div class="col-6">
                                            <span class="sub-text">Duration:</span>
                                            <span>{{convertMinutesToHours($class->duration)}} Hours</span>
                                        </div>
                                        
                                        <div class="col-6">
                                            <span class="sub-text">Date & Time:</span>
                                            <span>{{ convertDateToTz($class->start_time, 'UTC', 'm/d/Y h:i A') }}</span>
                                        </div>
                                       

                                        <div class="col-6">
                                            <span class="sub-text">Status:</span>
                                            <span class="{{($class->status == 'active') ? 'text-success' : 'text-danger'}}">{{ucwords($class->status)}}</span>
                                        </div>
                                    </div>
                                </div><!-- .card-inner -->
                            </div><!-- .card-inner -->
                        </div><!-- .card-aside -->
                    </div><!-- .card-aside-wrap -->
                </div><!-- .card -->
            </div><!-- .nk-block -->
        </div>
    </div>
</div>
</div>
@endsection
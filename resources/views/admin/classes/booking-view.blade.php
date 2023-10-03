@extends('layouts.admin.app')
@section('title','Class Booking Detail')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
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
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item"><a href="{{( $class->class_type == 'class' ? route('admin.booking.class'): route('admin.booking.webinar') )}}">{{($class->class_type == 'class')? 'Booked Class Details':' Booked Webinar Details'}}</a></li>
                                    <li class="breadcrumb-item active">{{($class->class->class_type == 'class')? 'Booked Class Details':' Booked Webinar Details'}}</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">{{($class->class->class_type == 'class')? 'Booked Class Details':' Booked Webinar Details'}}</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{route('admin.booking.class')}}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                            </div>
                        </div>
                    </div>
                    <!-- .nk-block-between -->
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="card-content">
                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#otherInfo" role="tab" aria-controls="otherInfo" aria-selected="false">
                                            <span>{{($class->class->class_type == 'class')? 'Class Details':'Webinar Details'}}</span>
                                        </a>
                                    </li>
                                  
                                    <li class="nav-item nav-item-trigger d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                    </li>
                                </ul>
                                <!-- .nav-tabs -->
                                <div class="tab-content mt-0" id="pills-tabContent">
                                    <div class="tab-pane mt-0 fade active show" id="otherInfo" role="tabpanel" aria-labelledby="otherInfo">
                                        <div class="card-inner">
                                            <div class="nk-block">
                                                <div class="profile-ud-list">
                                                    <div class="profile-ud-item w-100 mb-3">
                                                        <div class="detailImg">
                                                            <img src="{{$class->class->class_image_url}}" class="img-fluid" alt="blog" />
                                                        </div>
                                                    </div>
                                                    <div class="profile-ud-item w-100 mb-3">
                                                        <span class="sub-text">Class Name</span>
                                                        <p>{{$class->class->class_name }}</p>
                                                    </div>

                                                    <div class="profile-ud-item w-100 mb-3">
                                                        <span class="sub-text">Class Description</span>
                                                        <p>{!! $class->class->class_description !!}</p>
                                                    </div>
                                                    <div class="profile-ud-item w-100">
                                                        <span class="sub-text">Topics</span>
                                                        <div id="faqs" class="accordion customAccordion">
                                                            @foreach($class->class->topics as $topic)
                                                            <div class="accordion-item">
                                                                <div class="accordion-head w-100 text-left">
                                                                    <h6 class="title" data-toggle="collapse" data-target="#faq-q{{$topic->id}}">{{$topic->topic_title}}</h6>
                                                                    <div class="action d-flex align-items-center">
                                                                        <buttton class="accordion-icon" data-toggle="collapse" data-target="#faq-q{{$topic->id}}" title="View Answer"></buttton>
                                                                    </div>
                                                                </div>
                                                                <div class="accordion-body collapse {{$topic->id == 1 ? 'show': ''}}" id="faq-q{{$topic->id}}" data-parent="#faqs">
                                                                    <div class="accordion-inner">
                                                                        <p>
                                                                            {{$topic->topic_description}}
                                                                        </p>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @endforeach
                                                        </div>
                                                        <!-- .accordion -->
                                                    </div>
                                                </div>
                                                <!-- .profile-ud-list -->
                                            </div>
                                            <!-- .nk-block -->
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <!-- .card-content -->
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-right toggle-break-lg" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner">
                                        <div class="user-card user-card-s2">
                                            <div class="user-avatar lg bg-primary">
                                                <img src="{{$class->student->profile_image_url}}" alt="Doctor's Profile Image" />
                                            </div>
                                            <div class="user-info">
                                                <h5>{{$class->student->name}}</h5>
                                                <span class="sub-text">{{$class->student->email}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .card-inner -->
                                    <div class="card-inner">
                                        <div class="row g-3">
                                            
                                            <div class="col-12">
                                                <span class="sub-text">Booking date & Time:</span>
                                                <span>{{convertDateToTz($class->created_at, 'UTC', 'm/d/Y h:i A')}}</span>
                                            </div>

                                            <div class="col-6">
                                                <span class="sub-text">Amount paid</span>
                                                <span>{{config('app.currency.default')}} <span>{{$class->transactionItem->total_amount}}</span> </span>
                                            </div>
                                           
                                            <div class="col-6">
                                                <span class="sub-text">Status:</span>
                                                <span class="{{($class->status == 'cancel') ? 'text-danger': 'text-success'}}">{{ucwords($class->status)}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- .card-inner -->
                                </div>
                                <!-- .card-inner -->
                            </div>
                            <!-- .card-aside -->
                        </div>
                        <!-- .card-aside-wrap -->
                    </div>
                    <!-- .card -->
                </div>
                <!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
@endsection

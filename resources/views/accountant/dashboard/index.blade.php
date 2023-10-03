@extends('layouts.accountant.app')
@section('title','DashBoard')
@section('content')
<div class="nk-content dashboardPage">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <h3 class="nk-block-title page-title">Dashboard</h3>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div><!-- .nk-block-head -->
                <div class="infoCard">
                    <!-- row -->
                    <div class="row row-sm">
                        <div class="col-lg-3 col-sm-6">
                            <div class="card overflow-hidden sales-card">
                                <div class="card__body">
                                    <h6 class="mb-3 ">Total Tutors</h6>
                                    <div class="d-flex justify-content-between card__body__content">
                                        <div class="left">
                                            <h4 class="mb-1">{{$usersOverAll['tutor_count']}}</h4>
                                            <p class="">All Time</p>
                                        </div>
                                        <div class="left">
                                            <h4 class="mb-1">{{$usersThisMonth['tutor_count']}}</h4>
                                            <p class="">Current Month</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card overflow-hidden sales-card">
                                <div class="card__body">
                                    <h6 class="mb-3 ">Total Students</h6>
                                    <div class="d-flex justify-content-between card__body__content">
                                        <div class="left">
                                            <h4 class="mb-1">{{$usersOverAll['student_count']}}</h4>
                                            <p class="">All Time</p>
                                        </div>
                                        <div class="left">
                                            <h4 class="mb-1">{{$usersThisMonth['student_count']}}</h4>
                                            <p class="">Current Month</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card overflow-hidden sales-card">
                                <div class="card__body">
                                    <h6 class="mb-3 ">Total Classes</h6>
                                    <div class="d-flex justify-content-between card__body__content">
                                        <div class="left">
                                            <h4 class="mb-1">{{$classOverAll ? $classOverAll['class_count'] : 0}}</h4>
                                            <p class="">All Time</p>
                                        </div>
                                        <div class="left">
                                            <h4 class="mb-1">{{$classThisMonth ? $classThisMonth['class_count'] : 0}}</h4>
                                            <p class="">Current Month</p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-lg-3 col-sm-6">
                            <div class="card overflow-hidden sales-card">
                                <div class="card__body">
                                    <h6 class="mb-3 ">Total Webinars</h6>
                                    <div class="d-flex justify-content-between card__body__content">
                                        <div class="left">
                                            <h4 class="mb-1">{{$classOverAll ? $classOverAll['webinar_count'] : 0}}</h4>
                                            <p class="">All Time</p>
                                        </div>
                                        <div class="left">
                                            <h4 class="mb-1">{{$classThisMonth ? $classThisMonth['webinar_count'] : 0}}</h4>
                                            <p class="">Current Month</p>
                                        </div>
                                    </div>
                                </div>

                            </div>
                        </div>
                    </div>
                    <!-- row closed -->
                </div>

                <!--Total Earning/Revenue-->
                <div class="revenueGraph">
                    <div class="card border-0">
                        <div class="card-header bg-transparent">
                            <div class="d-flex justify-content-between">
                                <h4 class="card-title mb-0">Total Earning/Revenue</h4>
                                <div class="card-tools">
                                    <div class="drodown">
                                        <a href="javascript:void(0);" class="dropdown-toggle dropdown-indicator btn btn-sm btn-outline-light btn-white" data-toggle="dropdown">Filter</a>
                                        <div class="dropdown-menu dropdown-menu-right dropdown-menu-xs">
                                            @php
                                            $current_year = date("Y");
                                            $previous_year = $current_year - 1;
                                            $after_previous_year =$previous_year-1;
                                            @endphp
                                            <ul class="link-list-opt no-bdr">
                                                <li><a href="javascript:void(0);" onclick="getDashboardCount({{$current_year}})" id="{{$current_year}}" class='filter'><span>{{$current_year}}</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="getDashboardCount({{$previous_year}})" id="{{$previous_year}}" class='filter'><span>{{$previous_year}}</span></a></li>
                                                <li><a href="javascript:void(0);" onclick="getDashboardCount({{$after_previous_year}})" id="{{$after_previous_year}}" class='filter'><span>{{$after_previous_year}}</span></a></li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div id="bar" class="revenue-bar mt-4"></div>
                        </div>
                    </div>
                </div>
                <!---->
                <div class="row g-gs">
                    <div class="col-xxl-6">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Recent Tutor</h6>
                                    </div>
                                    <a href="{{URL::To('accountant\tutors')}}" class="theme-color">View All</a>
                                </div>
                            </div>
                            <div class="common-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Type of Subscription</th>
                                            <th>Total Earning</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentTutors as $tutor)
                                        <tr>
                                            <td>{{$tutor->id}}</td>
                                            <td>
                                                <a href="tutor-detail.php">
                                                    <div class="user-card">
                                                        <div class="user-avatar">

                                                            <img src="{{$tutor->tutor->profile_image_url}}" alt="">

                                                        </div>
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$tutor->tutor->name}}</span>
                                                            <span class="d-block">{{$tutor->tutor->email}}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>{{$tutor->subscription->subscription_name}}</td>
                                            <td>{{ __('labels.sar') }} {{$tutor->transaction->amount}}</td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                    </div>
                    <div class="col-xxl-6">
                        <div class="card card-full">
                            <div class="card-inner">
                                <div class="card-title-group">
                                    <div class="card-title">
                                        <h6 class="title">Recent Students Refund Request</h6>
                                    </div>
                                    <a href="{{route('refund-request.index')}}" class="theme-color">View All</a>
                                </div>
                            </div>
                            <div class="common-table table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>S.No.</th>
                                            <th>Name</th>
                                            <th>Class Name</th>
                                            <th>Date of Registration</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($recentStudents as $student)
                                        <tr>
                                            <td>{{$student->id}}</td>
                                            <td>
                                                <a href="#studentDetails" data-toggle="modal">
                                                    <div class="user-card">
                                                        <div class="user-avatar">

                                                            <img src="{{$student->student->profile_image_url}}" alt="">

                                                        </div>
                                                        <div class="user-info">
                                                            <span class="tb-lead">{{$student->student->name}}</span>
                                                            <span class="d-block">{{$student->student->email}}</span>
                                                        </div>
                                                    </div>
                                                </a>
                                            </td>
                                            <td>{{$student->class->class_name}}</td>
                                            <td>{{$student->created_at}}</td>
                                        </tr>
                                        @empty

                                        @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div><!-- .card -->
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery-sparklines/2.1.2/jquery.sparkline.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/apexcharts/2.4.0/apexcharts.min.js"></script>
<script src="{{asset('assets/js/accountant/dashboard/dashboard.js')}}"></script>
@endpush
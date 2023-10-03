@extends('layouts.admin.app')
@section('title','Webinar')
@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm pageHead">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Webinar</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Webinar</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                               <!--  <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a> -->
                                <div data-content="pageMenu">
                                    <ul class="btn-toolbar gx-sm-1 justify-content-end">
                                        <li>
                                            <div class="dropdown">
                                                <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                    <div class="dot"></div>
                                                    <em class="icon ni ni-filter-alt"></em>
                                                </a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right filterDropdown">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Class Level</label>                                                                
                                                                    <select id="level" class="form-select form-select-sm" data-placeholder="Class Level" >
                                                                        <option></option>
                                                                        @foreach ($levels as $level)
                                                                            <option value="{{$level->id}}">{{$level->name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Grade</label>                                                                
                                                                    <select id="grade" class="form-select form-select-sm" data-placeholder="Grade" >
                                                                        <option></option>
                                                                        @foreach ($grades as $grade)
                                                                            <option value="{{$grade->id}}">{{$grade->grade_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Subjects</label>                                                                
                                                                    <select id="subject" class="form-select form-select-sm" multiple data-placeholder="Subjects" >
                                                                        @foreach ($subjects as $subject)
                                                                            <option value="{{$subject->id}}">{{$subject->subject_name}}</option>
                                                                        @endforeach
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">From Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-right">
                                                                            <em class="icon ni ni-calendar-alt"></em>
                                                                        </div>
                                                                        <input type="text" id="start_time" class="form-control date-picker-from rounded-0 shadow-none" placeholder="From Date" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">To Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-right">
                                                                            <em class="icon ni ni-calendar-alt"></em>
                                                                        </div>
                                                                        <input type="text" id="end_time" class="form-control date-picker-to rounded-0 shadow-none" placeholder="To Date" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Rating</label>
                                                                    <select id="rating" class="form-select form-select-sm" data-placeholder="Rating" >
                                                                        <option></option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    </select>
                                                                   
                                                                </div>
                                                            </div>
                                                            <div class="col-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select id="status" class="form-select form-select-sm" data-placeholder="Status" >
                                                                        <option></option>
                                                                        <option value="active">Active</option>
                                                                        <option value="inactive">Inactive</option>
                                                                        <option value="completed">Completed</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                           
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot">
                                                        <a class="reset-filter" href="#">Reset Filter</a>
                                                        <button id="webinar-filter" type="button" class="btn btn-primary">Filter</button>
                                                    </div>
                                                </div><!-- .filter-wg -->
                                            </div><!-- .dropdown -->
                                        </li>
                                    </ul><!-- .btn-toolbar -->
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-block-between -->
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="w-100">
                                <div class="card-inner p-0 common-table">
                                    <table id="webinar-table" class="table">
                                        <thead>
                                            <tr>
                                                <th class="w_70 id">ID</th>
                                                <th class="class_name">Class Name</th>
                                                <th class="category">Category</th>
                                                <th class="subject">Subject</th>
                                                <th class="class_duration">Duration</th>
                                                <th class="class_time">Date & Time </th>
                                                <th class="tutor_name">Tutor Name</th>
                                                <th class="rating">Rating</th>
                                                <th class="status">Status</th>
                                                <th class="w_100 actions">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody>

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/admin/classes/webinar.js')}}"></script>
@endpush
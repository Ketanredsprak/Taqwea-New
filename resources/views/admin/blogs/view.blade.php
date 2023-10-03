@extends('layouts.admin.app')
@section('title','Blog Detail')
@section('content')
<div class="nk-content ">
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
                                    <li class="breadcrumb-item"><a href="{{route('blogs.index')}}">Blog</a></li>
                                    <li class="breadcrumb-item active">Blog Details</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Blog Details</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{route('blogs.index')}}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
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
                                            <span>Blogs Details</span>
                                        </a>
                                    </li>
                                    <!-- <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#studentList" role="tab" aria-controls="studentList" aria-selected="false">
                                            <span>Student List</span>
                                        </a>
                                    </li> -->
                                    <li class="nav-item nav-item-trigger d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                    </li>
                                </ul><!-- .nav-tabs -->
                                <div class="tab-content mt-0" id="pills-tabContent">
                                    <div class="tab-pane mt-0 fade active show" id="otherInfo" role="tabpanel" aria-labelledby="otherInfo">
                                        <div class="card-inner">
                                            <div class="nk-block">
                                                <div class="profile-ud-list">
                                                     <div class="profile-ud-item w-100 mb-3">
                                                        <span class="sub-text">Blog Title</span>
                                                        <p>{{$blog->blog_title}}</p>
                                                    </div>

                                                    <div class="profile-ud-item w-100">
                                                        <span class="sub-text">Blog Description</span>
                                                        <p>{!! $blog->blog_description !!}</p>
                                                    </div>
                                                    <div class="classImg downloadFileCustom profile-ud-item position-relative d-inline-block">

                                                        @if($blog->media_url != url('assets/images/default-user.jpg'))
                                                            <a class="btn btn-primary download mb-3" data-id="{{$blog->id}}" href="{{route('admin.blog.download',['id'=>$blog->id])}}"> <em class="icon ni ni-download"></em> </a>
                                                            <img src="{{ $blog->media_thumb_url }}" class="img-fluid class-img" />
                                                        @endif
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
                                                    </tr>
                                                </thead>
                                                <tbody>

                                                    <tr>
                                                        <td></td>
                                                        <td>
                                                            <div class="user-card">
                                                                <div class="user-avatar">
                                                                    <img src="" alt="">
                                                                </div>
                                                                <div class="user-info">
                                                                    <span class="tb-lead"></span>
                                                                    <span class="d-block"></span>
                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td></td>
                                                        <td>-</td>
                                                    </tr>



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
                                                <img src="{{$blog->tutor->profile_image_url}}" alt="tutor's Profile Image">
                                            </div>
                                            <div class="user-info">
                                                <!--  <div class="badge badge-outline-light badge-pill ucap">
                                                    Pediatrician</div> -->
                                                <h5>{{$blog->tutor->name}}</h5>
                                                <span class="sub-text">{{$blog->tutor->email}}</span>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">

                                        <div class="row g-3">
                                            <div class="col-6">
                                                <span class="sub-text">Category:</span>
                                                <span>{{(isset($blog->category->name) ? $blog->category->name:'')}}
                                                </span>
                                            </div>

                                            <div class="col-6">
                                                <span class="sub-text">Class Level:</span>
                                                <span>{{$blog->level->name}}
                                                </span>
                                            </div>

                                            <div class="col-6">
                                                <span class="sub-text">Subject :</span>
                                                <span>{{ isset($blog->subject->subject_name) ? $blog->subject->subject_name : ''}}</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="sub-text">Content Type:</span>
                                                <span>{{isset($blog->type) ? $blog->type : ''}}
                                                </span>
                                            </div>

                                            <div class="col-6">
                                                <span class="sub-text">published Date & Time:</span>
                                                <span>{{convertDateToTz($blog->created_at, 'UTC', 'm/d/Y h:i A')}}
                                                </span>
                                            </div>

                                            <div class="col-6">
                                                <span class="sub-text">Status:</span>
                                                <span class="{{($blog->status == 'active') ? 'text-success' : 'text-danger'}}">{{ucwords($blog->status)}}</span>
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

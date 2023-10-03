@extends('layouts.admin.app')
@section('title','Edit-Tutor')
@section('content')
<div class="nk-content nk-content-fluid">
    <div class="container-xl wide-lg">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item">
                                        <a href="{{route('adminDashboard')}}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item">
                                        <a href="{{URL::TO('admin\tutors')}}">Tutor Management</a>
                                    </li>
                                    <li class="breadcrumb-item active">Edit Tutor</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Edit Tutor</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{URL::TO('admin\tutors')}}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-between -->
                </div>
                <div class="card card-full">
                    <div class="card-inner">
                        <div class="tab-content" id="myTabContent">
                            <div class="nk-wizard-content">
                                <form id="tutor_edit_form" method="PUT" action="{{route('tutors.update', $user->id)}}" enctype="multipart/form-data">
                                    <div class="row gy-3">
                                        <input type="hidden" id="id" name="{{$user->id}}">
                                        <div class="col-sm-12">
                                            <div class="upload_photo mb-2 mb-md-3 mx-auto text-center">
                                                <div class="img-box">
                                                    <img src="{{$user->profile_image_url}}" alt="Tutor-Profile" class="img-fluid" id="imagePreview">
                                                </div>
                                                <label class="mb-0 ripple-effect" for="uploadImage">
                                                    <input type="file" id="uploadImage" onchange="setImage(this,$(this),'profile_image');" data-width-height="{{ config('constants.profile_image.dimension') }}" data-max-size="{{ config('constants.profile_image.maxSize') }}" data-accept-file="{{ config('constants.profile_image.acceptType') }}" data-preview-id="imagePreview" data-base64-id="uploadImageBase64" accept="{{ config('constants.profile_image.acceptType') }}">
                                                    <input type="hidden" name="profile_image" id="uploadImageBase64" value="">
                                                    <em class="icon ni ni-pen2"></em>
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Name</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" placeholder="Name" name="name" value="{{$user->name}}" data-msg="Required" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Email Address</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" placeholder="Email Address" name="email" value="{{$user->email}}" class="form-control rounded-0 shadow-none">
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Gender</label>
                                                <div class="form-control-wrap">
                                                    {{ucfirst($user->gender)}}
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Phone Number</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" placeholder="Phone Number" name="phone_number" value="{{$user->phone_number}}" class="form-control rounded-0 shadow-none">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Date of Registration</label>
                                                <div class="form-control-wrap">
                                                    <div class="form-icon form-icon-right">
                                                        <em class="icon ni ni-calendar-alt"></em>
                                                    </div>
                                                    <input type="text" name="date" value="{{$user->created_at->format('m/d/Y')}}" class="form-control date-picker rounded-0 shadow-none" placeholder="Date of Registration" disabled>
                                                </div>
                                            </div>
                                        </div><!-- .col -->
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">About Me</label>
                                                <div class="form-control-wrap">
                                                    <textarea placeholder="About Me" name="bio" class="form-control rounded-0 shadow-none">{{$user->bio}}</textarea>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-row mt-3 text-center">
                                        <button type="submit" id="tutor_edit_btn" class="btn btn-primary shadow-none width-120 ripple-effect mr-2">Update</button>
                                    </div>
                                </form>

                                {!! JsValidator::formRequest('App\Http\Requests\Admin\TutorEditFormRequest','#tutor_edit_form') !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- content @e -->
@include('frontend.image-cropper-modal')
@endsection
@push('scripts')
<script src="{{asset('assets/js/admin/tutors/index.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/image-cropper.js')}}"></script>
@endpush
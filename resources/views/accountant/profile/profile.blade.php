@extends('layouts.accountant.app')
@section('title','Profile')
@section('content')
<div class="nk-content">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="tab-content w-100">
                                <div class="tab-pane active" id="tabItem1">
                                    <div class="card-inner card-inner-lg">
                                        <div class="nk-block-head nk-block-head-lg">
                                            <div class="nk-block-between">
                                                <div class="nk-block-head-content">
                                                    <h4 class="nk-block-title">Profile</h4>
                                                </div>
                                                <div class="nk-block-head-content align-self-start d-lg-none">
                                                    <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head -->
                                        <div class="nk-block">
                                            <div class="nk-data data-list">
                                                <div class="data-item" data-toggle="modal" data-target="#profile-edit">
                                                    <div class="data-col">
                                                        <span class="data-label">Name</span>
                                                        <span class="data-value">{{$accountant->name}}</span>
                                                    </div>
                                                    <div class="data-col data-col-end"><span class="data-more disable"><em class="icon ni ni-forward-ios"></em></span></div>
                                                </div><!-- data-item -->
                                                <div class="data-item">
                                                    <div class="data-col">
                                                        <span class="data-label">Email</span>
                                                        <span class="data-value">{{$accountant->email}}</span>
                                                    </div>
                                                    <div class="data-col data-col-end"><span class="data-more"><em class="icon ni ni-lock-alt"></em></span></div>

                                                </div><!-- data-item -->
                                            </div><!-- data-list -->
                                        </div><!-- .nk-block -->
                                    </div>
                                </div>
                                <div class="tab-pane" id="tabItem2">
                                    <div class="card-inner card-inner-lg">
                                        <div class="nk-block-head nk-block-head-lg">
                                            <div class="nk-block-between">
                                                <div class="nk-block-head-content">
                                                    <h4 class="nk-block-title">Change Password</h4>
                                                </div>
                                                <div class="nk-block-head-content align-self-start d-lg-none">
                                                    <a href="#" class="toggle btn btn-icon btn-trigger mt-n1" data-target="userAside"><em class="icon ni ni-menu-alt-r"></em></a>
                                                </div>
                                            </div>
                                        </div><!-- .nk-block-head -->
                                        <div class="nk-block">
                                            <div class="card">
                                                <div class="card-inner-group">
                                                    <div class="card-inner">
                                                        <div class="between-center flex-wrap g-3">
                                                            <div class="nk-block-text">
                                                                <h6>Change Password</h6>
                                                                <p>Set a unique password to protect your account.</p>
                                                            </div>
                                                            <div class="nk-block-actions flex-shrink-sm-0">
                                                                <ul class="align-center flex-wrap flex-sm-nowrap gx-3 gy-2">
                                                                    <li class="order-md-last">
                                                                        <a href="#" data-toggle="modal" data-target="#changePassword" class="btn btn-primary">Change Password</a>
                                                                    </li>
                                                                    <li>
                                                                        <em class="text-soft text-date fs-12px">Last changed: <span>{{($accountant->updated_at)}}</span></em>
                                                                    </li>
                                                                </ul>
                                                            </div>
                                                        </div>
                                                    </div><!-- .card-inner -->
                                                </div><!-- .card-inner-group -->
                                            </div><!-- .card -->
                                        </div><!-- .nk-block -->
                                    </div>
                                </div>
                            </div>
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-left toggle-break-lg" data-content="userAside" data-toggle-screen="lg" data-toggle-overlay="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner">
                                        <div class="user-card">
                                            <div class="user-avatar bg-primary">
                                                <img src="{{ Auth::guard('web')->user()->profile_image_url }}" alt="user-img" class="img-fluid">
                                            </div>
                                            <div class="user-info">
                                                <span class="lead-text">{{$accountant->userTranslation['name']}}</span>
                                                <span class="sub-text">{{$accountant->email}}</span>
                                            </div>
                                            <div class="user-action">
                                                <div class="dropdown">
                                                    <a class="btn btn-icon btn-trigger mr-n2" data-toggle="dropdown" href="#"><em class="icon ni ni-more-v"></em></a>
                                                    <div class="dropdown-menu dropdown-menu-right">
                                                        <ul class="link-list-opt no-bdr">
                                                            <li>
                                                                <a href="#" id="photoUpload" class="photoUpload">
                                                                    <em class="icon ni ni-camera-fill"></em>
                                                                    <form id="avatar-form" enctype="multipart/form-data" method="POST">
                                                                        @csrf
                                                                        <span>Change Profile Image</span>
                                                                        <input type="file" name="profile_image" id="avatar">
                                                                    </form>
                                                                </a>
                                                            </li>
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div><!-- .user-card -->
                                    </div><!-- .card-inner -->
                                    <div class="card-inner p-0">
                                        <ul class="link-list-menu nav m-0">
                                            <li><a class="active" data-toggle="tab" href="#tabItem1"><em class="icon ni ni-user-fill-c"></em><span>Profile</span></a></li>
                                            <li><a data-toggle="tab" href="#tabItem2"><em class="icon ni ni-lock-alt-fill"></em><span>Change Password</span></a></li>
                                        </ul>
                                    </div><!-- .card-inner -->
                                </div><!-- .card-inner-group -->
                            </div>
                            <!-- card-aside -->
                        </div><!-- .card-aside-wrap -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>
<!-- @@ Profile Edit Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="profile-edit">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title text-center mb-3">Update Profile</h5>
                <form id="profile-update-frm">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="form-label" for="full-name">Name</label>
                        <input type="email" class="form-control form-control-lg" id="full-name" value="{{$accountant->name}}" name="name" placeholder="Name">
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" data-dismiss="modal" class="btn btn-light width-120 ripple-effect mr-2">Cancel</button>
                        <button id="submit-btn" type="button" class="btn btn-primary width-120 ripple-effect">Update</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateAdminProfileRequest','#profile-update-frm') !!}
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->
<!-- @@ Change Password Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="changePassword">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title text-center mb-3">Change Password</h5>
                <form id="change-password-form" action="{{URL::TO('accountant/changePassword')}}" method="POST">
                    {{csrf_field()}}
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="currentPassword">Current Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="currentPassword">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" maxlength="32" name="current_password" class="form-control form-control-lg" id="currentPassword" placeholder="Enter current  password">
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="newPassword">New Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="newPassword">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" maxlength="32" name="new_password" class="form-control form-control-lg" id="newPassword" placeholder="Enter new password">
                        </div>
                    </div>
                    <div class="form-group passwordInfo">
                        <h6>Password Contains:</h6>
                        <p class="done"><em class="icon ni ni-check"></em> A capital letter & a small letter.</p>
                        <p class="done"><em class="icon ni ni-check"></em> A special character & a number.</p>
                        <p><em class="icon ni ni-check"></em> 8-32 characters long.</p>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="confirmPassword">Confirm New Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="confirmPassword">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" maxlength="32" name="confirm_password" class="form-control form-control-lg" id="confirmPassword" placeholder="Confirm new password">
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" data-dismiss="modal" class="btn btn-light width-120 ripple-effect mr-2">Cancel</button>
                        <button type="button" id="change-password-btn" class="btn btn-primary width-120 ripple-effect">Update</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\ChangePasswordRequest','#change-password-form') !!}
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div><!-- .modal -->

@endsection
@push('scripts')
<script src="{{asset('assets/js/accountant/profile/profile.js')}}"></script>
@endpush
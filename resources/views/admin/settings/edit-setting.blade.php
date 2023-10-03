@extends('layouts.admin.app')
@section('title','Settings')
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
                                        <a href="{{Route('adminDashboard')}}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">Manage Setting</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Manage Setting</h3>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div>
                <div class="card card-full">
                    <div class="card-inner">
                        <div class="tab-content" id="myTabContent">
                            <div class="nk-wizard-content">
                                <form action="{{URL::TO('admin\setting-post')}}" method="post" id="edit-setting-form">
                                    {{csrf_field()}}
                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Google Play</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" placeholder="Google Play " name="google_link" data-msg="Required" value="{{getSetting('google_link')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">App Store</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" name="app_store_link" placeholder="App Store" data-msg="Required" value="{{getSetting('app_store_link')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">FaceBook</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" name="facebook_link" placeholder="Face Book" data-msg="Required" value="{{getSetting('facebook_link')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Twitter</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" name="twitter_link" placeholder="twitter" data-msg="Required" value="{{getSetting('twitter_link')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">YouTube</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" name="youtube_link" placeholder="You Tube" data-msg="Required" value="{{getSetting('youtube_link')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Instagram</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" name="instagram_link" placeholder="Instagram" data-msg="Required" value="{{getSetting('instagram_link')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Phone Number</label>
                                                <div class="form-control-wrap">
                                                    <input type="text" name="phone_number" placeholder="Phone Number" data-msg="Required" value="{{getSetting('phone_number')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-row mt-3 text-center">
                                        <button type="button" id="submit-btn" class="btn btn-primary shadow-none width-120 ripple-effect mr-2">Update</button>
                                    </div>
                                </form>
                                {!! JsValidator::formRequest('App\Http\Requests\Admin\EditSettingRequest','#edit-setting-form') !!}
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
<script src="{{asset('assets/js/admin/settings/edit-setting.js')}}"></script>
@endpush
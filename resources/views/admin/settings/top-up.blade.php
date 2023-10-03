@extends('layouts.admin.app')
@section('title','Top Up')
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
                                    <li class="breadcrumb-item active">Top Up</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Top Up</h3>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div>
                <div class="card card-full">
                    <div class="card-inner">
                        <div class="tab-content" id="myTabContent">
                            <div class="nk-wizard-content">
                                <form action="{{URL::TO('admin\top-up')}}" method="post" id="top-up-frm">
                                    {{csrf_field()}}
                                    <div class="row gy-3">
                                        <input type="hidden" id="id" name='id' value="{{$data->id}}">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Class Per Hours Price</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" placeholder="Class Per/Hour Price" name="class_per_hours_price" value="{{$data->class_per_hours_price}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Webinar Per Hours Price</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" name="webinar_per_hours_price" placeholder="Class Per/Hour Price" value="{{$data->webinar_per_hours_price}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Blog Per Price</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" name="blog_per_hours_price" placeholder="Class Per/Hour Price" value="{{$data->blog_per_hours_price}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Is Featured per day Price</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" name="is_featured_price" placeholder="Enter is featured price" value="{{$data->is_featured_price}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-row mt-3 text-center">
                                        <button type="button" id="submit-button" class="btn btn-primary shadow-none width-120 ripple-effect mr-2">Update</button>
                                    </div>
                                </form>
                                {!! JsValidator::formRequest('App\Http\Requests\Admin\TopUpRequest','#top-up-frm') !!}
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
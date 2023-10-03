@extends('layouts.admin.app')
@section('title','Manage Commission')
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
                                    <li class="breadcrumb-item active">Manage Commission</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Manage Commission</h3>
                        </div><!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div>
                <div class="card card-full">
                    <div class="card-inner">
                        <div class="tab-content" id="myTabContent">
                            <div class="nk-wizard-content">
                                <form action="{{URL::TO('admin\commission-post')}}" method="post" id="commission-form">
                                    {{csrf_field()}}
                                    <div class="row gy-3">
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">VAT(%)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" max="100" step=".25" placeholder="VAT" name="vat" data-msg="Required" value="{{getSetting('vat')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="form-label">Admin Fee(%)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" max="100" step=".25" name="transaction_fee" placeholder="Transaction Fee" data-msg="Required" value="{{getSetting('transaction_fee')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-6" style="display:none">
                                            <div class="form-group">
                                                <label class="form-label">Commission(%)</label>
                                                <div class="form-control-wrap">
                                                    <input type="number" max="100" step=".25" name="commission" placeholder="Commission" data-msg="Required" value="{{getSetting('commission')}}" class="form-control rounded-0 shadow-none required">
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="btn-row mt-3 text-center">
                                        <button type="button" id="submit-btn" class="btn btn-primary shadow-none width-120 ripple-effect mr-2">Update</button>
                                    </div>
                                </form>
                                {!! JsValidator::formRequest('App\Http\Requests\Admin\CommissionRequest','#commission-form') !!}
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
<script src="{{asset('assets/js/admin/commission/index.js')}}"></script>
@endpush
@extends('layouts.accountant.app')
@section('title','Revenue Report')
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
                                    <li class="breadcrumb-item"><a href="{{route('accountantDashboard')}}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Revenue Report</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Revenue Report</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <form action="{{route('revenue.accountant.export')}}" method="POST">
                                        @csrf
                                        <ul class="btn-toolbar gx-sm-1 justify-content-end">
                                            <li>
                                                <div class="dropdown">
                                                    <a href="#" class="btn btn-trigger btn-icon dropdown-toggle" data-toggle="dropdown">
                                                        <div class="dot dot-success"></div>
                                                        <em class="icon ni ni-filter-alt"></em>
                                                    </a>
                                                    <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right filterDropdown">
                                                        <div class="dropdown-head">
                                                            <span class="sub-title dropdown-title">Filter</span>
                                                        </div>
                                                        <div class="dropdown-body dropdown-body-rg">
                                                            <div class="row gx-6 gy-3">
                                                                <div class="col-sm-12">
                                                                    @php
                                                                    $current_year = date("Y");
                                                                    $previous_year = $current_year + 1;
                                                                    @endphp
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt"> Year</label>
                                                                        <select class="form-select form-select-sm " data-placeholder="Select Year" name="year" id="year">
                                                                            <option></option>
                                                                            <option value="{{$current_year}}">{{$current_year}}</option>
                                                                            <option value="{{$previous_year}}">{{$previous_year}}</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-foot">
                                                            <a onclick="reset()" href="javascript:void(0);">Reset Filter</a>
                                                            <button type="button" id="revenue-report-filter" class="btn btn-primary">Filter</button>
                                                        </div>
                                                    </div><!-- .filter-wg -->
                                                </div><!-- .dropdown -->
                                            </li>
                                            <li>
                                                <button type="submit" class="btn btn-primary"><span>Export CSV</span></button>
                                            </li>
                                        </ul><!-- .btn-toolbar -->
                                    </form>
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
                                    <table class="datatable-init table" id="revenue-report-datatable">
                                        <thead>
                                            <tr>
                                                <th class="w_70 nosort no">S.No.</th>
                                                <th class="month">Month</th>
                                                <th class="subscription">Subscriptions Revenue</th>
                                                <th class="classes">Classes Revenue</th>
                                                <th class="webinars">Webinars Revenue</th>
                                                <th class="blogs">Blog Revenue</th>
                                                <th class="fine">Fine</th>
                                                <th class="points">Points Redeemed Value</th>
                                                <th class="total">Total Revenue</th>
                                            </tr>
                                        </thead>
                                        <tfoot>
                                            <tr>
                                                <th colspan="8" style="text-align:right">Total</th>
                                                <th></th>
                                            </tr>
                                        </tfoot>
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
<script src="{{asset('assets/js/accountant/reports/revenue-report.js')}}"></script>
@endpush
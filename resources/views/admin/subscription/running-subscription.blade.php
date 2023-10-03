@extends('layouts.admin.app')
@section('title','Running Subscription')
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
                                    <li class="breadcrumb-item active">Running Subscriptions</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Running Subscriptions</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
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

                                                            <!-- <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Type of Subscription</label>
                                                                    <select class="form-select form-select-sm " name="type_of_subscription" id="type_of_subscription" data-placeholder="Select Subscription">
                                                                        <option></option>
                                                                        <option value="Featured">Featured Profile</option>
                                                                        <option value="Webinar">Webinar</option>
                                                                    </select>

                                                                </div>
                                                            </div> -->
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">From Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-right">
                                                                            <em class="icon ni ni-calendar-alt"></em>
                                                                        </div>
                                                                        <input type="text" name="from_date" id="from_date" class="form-control date-picker-from rounded-0 shadow-none" placeholder="From Date">
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
                                                                        <input type="text" name="to_date" id="to_date" class="form-control date-picker-to rounded-0 shadow-none" placeholder="To Date">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot">
                                                        <a class="reset-filter" href="javascript:void(0)">Reset Filter</a>
                                                        <button type="button" class="btn btn-primary" id="subscription-filter">Filter</button>
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
                                    <table class="datatable-init table" id="running-subscription-datatable">
                                        <thead>
                                            <tr>
                                                <th class="w_70  id">ID</th>
                                                <th class="subscription_name">Subscription Name</th>
                                                <th class="date">Date of Purchase</th>
                                                <th class="subscription_details">Subscription Description</th>
                                                <th class="tutor_name">Tutor Name</th>
                                                <th class="amount">Amount Paid</th>
                                                <th class="expiry_days">Time Left in Subscription Completion</th>
                                                <th class="end_date">Expiry Date</th>
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
<script src="{{asset('assets/js/admin/subscription/running-subscription.js')}}"></script>
@endpush
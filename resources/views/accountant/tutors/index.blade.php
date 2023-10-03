@extends('layouts.accountant.app')
@section('title','Tutor')
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
                                    <li class="breadcrumb-item active">Tutor Payout</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Tutor Payout</h3>
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
                                                    <div class="dot"></div>
                                                    <em class="icon ni ni-filter-alt"></em>
                                                </a>
                                                <div class="filter-wg dropdown-menu dropdown-menu-xl dropdown-menu-right filterDropdown">
                                                    <div class="dropdown-head">
                                                        <span class="sub-title dropdown-title">Filter</span>
                                                    </div>
                                                    <div class="dropdown-body dropdown-body-rg">
                                                        <div class="row gx-6 gy-3">
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select class="form-select form-select-sm " data-placeholder="Select Status" id="status">
                                                                        <option></option>
                                                                        <option value="active">Active</option>
                                                                        <option value="inactive">Inactive</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Gender</label>
                                                                    <select class="form-select form-select-sm " data-placeholder="Select Gender" id="gender">
                                                                        <option></option>
                                                                        <option value="male">Male</option>
                                                                        <option value="female">Female</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">From Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-right">
                                                                            <em class="icon ni ni-calendar-alt"></em>
                                                                        </div>
                                                                        <input type="text" class="form-control date-picker-from rounded-0 shadow-none" id="from_date" placeholder="From Date">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">To Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-right">
                                                                            <em class="icon ni ni-calendar-alt"></em>
                                                                        </div>
                                                                        <input type="text" class="form-control date-picker-to rounded-0 shadow-none" id="to_date" placeholder="To Date">
                                                                    </div>
                                                                </div>
                                                            </div>

                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot">
                                                        <a onclick="reset()" href="javascript:void(0);">Reset Filter</a>
                                                        <button type="button" id="tutor-filter" class="btn btn-primary">Filter</button>
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
                                    <table class="datatable-init table" id="tutor-datatable">
                                        <thead>
                                        <tr>
                                                <th class="w_70 no">ID</th>
                                                <th class="name">Name</th>
                                                <th class="phone_number">Phone Number</th>
                                                <th class="type_subscription">Type Of Subscription</th>
                                                <th class="total_classes">Total Classes</th>
                                                <th class="total_webinars">Total Webinars</th>
                                                <th class="total_blogs">Total Blogs</th>
                                                <th class="total_sale">Total Sale</th>
                                                <th class="total_admin_commission">admin Commission</th>
                                                <th class="total_earnings">Total Earnings</th>
                                                <th class="total_paid_tutor">Paid To Tutor</th>
                                                <th class="total_due">Total Due</th>
                                                <th class="total_points">Total Points</th>
                                                <th class="nosort text-center w_100 actions">Action</th>
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

<div class="modal fade" id="tutor-account-details" tabindex="-1" data-backdrop="static">
</div>

<div class="modal fade" id="tutor-manage-points" tabindex="-1" data-backdrop="static">
</div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/accountant/tutors/index.js')}}"></script>
@endpush

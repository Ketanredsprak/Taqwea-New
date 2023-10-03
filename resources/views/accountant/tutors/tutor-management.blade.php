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
                                    <li class="breadcrumb-item active">Tutors Management</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Tutors Management</h3>
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
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Type of Subscription</label>
                                                                    <select class="form-select form-select-sm" id="type_of_subscription" data-placeholder="Select Subscription">
                                                                        <option></option>
                                                                        <option value="Featured">Featured</option>
                                                                        <option value="Webinar">Webinar</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Payment Status</label>
                                                                    <select class="form-select form-select-sm" id="payment_status" data-placeholder="Payment Status">
                                                                        <option></option>
                                                                        <option value="paid">Paid</option>
                                                                        <option value="Unpaid">Unpaid</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot">
                                                        <a class="clickable" href="#">Reset Filter</a>
                                                        <button type="button" class="btn btn-primary">Filter</button>
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
                                                <th class="w_70 nosort id">S.No.</th>
                                                <th class="name">Name</th>
                                                <th class="type_of_subscription">Type of Subscription</th>
                                                <th class="total_class/completed">Total Classes Posted/Completed</th>
                                                <th class="verification_status">Verification Status</th>
                                                <th class="total_earning">Total Earning</th>
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
@endsection
@push('scripts')
<script src="{{asset('assets/js/accountant/tutors/index.js')}}"></script>
@endpush
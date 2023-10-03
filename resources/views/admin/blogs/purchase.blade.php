@extends('layouts.admin.app')
@section('title','Blog purchased list')
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
                                    <li class="breadcrumb-item active">Blog Purchases List</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Blog Purchases List</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <!--  <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a> -->
                                <div data-content="pageMenu">
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
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">From Date</label>
                                                                    <div class="form-control-wrap">
                                                                        <div class="form-icon form-icon-right">
                                                                            <em class="icon ni ni-calendar-alt"></em>
                                                                        </div>
                                                                        <input type="text" id="start_time" class="form-control date-picker-from rounded-0 shadow-none" placeholder="From Date" autocomplete="off">
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
                                                                        <input type="text" id="end_time" class="form-control date-picker-to rounded-0 shadow-none" placeholder="To Date" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot">
                                                        <a class="reset-filter" href="javascript:void(0);">Reset Filter</a>
                                                        <button id="blog-filter" type="button" class="btn btn-primary">Filter</button>
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
                                    <table id="blog-table" class="table">
                                        <thead>
                                            <tr>
                                                <th class="w_70 id">Booking ID</th>
                                                <th class="student_name">Student Name</th>
                                                <th class="blog_name">Blog Title</th>
                                                <th class="blog_price">Blog Price</th>
                                                <th class="amount_paid">Amount Paid</th>
                                                <th class="created_at">Purchase Date & Time </th>
                                                <th class="w_100 actions">Action</th>
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
<div class="modal fade" tabindex="-1" id="readMoreModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-0">Blog Title</h5>
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            </div>
            <div class="modal-body">
                <!-- <h5 class="title mb-2 mb-md-4">Description</h5> -->
                <p>
                </p>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
@endsection
@push('scripts')
<script>
    let config = "{{ config('app.currency.default')}}";
</script>
<script type="text/javascript" src="{{asset('assets/js/admin/blogs/purchase.js')}}"></script>
@endpush
@extends('layouts.admin.app')
@section('title','Class Report')
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
                                    <li class="breadcrumb-item active">Class Report</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Class Report</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <form action="{{route('class.export')}}" Method="POST">
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

                                                                <div class="col-sm-6">
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt">From Date</label>
                                                                        <div class="form-control-wrap">
                                                                            <div class="form-icon form-icon-right">
                                                                                <em class="icon ni ni-calendar-alt"></em>
                                                                            </div>
                                                                            <input type="text" id="from_date" name="from_date" class="form-control date-picker-from rounded-0 shadow-none" placeholder="From Date">
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
                                                                            <input type="text" id="to_date" name="to_date" class="form-control date-picker-to rounded-0 shadow-none" placeholder="To Date">
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-6">
                                                                    <div class="form-group ">
                                                                        <label class="overline-title overline-title-alt">Status</label>
                                                                        <select id="status" name='status' class="form-select form-select-sm" data-placeholder="Status">
                                                                            <option></option>
                                                                            <option value="active">Active</option>
                                                                            <option value="inactive">Inactive</option>
                                                                            <option value="completed">Completed</option>
                                                                            <option value="cancelled">Cancelled</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="dropdown-foot">
                                                            <a onclick="reset()" href="javascript:void(0);">Reset Filter</a>
                                                            <button type="button" id="class-report-filter" class="btn btn-primary">Filter</button>
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
                                    <table class="datatable-init table" id="class-report-datatable">
                                        <thead>
                                            <tr>
                                                <th class="w_70 id">ID</th>
                                                <th class="tutor_name">Tutor Name</th>
                                                <th class="class_description">Class description</th>
                                                <th class="class_capacity">Class Capacity</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <!-- xxxxx -->
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
<!-- Readmore modal -->
<div class="modal fade" tabindex="-1" id="readMoreModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-0">Message</h5>
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
<script src="{{asset('assets/js/admin/reports/class-report.js')}}"></script>
@endpush
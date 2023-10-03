@extends('layouts.admin.app')
@section('title','Toturs Management')
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
                                    <li class="breadcrumb-item active">Tutors Management</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Tutors Management</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <!-- <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a> -->
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
                                                                        <input type="text" class="form-control date-picker-from rounded-0 shadow-none" id="from_date" placeholder="From Date" autocomplete="off">
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
                                                                        <input type="text" class="form-control date-picker-to rounded-0 shadow-none" id="to_date" placeholder="To Date" autocomplete="off">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Verification Status</label>
                                                                    <select class="form-select form-select-sm " data-placeholder="Select Status" id="verification-status">
                                                                        <option></option>
                                                                        <option value="approved">Approved</option>
                                                                        <option value="pending">Pending</option>
                                                                        <option value="incomplete">Profile Incomplete</option>
                                                                        <option value="rejected">Rejected</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Rating</label>
                                                                    <select class="form-select form-select-sm " data-placeholder="Select Rating" id="rating">
                                                                        <option></option>
                                                                        <option value="1">1</option>
                                                                        <option value="2">2</option>
                                                                        <option value="3">3</option>
                                                                        <option value="4">4</option>
                                                                        <option value="5">5</option>
                                                                    </select>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot">
                                                        <a class="reset-filter" href="javascript:void(0);">Reset Filter</a>
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
                                                <th class="w_70 id">ID</th>
                                                <th class="name">Name</th>
                                                <th class="gender">Gender</th>
                                                <th class="phone_number">Phone Number</th>
                                                <th class="rating">Rating</th>
                                                <th class="date">Date of Joining</th>
                                                <th class="verify_status">Verification Status</th>
                                                <th class="status">Status</th>
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

@include('admin.users._change-password')

<div class="modal fade" tabindex="-1" role="dialog" id="rejectReason">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title text-center mb-3">Reject Tutor</h5>
                <form action="" method="post" id="">
                    <input type="hidden" id="tutor-id" value="">
                    <input type="hidden" id="status" value="rejected">
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="newPassword">Reject Reason</label>
                        </div>
                        <div class="form-control-wrap">
                            <textarea class="form-control rounded-0 shadow-none" id="reject_reason" rows="4"></textarea>
                        </div>
                        <span id="tutor-rejected-reason-error" class="invalid-feedback" style="display: block;"></span>

                    </div>
                    <div class="text-center mt-4">
                        <button type="button" data-dismiss="modal" class="btn btn-light width-120 ripple-effect mr-2">Cancel</button>
                        <button type="button" id="reject-submit" class="btn btn-primary width-120 ripple-effect">Reject</button>
                    </div>
                </form>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="{{asset('assets/js/admin/tutors/index.js')}}"></script>
<script src="{{asset('assets/js/admin/users/change-password.js')}}"></script>
@endpush

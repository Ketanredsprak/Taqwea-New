@extends('layouts.accountant.app')
@section('title','Student Refund Request')
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
                                    <li class="breadcrumb-item"><a href="dashboard.php">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Students Refund Request</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Student Refund Request</h3>
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
                                                    <!-- <div class="dot dot-success"></div> -->
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
                                                                    <label class="overline-title overline-title-alt">Tutor Name</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" id="tutor_name" name="tutor_name" class="form-control rounded-0 shadow-none" placeholder="Tutor Name">
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <div class="col-sm-6">
                                                                <div class="form-group">
                                                                    <label class="overline-title overline-title-alt">Student Name</label>
                                                                    <div class="form-control-wrap">
                                                                        <input type="text" id="student_name" name="student_name" class="form-control rounded-0 shadow-none" placeholder="Student Name">
                                                                    </div>
                                                                </div>
                                                            </div>
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
                                                            <div class="col-sm-12">
                                                                <div class="form-group ">
                                                                    <label class="overline-title overline-title-alt">Status</label>
                                                                    <select class="form-select form-select-sm " id="status" data-placeholder="Select Status">
                                                                        <option></option>
                                                                        <option value="cancel">Cancel</option>
                                                                        <option value="pending">Pending</option>
                                                                        <option value="refund">Refund</option>
                                                                    </select>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="dropdown-foot">
                                                        <a class="reset-filter" href="javascript:void(0);">Reset Filter</a>
                                                        <button id="class-filter" type="button" class="btn btn-primary">Filter</button>
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
                                    <table class="datatable-init table" id="refund-request-datatable">
                                        <thead>
                                            <tr>
                                                <th class="w_70 id">ID</th>
                                                <th class="tutor_name">Tutor Name</th>
                                                <th class="student_name">Student Name</th>
                                                <th class="class_name">Class Name</th>
                                                <th class="duration">Duration</th>
                                                <th class="hourly_rate">Hourly Rate</th>
                                                <th class="date_&_time">Date & Time</th>
                                                <th class="dispute_reason">Dispute Reason</th>
                                                <th class="status">Status</th>
                                                <th class="nosort actions">Action</th>
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
                <h5 class="modal-title mb-0">Dispute Reason</h5>
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            </div>
            <div class="modal-body">
                <!-- <h5 class="title mb-2 mb-md-4">Description</h5> -->
                <p>
                    Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry's standard dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing software like Aldus PageMaker including versions of Lorem Ipsum.

                </p>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
<!-- view student modal -->
<div id="studentDetail">
</div>

<!-- view student modal -->
<div class="modal fade" tabindex="-1" id="refund">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Refund</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="refundAmountRequestFrm" method='post'>
                    {{csrf_field()}}
                    <input type="hidden" name="student_id" id="student_id" value="">
                    <input type="hidden" name="class_id" id="class_id" value="">
                    <div class="form-group">
                        <label class="form-label">Refund</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="amount" name="amount" value="" placeholder="Refund" disabled>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" data-dismiss="modal" class="btn btn-light width-120 ripple-effect mr-2">Cancel</button>
                        <button type="button" id="refund-submit" class="btn btn-primary width-120 ripple-effect">Submit</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\RefundAmountRequest', '#refundAmountRequestFrm') !!}
            </div>
        </div>
    </div>
</div>
<!-- view student modal -->
<div class="modal fade" tabindex="-1" id="cancelRequest">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Cancel Reason</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="cancelRequestFrm" method="POST">
                    {{csrf_field()}}
                    <input type="hidden" name="id" id="id" value="">
                    <div class="form-group">
                        <label class="form-label">Reason</label>
                        <div class="form-control-wrap">
                            <textarea class="form-control" name="cancel_reason" placeholder="Reason" rows="5"></textarea>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" data-dismiss="modal" class="btn btn-light width-120 ripple-effect mr-2">Cancel</button>
                        <button type="button" id="submit_cancel_request" class="btn btn-primary width-120 ripple-effect">Submit</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\CancelRequest', '#cancelRequestFrm') !!}
            </div>
        </div>
    </div>
</div>

<!-- Readmore modal -->
<div class="modal fade" tabindex="-1" id="readMoreModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-0">Dispute Reason</h5>
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
<script src="{{asset('assets/js/accountant/refund-request/index.js')}}"></script>
<script>
    let config = "{{ config('app.currency.default')}}";
</script>
@endpush
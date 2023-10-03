@extends('layouts.admin.app')
@section('title','Transactions History')
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
                                    <li class="breadcrumb-item active">Transactions History</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Transactions History</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <form action="{{route('transaction-export')}}" Method="POST">
                                        @csrf
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
                                                                    <div class="form-group">
                                                                        <label class="overline-title overline-title-alt"> Payment Status</label>
                                                                        <select class="form-select form-select-sm " name="status" id="status" data-placeholder="Payment Status">
                                                                            <option></option>
                                                                            <option value="success">Success</option>
                                                                            <option value="pending">Pending</option>
                                                                            <option value="refunded">Refunded</option>
                                                                            <option value="failed">Failed</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
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
                                                            <a onclick="reset()" href="javascript:void(0);">Reset Filter</a>
                                                            <button type="button" id="transactions-history-filter" class="btn btn-primary">Filter</button>
                                                        </div>
                                                    </div><!-- .filter-wg -->
                                                </div><!-- .dropdown -->
                                            </li>
                                            <!-- li -->
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
                                    <table class="datatable-init table" id="transaction-history-datatable">
                                        <thead>
                                            <tr>
                                                <th class="w_70 id">ID</th>
                                                <th class="transaction_id">Transaction Id</th>
                                                <th class="name">Name</th>
                                                <th class="total_amount">Total Amount</th>
                                                <th class="admin_commission">Admin’s Commission </th>
                                                <th class="date">Date & Time</th>
                                                <th class="status">Payment Status </th>
                                                <th class="payment_type">Payment Type</th>
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
<script type="text/javascript" src="{{asset('assets/js/admin/payment-history/transactions-history.js')}}"></script>
<script>
    let config = "{{ config('app.currency.default')}}";
</script>
@endpush

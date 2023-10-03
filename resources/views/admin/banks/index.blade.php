@extends('layouts.admin.app')
@section('title','Manage Banks')
@section('content')
<div class="nk-content nk-content-fluid categoryPage">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm pageHead">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Manage Banks</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Manage Banks</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="btn-toolbar gx-sm-1 justify-content-end">
                                        <li>
                                        <button data-toggle="modal" data-target="#addBankCode" onclick="addBank()" class="btn btn-primary"><span>Add Bank</span></button>
                                        </li><!-- li -->
                                    </ul><!-- .btn-toolbar -->
                                </div>
                            </div>
                        </div>
                    </div><!-- .nk-block-between -->
                </div>
                <!--tab-start-->
                <div class="tab-pane fade active show" id="knowledge" role="tabpanel" aria-labelledby="knowledge">
                    <div class="card-inner p-0 common-table bg-white">
                        <table id="bank-datatable" class="table">
                            <thead>
                                <tr>
                                    <th class="id w_70 nosort border-0">ID</th>
                                    <th class="name border-0">Bank Name (en)</th>
                                    <th class="bank_name_ar border-0">Bank Name (ar)</th>
                                    <th class="code border-0">Bank Code</th>         
                                    <th class="tutor_count border-0">No. of Tutor Accounts</th>   
                                    <th class="status border-0">Status</th>              
                                    <th class="actions nosort text-center w_100 border-0">Action</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                <!--tab-end-->
            </div>
        </div>
    </div>
</div>
<!-- Add FAQ Modal -->
<div class="modal fade" id="addNewBankName" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
</div>

@endsection
@push('scripts')
<script src="{{asset('assets/js/admin/bankDetails.js')}}"></script>
@endpush
@extends('layouts.admin.app')
@section('title','Subscription Plan')
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
                                    <li class="breadcrumb-item active">Subscription Plan</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Subscription Plan</h3>
                        </div>
                        <!-- .nk-block-head-content -->
                        
                    </div><!-- .nk-block-between -->
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="w-100">
                                <div class="card-inner p-0 common-table">
                                    <table class="datatable-init table" id="subscription-datatable">
                                        <thead>
                                            <tr>
                                                <th class="w_70 no">S.No.</th>
                                                <th class="name">Subscription Name</th>
                                                <th class='allow_booking'>No. Of Student </th>
                                                <th class='class_hours'>Class Hours</th>
                                                <th class='webinar_hours'>Webinar Hours</th>
                                                <th class="featured">Featured</th>
                                                <th class="commission">Class & Webinar Commission (%)</th>
                                                <th class="blog_commission">Blog Commission (%)</th>
                                                <th class="blog">Blog</th>
                                                <th class="status">Status</th>
                                                <th class="nosort w_100 actions">Action</th>
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
<!--  edit subscription plan -->
<div id="edit-subscription">
</div><!-- .modal -->
@endsection
@push('scripts')
<script src="{{asset('assets/js/admin/subscription/index.js')}}"></script>
@endpush
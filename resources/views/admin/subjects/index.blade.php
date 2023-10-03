@extends('layouts.admin.app')
@section('title','Subject')
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
                                    <li class="breadcrumb-item active">Subject Management</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Subject Management</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="btn-toolbar gx-sm-1 justify-content-end">
                                        <li>
                                            <button onclick="addSubject()" class="btn btn-primary"><span>Add Subject</span></button>
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
                        <table id="subject-datatable" class="table">
                            <thead>
                                <tr>
                                    <th class="id w_70 border-0">ID</th>
                                    <th class="subject_name_en border-0">Subject Name(English)</th>
                                    <th class="subject_name_ar nosort border-0">Subject Name(Arabic)</th>
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

<div class="modal fade" tabindex="-1" id="addSubject">

</div>
<!-- .modal -->
@include('frontend.image-cropper-modal')
@endsection
@push('scripts')
<script src="{{asset('assets/js/admin/subjects/index.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/image-cropper.js')}}"></script>
@endpush
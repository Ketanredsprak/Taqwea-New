@extends('layouts.admin.app')
@section('title','Testimonial')
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
                                    <li class="breadcrumb-item active">Testimonial Management</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Testimonial Management</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="#" class="btn btn-icon btn-trigger toggle-expand mr-n1" data-target="pageMenu"><em class="icon ni ni-more-v"></em></a>
                                <div class="toggle-expand-content" data-content="pageMenu">
                                    <ul class="btn-toolbar gx-sm-1 justify-content-end">
                                        <li>
                                            <a href="{{route('testimonials.create')}}" class="btn btn-primary"><span>Add Testimonial</span></a>
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
                        <table id="testimonial-datatable" class="table">
                            <thead>
                                <tr>
                                    <th class="id w_70 nosort border-0">ID</th>
                                    <th class="name border-0">Name</th>
                                    <th class="rating border-0">Rating</th>
                                    <th class="content border-0">Content</th>
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

<!-- model add testimonial -->
<!-- <div class="modal fade" tabindex="-1" id="addTestimonial">
</div> -->
<!-- Readmore modal -->
<div class="modal fade" tabindex="-1" id="readMoreModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-0">Content</h5>
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
<script src="{{asset('assets/js/admin/testimonial/index.js')}}"></script>
@endpush
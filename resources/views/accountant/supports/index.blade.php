@extends('layouts.accountant.app')
@section('title','Support')
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
                                    <li class="breadcrumb-item active"> Support </li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title"> Support </h3>
                        </div>
                        <!-- .nk-block-head-content -->
                    </div><!-- .nk-block-between -->
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="w-100">
                                <div class="card-inner p-0 common-table">
                                    <table class="datatable-init table" id="support-datatable">
                                        <thead>
                                            <tr>
                                                <th class="w_70 no">ID</th>
                                                <th class="name">Name</th>
                                                <th class="email">Email</th>
                                                <th class="message">Message</th>
                                                <!-- <th class="no w_100 actions">Action</th> -->
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

<!-- reply modal -->
<div class="modal fade" tabindex="-1" id="replyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Reply</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="reply-form" action="#" class="form-validate is-alter">
                    {{csrf_field()}}
                    <div class="row gy-4">
                        <input type="hidden" value="" id="support_email_id" name="id" />
                        <div class="col-md-12">
                            <div class="form-group">
                                <label class="form-label">Email</label>
                                <div class="form-control-wrap">
                                    <input type="email" placeholder="Email Address" name="email" id="support_email" data-msg="Required" data-msg-email="Wrong Email" value="" disabled="" class="form-control rounded-0 shadow-none required email" required>
                                </div>
                            </div>
                        </div><!-- .col -->
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Message</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control support-email" id="reply_text" name="reply_text" placeholder="Message"></textarea>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="mt-4 text-center">
                        <button type="submit" class="btn btn-lg btn-primary">Send</button>
                    </div>
                    {!! JsValidator::formRequest('App\Http\Requests\Admin\SupportEmailRequest','#reply-form') !!}
                </form>
            </div>
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="{{asset('assets/js/accountant/supports/index.js')}}"></script>
@endpush
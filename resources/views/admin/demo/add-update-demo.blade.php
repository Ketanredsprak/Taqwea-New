@extends('layouts.admin.app')
@section('title','Add Update demo')
@section('content')
<div class="nk-content ">
    <div class="container">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="components-preview wide-md mx-auto">
                    <div class="nk-block-head nk-block-head-sm">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{ route('demo.index') }}">demo Managemant</a></li>

                                    <li class="breadcrumb-item active">{{$demo ? "Update" : 'Add'}} demo</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <div class="nk-block-between">

                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title">{{$demo ? "Update" : 'Add'}} demo </h3>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content pageHead__right">
                                    <div class="nk-block-head-content">
                                        <a href="{{ route('demo.index') }}" class="btn btn-primary"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-between -->
                        </div>
                    </div>
                    <div class="card card-full wide-md mx-auto">
                        <div class="card-inner">
                            <form method="POST" enctype="multipart/form-data" id="demo-frm" action="{{ $demo ? route('demo.update', $demo->id) : route('demo.store')}}" class="form-validate is-alter">
                                {{csrf_field()}}
                               
                                @if($demo)
                                <input type="hidden" name="_method" value="PUT" />
                                @endif
                                <div class="row gy-4">
                                    <div class="col-md-12">
                                      
                                        <div class="form-group">
                                            <label class="form-label">Name</label>
                                            <input type="text" name="name" value="{{$demo ? $demo->name : ''}}" placeholder="Name" class="form-control rounded-0 shadow-none required">
                                        </div>
                                        
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <button type="submit" id="demo-btn" class="btn btn-lg btn-primary">{{$demo ? "Update" : 'Add'}} demo</button>
                                </div>
                            </form>
                            {!! JsValidator::formRequest('App\Http\Requests\Admin\DemoAddUpdateRequest','#demo-frm') !!}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- content @e -->
</div>
@endsection
@push('scripts')
<script src="{{asset('assets/js/admin/demo/demo.js')}}"></script>
@endpush
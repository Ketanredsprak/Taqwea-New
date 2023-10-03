@extends('layouts.admin.app')
@section('title',$result->page_title)
@section('content')
<div class="nk-content ">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item active">{{$result->page_title}}</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">{{$result->page_title}}</h3>
                        </div><!-- .nk-block-head-content -->

                    </div><!-- .nk-block-between -->
                </div>
                <div class="card card-full wide-md mx-auto">
                    <div class="card-inner p-0">
                        <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#englishCnt" role="tab" aria-controls="englishCnt" aria-selected="false">
                                    <span>English</span>
                                </a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#arabicCnt" role="tab" aria-controls="arabicCnt" aria-selected="false">
                                    <span>Arabic</span>
                                </a>
                            </li>
                            <li class="nav-item nav-item-trigger d-lg-none">
                                <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                            </li>
                        </ul><!-- .nav-tabs -->
                        <div class="tab-content mt-0" id="pills-tabContent">

                            <div class="tab-pane mt-0 fade active show" id="englishCnt" role="tabpanel" aria-labelledby="otherInfo">
                                <div class="card-inner">
                                    <form action="{{ route('cms.update')}}" class="form-validate is-alter" method="POST" id="edit-cms-en-form">
                                        {{csrf_field()}}
                                        <input type="hidden" class="form-control" name="id" value="{{$result->id}}">
                                        <input type="hidden" class="form-control" name="language" value="en">

                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" name="en[page_title]" value="{{$result->translate('en')->page_title}}" placeholder="Title">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <textarea cols="30" name="en[page_content]" id="page_content" class="form-control" placeholder="page_content" rows="5">{{$result->translate('en')->page_content}}</textarea>

                                        </div>


                                        <div class="btn-row text-center">
                                            <button type="button" id="submitEnCms" class="btn btn-primary width-120 ripple-effect">Update</button>
                                        </div>
                                    </form>
                                    {!! JsValidator::formRequest('App\Http\Requests\Admin\CmsPageRequest','#edit-Cms-form') !!}
                                </div>
                            </div>

                            <div class="tab-pane mt-0 fade" id="arabicCnt" role="tabpanel" aria-labelledby="otherInfo">
                                <div class="card-inner">
                                    <form action="{{ route('cms.update')}}" class="form-validate is-alter" method="POST" id="edit-cms-ar-form">
                                        {{csrf_field()}}
                                        <input type="hidden" class="form-control" name="id" value="{{$result->id}}">
                                        <input type="hidden" class="form-control" name="language" value="ar">

                                        <div class="form-group">
                                            <label class="form-label">Title</label>
                                            <input type="text" class="form-control" dir="rtl" name="ar[page_title]" value="{{$result->translate('ar')->page_title}}" placeholder="Title">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Description</label>
                                            <textarea cols="30" name="ar[page_content]" dir="rtl" id="description1" class="form-control " placeholder="description" rows="5">{{$result->translate('ar')->page_content}}</textarea>
                                        </div>

                                        <div class="btn-row text-center">
                                            <button type="button" id="submitArCms" class="btn btn-primary width-120 ripple-effect">Update</button>
                                        </div>
                                    </form>
                                    {!! JsValidator::formRequest('App\Http\Requests\Admin\CmsPageRequest','#edit-cms-form') !!}
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
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="{{asset('assets/js/admin/cms/cms.js')}}"></script>
<script>
    $(document).ready(function() {
        CKEDITOR.replace('page_content', {});
        CKEDITOR.replace('description1', {contentsLangDirection: 'rtl'});
    });
</script>
@endpush
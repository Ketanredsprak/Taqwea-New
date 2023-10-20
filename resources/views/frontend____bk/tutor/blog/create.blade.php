@extends('layouts.tutor.app')
@section('title', 'Add Blog')
@section('content')
<main class="mainContent">
    <div class="addBlogPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.add_new_blog') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.add_new_blog') }}</h3>
            </div>
        </section>
        <section class="addBlogPage__innerSec">
            <div class="container">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
                </div>
                <div class="flexRow d-xl-flex">
                    <div class="column-1">
                        @include('layouts.tutor.side-bar')
                    </div>
                    <div class="column-2">
                        <div class="row">
                            <div class="col-md-12">
                                <div class="addBlogPage__form common-shadow bg-white">
                                    <div class="addBlogPage__cnt">
                                        <a href="{{ route('tutor.blogs.store') }}" class="linkBlack"><em class="icon-arrow-back"></em></a>
                                        <form action="{{ route('tutor.blogs.store') }}" method="post" id="addBlogForm" novolidate>
                                            <div class="boxContent-nav text-center">
                                                {{-- <ul class="nav nav-pills d-inline-flex">
                                                    <li class="nav-item">
                                                        <a class="nav-link active" data-toggle="pill" href="#step1-english" onclick="changeLanguage('en')">English</a>
                                                    </li>
                                                    <li class="nav-item">
                                                        <a class="nav-link" data-toggle="pill" href="#step1-arabic" onclick="changeLanguage('ar')">Arabic(عربى)</a>
                                                    </li>
                                                </ul> --}}
                                            </div>
                                            <div class="tab-content">
                                                <div class="language-div lang-en">
                                                    <h4 class="font-eb">{{ __('labels.add_new_blog') }}</h4>
                                                    <div class="form-group" style="display: none;" id="mediaimagePreviewDiv">
                                                        <div class="uploadPicture">
                                                            <img src="{{ @$class->class_image_url }}" alt="" id="mediaimagePreview">
                                                            <video controls style="height: 100%; width:100%;">
                                                                <source src="" id="mediavideoPreview" controls>
                                                                Your browser does not support HTML5 video.
                                                            </video>
                                                            <a href="javascript:void(0);" class="delete-icon deleteBlogImage">
                                                                <span class="icon-delete"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" id="blogAddImageDiv">
                                                        <div class="uploadStuff">
                                                            <input type="file" name="media" id="uploadDegree" onchange="showImagePreview($(this))" data-max-size="{{ config('constants.blog_media.maxSize') }}" accept="{{ config('constants.blog_media.acceptType') }}" aria-describedby="uploadDegree-error">
                                                            <label for="uploadDegree" class="d-flex flex-column align-items-center justify-content-center mb-0">
                                                                <div class="my-auto text-center">
                                                                    <span class="icon-upload"></span>
                                                                    <div class="font-sm txt showFileName" title="{{ __('labels.upload_video_image_document') }}">{{ __('labels.upload_video_image_document') }}</div>
                                                                </div>
                                                                <p class="mb-0 textGray">{{ __('labels.max_upload_size', ['attribute' => config('constants.blog_media.maxSize').'MB']) }}</p>
                                                            </label>
                                                        </div>
                                                        <span id="uploadDegree-error" class="invalid-feedback"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('labels.title') }}</label>
                                                        <input type="text" name="en[blog_title]" dir="rtl" class="form-control" placeholder="{{ __('labels.title') }}" value="" id="title_en">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('labels.description') }}</label>
                                                        <textarea name="en[blog_description]" dir="rtl" rows="3" id="description_en" class="form-control" placeholder="{{ __('labels.enter_description') }}"></textarea>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('labels.category') }}</label>
                                                                <select name="category_id" id="categorySelect" class="form-select" data-placeholder="{{ __('labels.select_category') }}" onchange="getLavels($(this).val())" aria-describedby="categorySelect-error">
                                                                    <option value=""></option>
                                                                    @forelse($categories as $category)
                                                                    <option value="{{ $category->id }}" data-handle="{{ $category->handle }}" {{ (@$class->category_id==$category->id)?'selected':''}}>{{ $category->translateOrDefault()->name }}</option>
                                                                    @empty

                                                                    @endforelse
                                                                </select>
                                                                <span id="categorySelect-error" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label subCategoryLavel">{{ __('labels.class_level') }}</label>
                                                                <select name="level_id" id="lavelSelect" class="form-select" data-placeholder="{{ __('labels.select_level') }}" onchange="getGrates($(this).val())" aria-describedby="lavelSelect-error">
                                                                </select>
                                                                <span id="lavelSelect-error" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6 grade-div" style="display: none;">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('labels.grade') }}</label>
                                                                <select name="grade_id" id="gradeSelect" class="form-select" data-placeholder="{{ __('labels.select_grade') }}" aria-describedby="gradeSelect-error">
                                                                </select>
                                                                <span id="gradeSelect-error" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 subject-div" style="display: none;">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('labels.subjects') }}</label>
                                                                <select name="subject_id" id="subjectSelect" class="form-select" data-placeholder="{{ __('labels.select_subjects') }}" aria-describedby="subjectSelect-error">
                                                                </select>
                                                                <span id="subjectSelect-error" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="form-group fees">
                                                        <label class="form-label">{{ __('labels.fees') }}</label>
                                                        <div class="input-group mb-0">
                                                            <div class="input-group-prepend">
                                                                <span class="input-group-text">{{ __('labels.sar') }} </span>
                                                            </div>
                                                            <input type="number" name="total_fees" class="form-control" placeholder="{{ __('labels.total_fees') }}">
                                                        </div>
                                                    </div>

                                                </div>

                                                <div class="language-div lang-ar" style="display: none;">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('labels.title') }}</label>
                                                        <input type="text" name="ar[blog_title]" dir="rtl" class="form-control" placeholder="{{ __('labels.title') }}" value="" id="title_ar">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('labels.description') }}</label>
                                                        <textarea name="ar[blog_description]" id="description_ar" dir="rtl" rows="3" class="form-control" placeholder="{{ __('labels.enter_description') }}"></textarea>
                                                    </div>
                                                </div>

                                            </div>
                                            <div class="btn-row">
                                                <button type="submit" class="btn btn-primary btn-block btn-lg ripple-effect mw-448 m-auto" id="addBlogBtn">{{ __('labels.add') }}</button>
                                            </div>
                                        </form>
                                        {!! JsValidator::formRequest('App\Http\Requests\Tutor\AddBlogRequest', '#addBlogForm') !!}
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/blog.js')}}"></script>
@endpush
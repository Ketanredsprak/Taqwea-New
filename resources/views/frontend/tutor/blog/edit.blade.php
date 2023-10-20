@extends('layouts.tutor.app')
@section('title', 'Edit Blog')
@section('content')
<main class="mainContent">
    <div class="addBlogPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item"><a href="{{ route('tutor.blogs.index') }}">{{ __('labels.my_blogs') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_blog') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.edit_blog') }}</h3>
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
                                        <a href="{{ route('tutor.blogs.show', ['blog' => $blog->id]) }}" class="linkBlack"><em class="icon-arrow-back"></em></a>
                                        <h4 class="font-eb">Edit Blog</h4>
                                        <form action="{{ url('tutor/blogs/update') }}" method="post" id="updateBlogForm" novolidate>
                                            <input type="hidden" name="blog_id" value="{{ $blog->id }}">
                                            @php $ext = pathinfo(@$blog->media_url, PATHINFO_EXTENSION); @endphp
                                            <div class="form-group" style="display: {{ (@$blog->media && $ext!='pdf')?'block':'none' }}" id="mediaimagePreviewDiv">
                                                <div class="uploadPicture">
                                                    <video controls style="height: 100%; width:100%; display: {{ (@$blog->type=='video')?'block':'none' }};">
                                                        <source src="{{ @$blog->media_url }}" id="mediavideoPreview" controls>
                                                        Your browser does not support HTML5 video.
                                                    </video>
                                                    <img src="{{ $blog->media_url }}" alt="" id="mediaimagePreview" style="display: {{ ($blog->type=='image')?'block':'none' }}">
                                                    <a href="javascript:void(0);" class="delete-icon deleteBlogImage">
                                                        <span class="icon-delete"></span>
                                                    </a>
                                                </div>
                                            </div>
                                            <div class="form-group uploadStuff" style="display: {{ (@$blog->media && $ext!='pdf')?'none':'block' }}" id="blogAddImageDiv">
                                                <input type="file" name="media" id="uploadDegree" class="d-none" onchange="showImagePreview($(this))" data-max-size="{{ config('constants.blog_media.maxSize') }}" accept="{{ config('constants.blog_media.acceptType') }}">
                                                <label for="uploadDegree" class="d-flex flex-column align-items-center justify-content-center mb-0">
                                                    <div class="my-auto text-center">
                                                        <span class="icon-upload"></span>
                                                        <div class="font-sm txt showFileName" title="{{ __('labels.upload_video_image_document') }}">{{ (@$blog->media &&  $ext=='pdf')?str_replace('blogs/','',@$blog->media):__('labels.upload_video_image_document') }}</div>
                                                    </div>
                                                    <p class="mb-0 textGray">{{ __('labels.max_upload_size', ['attribute' => config('constants.blog_media.maxSize').'MB']) }}</p>
                                                </label>
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ __('labels.title') }}</label>
                                                <input type="text" name="blog_title" class="form-control" placeholder="{{ __('labels.title') }}" value="{{ $blog->translateOrDefault()->blog_title }}">
                                            </div>
                                            <div class="form-group">
                                                <label class="form-label">{{ __('labels.description') }}</label>
                                                <textarea name="blog_description" rows="3" class="form-control" placeholder="{{ __('labels.enter_description') }}">{{ $blog->translateOrDefault()->blog_description }}</textarea>
                                            </div>
                                            <div class="row">
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('labels.category') }}</label>
                                                        <select name="category_id" id="categorySelect" class="form-select" data-placeholder="{{ __('labels.select_category') }}" onchange="getLavels($(this).val(), {{ @$blog->level_id }})" aria-describedby="categorySelect-error">
                                                            <option value=""></option>
                                                            @forelse($categories as $category)
                                                            <option value="{{ $category->id }}" {{ (@$blog->category_id==$category->id)?'selected':''}}>{{ $category->translateOrDefault()->name }}</option>
                                                            @empty

                                                            @endforelse
                                                        </select>
                                                        <span id="categorySelect-error" class="invalid-feedback"></span>
                                                    </div>
                                                </div>
                                                <div class="col-md-6">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('labels.class_level') }}</label>
                                                        <select name="level_id" id="lavelSelect" class="form-select" data-placeholder="{{ __('labels.select_level') }}" onchange="getGrates($(this).val(), {{ $blog->grade_id }})" aria-describedby="lavelSelect-error">
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
                                                            <option value=''>Select subject</option>
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
                                                    <input type="text" name="total_fees" class="form-control" placeholder="{{ __('labels.total_fees') }}" value="{{ $blog->total_fees }}" />
                                                </div>
                                            </div>
                                            <div class="btn-row">
                                                <button type="submit" class="btn btn-primary btn-block btn-lg ripple-effect mw-448 m-auto" id="updateBlogBtn">{{ __('labels.update') }}</button>
                                            </div>
                                        </form>
                                        {!! JsValidator::formRequest('App\Http\Requests\Tutor\UpdateBlogRequest', '#updateBlogForm') !!}
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
@if(@$blog)
<script>
    $(document).ready(function() {
        getLavels("{{ $blog->category_id }}", "{{ $blog->level_id }}");
        getGrates("{{ $blog->level_id }}", "{{ $blog->grade_id }}");
        getSubjects("{{ $blog->level_id }}", "{{ $blog->grade_id }}", "{{ $blog->subject_id }}");
    });
</script>
@endif
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/blog.js')}}"></script>
@endpush
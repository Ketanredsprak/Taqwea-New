@extends('layouts.admin.app')
@section('title','Add Update Testimonial')
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
                                    <li class="breadcrumb-item"><a href="{{ route('testimonials.index') }}">Testimonial Managemant</a></li>

                                    <li class="breadcrumb-item active">{{$testimonial ? "Update" : 'Add'}} Testimonial</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <div class="nk-block-between">

                                <div class="nk-block-head-content">
                                    <h3 class="nk-block-title page-title">{{$testimonial ? "Update" : 'Add'}} Testimonial </h3>
                                </div><!-- .nk-block-head-content -->
                                <div class="nk-block-head-content pageHead__right">
                                    <div class="nk-block-head-content">
                                        <a href="{{ route('testimonials.index') }}" class="btn btn-primary"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                                    </div>
                                </div>
                            </div><!-- .nk-block-between -->
                        </div>
                    </div>
                    <div class="card card-full wide-md mx-auto">
                        <div class="card-inner">
                            <form method="POST" enctype="multipart/form-data" id="testimonial-frm" action="{{ $testimonial ? route('testimonials.update', $testimonial->id) : route('testimonials.store')}}" class="form-validate is-alter">
                                {{csrf_field()}}
                               
                                @if($testimonial)
                                <input type="hidden" name="_method" value="PUT" />
                                @endif
                                <div class="row gy-4">
                                    <div class="col-md-12">
                                         @foreach (config('translatable.locales') as $locale)
                                        <div class="form-group">
                                            <label class="form-label">Name ({{$locale}})</label>
                                            <input type="text" name="{{$locale}}[name]" @if($locale == 'ar') dir="rtl" @endif value="{{$testimonial ? $testimonial->translate($locale)->name : ''}}" placeholder="Name" class="form-control rounded-0 shadow-none required">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">Content ({{$locale}})</label>
                                            <textarea name="{{$locale}}[content]" @if($locale == 'ar') dir="rtl" @endif placeholder="Content" class="form-control rounded-0 shadow-none required">{{$testimonial ? $testimonial->translate($locale)->content : ''}}</textarea>
                                        </div>
                                        @endforeach
                                        <div class="form-group">
                                            <label class="form-label">Rating</label>
                                            <select class="form-select form-select-sm select2-hidden-accessible" id="rating" data-placeholder="Select Rating" name="rating"  aria-describedby="rating-error">
                                                <option value="">Select Rating</option>
                                                <option value="1" {{($testimonial && $testimonial->rating == 1) ? 'selected' : ''}}>1</option>
                                                <option value="2" {{($testimonial && $testimonial->rating == 2) ? 'selected' : ''}}>2</option>
                                                <option value="3" {{($testimonial && $testimonial->rating == 3) ? 'selected' : ''}}>3</option>
                                                <option value="4" {{($testimonial && $testimonial->rating == 4) ? 'selected' : ''}}>4</option>
                                                <option value="5" {{($testimonial && $testimonial->rating == 5) ? 'selected' : ''}}>5</option>
                                            </select>
                                            <span id="rating-error" class="invalid-feedback"></span>
                                        </div>

                                        <div class="form-group" style="display: {{ ($testimonial ? ( $testimonial->testimonial_file ? 'block':'none'):'none')}}" id="testimonial_fileimagePreviewDiv">
                                            <input type="hidden" id="old_images" name="old_images" value="{{$testimonial ? $testimonial->testimonial_file : ''}}">
                                            <div class="uploadPicture">
                                                <img src="{{ ($testimonial ? ($testimonial->testimonial_file ? $testimonial->testimonial_image_url : ''):'') }}" alt="" id="testimonial_fileimagePreview">
                                                <a href="javascript:void(0);" class="delete-icon deleteTestimonialImage">
                                                    <span class="icon ni ni-trash"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group" style="display: {{ ($testimonial ? ($testimonial->testimonial_file ? 'none':'block'):'block') }}" id="testimonailAddUpdateImageDiv">
                                            <div class="uploadStuff">
                                                <input type="file" name="testimonial_file" id="uploadId" aria-describedby="uploadId-error" onchange="showImagePreview($(this))" data-max-size="{{ config('constants.testimonial_file.maxSize') }}" accept="{{ config('constants.testimonial_file.acceptType') }}" aria-describedby="categorySelect-error">
                                                <label for="uploadId" class="d-flex flex-column align-items-center justify-content-center mb-0">
                                                    <div class="my-auto text-center">
                                                        <span class="icon ni ni-upload"></span>
                                                        <div class="font-sm txt showFileName">Upload an image</div>
                                                    </div>
                                                    <p class="mb-0 textGray">Max. upload size 5MB</p>
                                                </label>
                                            </div>
                                            <span id="uploadId-error" class="invalid-feedback"></span>
                                        </div>
                                    </div>
                                </div>
                                <div class="mt-4 text-center">
                                    <button type="submit" id="testimonial-btn" class="btn btn-lg btn-primary">{{$testimonial ? "Update" : 'Add'}} Testimonial</button>
                                </div>
                            </form>
                            {!! JsValidator::formRequest('App\Http\Requests\Admin\TestimonialAddUpdateRequest','#testimonial-frm') !!}
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
<script src="{{asset('assets/js/admin/testimonial/index.js')}}"></script>
@endpush
@extends('layouts.tutor.app')
@section('title', $title)
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css" type="text/css">
@endpush
@section('content')
<main class="mainContent">
    <div class="addClassPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item">
                                @if($classType=='class')
                                <a href="{{ route('tutor.classes.index') }}">{{ __('labels.my_classes') }}</a>
                                @else
                                <a href="{{ route('tutor.webinars.index') }}">{{ __('labels.my_webinars') }}</a>
                                @endif
                            </li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ $title }}</h3>
            </div>
        </section>
        <section class="addClassPage__inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-12">
                        <div class="addClassPage__form">
                            <div class="boxContent my-auto">
                                <div class="boxContent-inner boxContent-inner-stepForm">
                                    <ul class="list-unstyled d-flex steps" id="progressbar">
                                        <li class="steps-step active">
                                            <span class="steps-step_count">1</span>
                                            <div class="steps-step_title font-bd">{{ ($classType=='class')? __('labels.class_detail'):__('labels.webinar_details') }}</div>
                                        </li>
                                        <li class="steps-step">
                                            <span class="steps-step_count">2</span>
                                            <div class="steps-step_title font-bd">{{__('labels.topics_detail')}}</div>
                                        </li>
                                    </ul>
                                    <fieldset class="boxContent-form position-relative">
                                        <form action="{{ route('tutor.classes.store') }}" id="addClassForm" novalidate>
                                            <input type="hidden" name="class_type" value="{{ $classType }}">
                                            <input type="hidden" name="class_id" value="{{ (@$class->id)?$class->id:0 }}">
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
                                                    <div class="form-group" style="display: {{ (@$class->class_image)?'block':'none' }}" id="class_imageimagePreviewDiv">
                                                        <div class="uploadPicture">
                                                            <img src="{{ @$class->class_image_url }}" alt="" id="class_imageimagePreview">
                                                            <video controls style="height: 100%; width:100%;">
                                                                <source src="" id="videoPreview" controls>
                                                                Your browser does not support HTML5 video.
                                                            </video>
                                                            <a href="javascript:void(0);" class="delete-icon deleteClassImage">
                                                                <span class="icon-delete"></span>
                                                            </a>
                                                        </div>
                                                    </div>
                                                    <div class="form-group" style="display: {{ (@$class->class_image)?'none':'block' }}" id="classAddImageDiv">
                                                        <div class="uploadStuff">
                                                            <input type="file" name="class_image" id="uploadId" aria-describedby="uploadId-error" onchange="showImagePreview($(this))" data-max-size="{{ config('constants.class_image.maxSize') }}" accept="{{ config('constants.class_image.acceptType') }}" aria-describedby="uploadId-error">
                                                            <label for="uploadId" class="d-flex flex-column align-items-center justify-content-center mb-0">
                                                                <div class="my-auto text-center">
                                                                    <span class="icon-upload"></span>
                                                                    <div class="font-sm txt showFileName">{{__('labels.upload_a_image')}}</div>
                                                                </div>
                                                                <p class="mb-0 textGray">{{__('labels.max_upload_size', ["attribute" => "5MB"])}}</p>
                                                            </label>
                                                        </div>
                                                        <span id="uploadId-error" class="invalid-feedback"></span>
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">{{ ($classType=='class')? __('labels.class_name'):__('labels.webinar_name') }}</label>
                                                        <input type="text" name="en[class_name]" class="form-control" dir="rtl" placeholder="{{__('labels.enter_name')}}" value="{{ @$class->class_name }}" id="class_name_en">
                                                    </div>
                                                    <div class="row">
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">{{__('labels.category')}}</label>
                                                                <select name="category_id" id="categorySelect" class="form-select" data-placeholder="{{__('labels.select_category')}}" onchange="getLavels($(this).val())" aria-describedby="categorySelect-error">
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
                                                                <label class="form-label subCategoryLavel">{{__('labels.class_level')}}</label>
                                                                <select name="level_id" id="lavelSelect" class="form-select" data-placeholder="{{__('labels.select_levels')}}" onchange="getGrates($(this).val())" aria-describedby="lavelSelect-error">
                                                                </select>
                                                                <span id="lavelSelect-error" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 grade-div" style="display: none;">
                                                            <div class="form-group">
                                                                <label class="form-label">{{__('labels.grade')}}</label>
                                                                <select name="grade_id" id="gradeSelect" class="form-select" data-placeholder="{{__('labels.select_grade')}}" aria-describedby="gradeSelect-error">
                                                                </select>
                                                                <span id="gradeSelect-error" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6 subject-div" style="display: none;">
                                                            <div class="form-group">
                                                                <label class="form-label">{{__('labels.subjects')}}</label>
                                                                <select name="subject_id" id="subjectSelect" class="form-select" data-placeholder="{{__('labels.select_subjects')}}" aria-describedby="subjectSelect-error">
                                                                    <option value=""></option>
                                                                </select>
                                                                <span id="subjectSelect-error" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group">
                                                                <label class="form-label">{{ __('labels.gender_preference') }}</label>
                                                                <select name="gender_preference" class="form-select" data-placeholder="{{__('labels.gender_preference')}}">
                                                                    <option value="both" {{ (@$class->gender_preference=='both')?'selected':''}}>{{__('labels.both')}}</option>
                                                                    <option value="male" {{ (@$class->gender_preference=='male')?'selected':''}}>{{__('labels.male')}}</option>
                                                                    <option value="female" {{ (@$class->gender_preference=='female')?'selected':''}}>{{__('labels.female')}}</option>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{($classType=='class')? __("labels.class_description"):  __("labels.webinar_description")}}</label>
                                                        <textarea name="en[class_description]" dir="ltr" id="description1" rows="3" class="form-control" placeholder="{{__('labels.enter_description')}}">{{ @$class->class_description }}</textarea>
                                                    </div>
                                                </div>
                                                <div class="language-div lang-ar" style="display: none;">
                                                    <div class="form-group">
                                                        <label class="form-label">{{ ($classType=='class')? __('labels.class_name'):__('labels.webinar_name') }}</label>
                                                        <input type="text" name="ar[class_name]" dir="rtl" class="form-control" placeholder="{{__('labels.enter_name')}}" value="{{ @$class->{'class_name:ar'} }}" id="class_name_ar">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{($classType=='class')? __("labels.class_description"):  __("labels.webinar_description")}}</label>
                                                        <textarea name="ar[class_description]" dir="rtl" id="description_ar"  rows="3" class="form-control" placeholder="{{__('labels.enter_description')}}">{{ @$class->{'class_description:ar'} }}</textarea>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="submitBtn">
                                                <button type="submit" id="addClassBtn" class="btn btn-primary btn-block btn-lg ripple-effect mw-448 mx-auto next action-button">{{ __("labels.save_continue") }}</button>
                                            </div>
                                        </form>
                                        {!! JsValidator::formRequest('App\Http\Requests\Tutor\AddClassRequest', '#addClassForm') !!}
                                    </fieldset>
                                    <fieldset class="boxContent-form position-relative">
                                        <form action="" method="POST" id="addClassDetailForm">
                                            <div class="tab-content">
                                                <input type="hidden" name="class_id" id="classId" value="{{ (@$class->id)?$class->id:0 }}">
                                                <div class="addNewTopic">
                                                    <div class="addNewTopic__cnt">
                                                        <a href="javascript:void(0)" class="linkPrimary font-bd" onclick="addNewTopic()">
                                                            +{{__('labels.add_new_topic')}}
                                                        </a>
                                                    </div>
                                                </div>
                                                <div id="topics" class="accordion customAccordion">
                                                </div>
                                                <div class="timeDetail">
                                                    <div class="row">
                                                        <div class="col-md-12">
                                                            <div class="form-group">
                                                                <label class="form-label">{{__('labels.duration')}}</label>
                                                                <select name="duration" id="durationOfClass" class="form-select" data-placeholder="{{__('labels.duration')}}" aria-describedby="durationOfClass-error">
                                                                    <option value=""></option>
                                                                    <option value="0.5" {{ (@$class->duration/60==0.5)?'selected':'' }}>30 {{__('labels.minutes')}}</option>
                                                                    <option value="1" {{ (@$class->duration/60==1)?'selected':'' }}>1 {{__('labels.hours')}}</option>
                                                                    <option value="1.5" {{ (@$class->duration/60==1.5)?'selected':'' }}>1 {{__('labels.hours')}} 30 {{__('labels.minutes')}}</option>
                                                                    <option value="2" {{ (@$class->duration/60==2)?'selected':'' }}>2 {{__('labels.hours')}}</option>
                                                                    <option value="2.5" {{ (@$class->duration/60==2.5)?'selected':'' }}>2 {{__('labels.hours')}} 30 {{__('labels.minutes')}}</option>
                                                                    <option value="3" {{ (@$class->duration/60==3)?'selected':'' }}>3 {{__('labels.hours')}}</option>
                                                                    <option value="3.5" {{ (@$class->duration/60==3.5)?'selected':'' }}>3 {{__('labels.hours')}} 30 {{__('labels.minutes')}}</option>
                                                                    <option value="4" {{ (@$class->duration/60==4)?'selected':'' }}>4 {{__('labels.hours')}}</option>
                                                                    <option value="4.5" {{ (@$class->duration/60==4.5)?'selected':'' }}>4 {{__('labels.hours')}} 30 {{__('labels.minutes')}}</option>
                                                                    <option value="5" {{ (@$class->duration/60==5)?'selected':'' }}>5 {{__('labels.hours')}}</option>
                                                                    <option value="5.5" {{ (@$class->duration/60==5.5)?'selected':'' }}>5 {{__('labels.hours')}} 30 {{__('labels.minutes')}}</option>
                                                                    <option value="6" {{ (@$class->duration/60==6)?'selected':'' }}>6 {{__('labels.hours')}}</option>
                                                                    <option value="6.5" {{ (@$class->duration/60==6.5)?'selected':'' }}>6 {{__('labels.hours')}} 30 {{__('labels.minutes')}}</option>
                                                                    <option value="7" {{ (@$class->duration/60==7)?'selected':'' }}>7 {{__('labels.hours')}}</option>
                                                                    <option value="7.5" {{ (@$class->duration/60==7.5)?'selected':'' }}>7 {{__('labels.hours')}} 30 {{__('labels.minutes')}}</option>
                                                                    <option value="8" {{ (@$class->duration/60==8)?'selected':'' }}>8 {{__('labels.hours')}}</option>
                                                                </select>
                                                                <span id="durationOfClass-error" class="invalid-feedback"></span>
                                                            </div>
                                                        </div>
                                                
                                                        @php
                                                        $classDate = '';
                                                        $classTime = '';
                                                        if(@$class->start_time){
                                                        $classDate = convertDateToTz($class->start_time, 'UTC', 'd/m/Y', '', 'withoutTranslate');
                                                        $classTime = convertDateToTz($class->start_time, 'UTC', 'h:i A', '', 'withoutTranslate');


                                                        }
                                                        @endphp
                                                       
                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-icon" id="datepicker1" dir="{{config('constants.date_format_direction')}}" data-target-input="nearest">
                                                                <label class="form-label">{{__('labels.date')}}</label>
                                                                <input type="text" name="class_date" class="form-control datetimepicker-input disbeldateTime"  value="{{ $classDate }}" placeholder="{{__('labels.date')}}" data-target="#datepicker1"/>
                                                                <div class="input-group-append" data-target="#datepicker1" data-toggle="datetimepicker">
                                                                    <i class="icon-calendar-2 icon"></i>
                                                                </div>
                                                            </div>
                                                        </div>

                                                        <div class="col-md-6">
                                                            <div class="form-group form-group-icon" dir="{{config('constants.date_format_direction')}}" id="timepicker" data-target-input="nearest">
                                                                <label class="form-label">{{__('labels.time')}}</label>
                                                                <input type="text" name="class_time" class="form-control datetimepicker-input disbeldateTime"  value="{{ $classTime }}" placeholder="{{__('labels.time')}}" data-target="#timepicker"/>
                                                                <div class="input-group-append" data-target="#timepicker" data-toggle="datetimepicker">
                                                                    <i class="icon-time icon"></i>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-12">
                                                            <div class="form-group mb-0">
                                                                <label class="form-label">{{__('labels.fees')}}</label>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group d-flex align-items-center mb-md-0">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="classHourlyFess" name="class_fees_type" value="hourly_fees" class="custom-control-input" {{ (@$class->hourly_fees || empty(@$class->total_fees))?'checked':'' }}>
                                                                    <label class="custom-control-label" for="classHourlyFess">
                                                                    </label>
                                                                </div>
                                                                <div class="fees w-100  ml-3">
                                                                    <div class="input-group mb-0">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">{{ __('labels.sar') }} </span>
                                                                        </div>
                                                                        <input name="hourly_fees" value="{{ (@$class->hourly_fees)?$class->hourly_fees:'' }}" type="number" min="1" class="form-control" placeholder="{{__('labels.hourly_fees')}}" {{ (@$class->total_fees)?'disabled':'' }}>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <div class="col-md-6">
                                                            <div class="form-group d-flex align-items-center mb-md-0">
                                                                <div class="custom-control custom-radio">
                                                                    <input type="radio" id="classTotalFees" name="class_fees_type" value="total_fees" class="custom-control-input" {{ (@$class->total_fees)?'checked':'' }}>
                                                                    <label class="custom-control-label" for="classTotalFees">
                                                                    </label>
                                                                </div>
                                                                <div class="fees w-100 mb-0 ml-3">
                                                                    <div class="input-group mb-0">
                                                                        <div class="input-group-prepend">
                                                                            <span class="input-group-text">{{ __('labels.sar') }} </span>
                                                                        </div>
                                                                        <input name="total_fees" value="{{ (@$class->total_fees)?$class->total_fees:'' }}" type="number" min="1" class="form-control" placeholder="{{__('labels.total_fees')}}" {{ (@$class->hourly_fees || empty(@$class->total_fees))?'disabled':'' }}>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="submitBtn d-flex justify-content-between">
                                                <button type="button" class="btn btn-light ripple-effect-dark previous">{{__('labels.back')}}</button>
                                                <button type="submit" id="addClassDetailBtn" class="btn btn-primary btn-block btn-lg ripple-effect mw-300">{{__('labels.save_preview')}}</button>
                                            </div>
                                        </form>
                                        {!! JsValidator::formRequest('App\Http\Requests\Tutor\AddClassDetailRequest', '#addClassDetailForm') !!}
                                    </fieldset>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<div class="modal fade" id="addNewTopicModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
</div>
@if(@$class)
<script> 
    $(document).ready(function() {
        getLavels("{{ $class->category_id }}", "{{ $class->level_id }}");
        getGrates("{{ $class->level_id }}", "{{ $class->grade_id }}");
        getSubjects("{{ $class->level_id }}", "{{ $class->grade_id }}", "{{ $class->subject_id }}");

    });
</script>
@endif
@endsection
@push('scripts')
<script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/class.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/topic.js')}}"></script>
@endpush
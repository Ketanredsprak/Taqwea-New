@extends('layouts.student.app')
@section('title', __('labels.class_request'))
@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"
        type="text/css">
@endpush
@section('content')
    <main class="mainContent">
        <div class="editProfilePage commonPad bg-green">
            <section class="pageTitle">
                <div class="container">
                    <div class="commonBreadcrumb">
                        <nav aria-label="breadcrumb">
                            <ol class="breadcrumb">
                                <li class="breadcrumb-item"><a
                                        href="{{ route('student/dashboard') }}">{{ __('labels.home') }}</a></li>
                                <li class="breadcrumb-item active" aria-current="page">{{ __('labels.class_request') }}</li>
                            </ol>
                        </nav>
                    </div>
                    <h3 class="h-32 pageTitle__title">{{ __('labels.class_request') }}</h3>
                </div>
            </section>
            <section class="editProfilePage__inner">
                <div class="container">
                    <div class="d-flex align-items-center mb-3">
                        <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span
                                class="icon-menu"></span></button>
                    </div>
                    <div class="flexRow d-xl-flex">
                        <div class="column-1">
                            @include('layouts.student.side-bar')
                        </div>
                        <div class="column-2">
                            <div class="editProfilePage__Form commonBox">
                                <div class="editFormSec">
                                    <form action="{{ route('student.classrequest.store') }}" method="POST"
                                        id="addClassRequestForm" novolidate>

                                        <div class="row">
                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.duration') }}</label>
                                                    <select name="class_duration" class="form-select"
                                                        data-placeholder="{{ __('labels.duration') }}" id="class_duration">
                                                        <option value=""></option>
                                                        <option value="0.5">30 {{ __('labels.minutes') }}</option>
                                                        <option value="1">1 {{ __('labels.hours') }}</option>
                                                        <option value="1.5">1 {{ __('labels.hours') }} 30
                                                            {{ __('labels.minutes') }}</option>
                                                        <option value="2">2 {{ __('labels.hours') }}</option>
                                                        <option value="2.5">2 {{ __('labels.hours') }} 30
                                                            {{ __('labels.minutes') }}</option>
                                                        <option value="3">3 {{ __('labels.hours') }}</option>
                                                        <option value="3.5">3 {{ __('labels.hours') }} 30
                                                            {{ __('labels.minutes') }}</option>
                                                        <option value="4">4 {{ __('labels.hours') }}</option>
                                                        <option value="4.5">4 {{ __('labels.hours') }} 30
                                                            {{ __('labels.minutes') }}</option>
                                                        <option value="5">5 {{ __('labels.hours') }}</option>
                                                        <option value="5.5">5 {{ __('labels.hours') }} 30
                                                            {{ __('labels.minutes') }}</option>
                                                        <option value="6">6 {{ __('labels.hours') }}</option>
                                                        <option value="6.5">6 {{ __('labels.hours') }} 30
                                                            {{ __('labels.minutes') }}</option>
                                                        <option value="7">7 {{ __('labels.hours') }}</option>
                                                        <option value="7.5">7 {{ __('labels.hours') }} 30
                                                            {{ __('labels.minutes') }}</option>
                                                        <option value="8">8 {{ __('labels.hours') }}</option>
                                                    </select>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.category') }}</label>
                                                    <select name="category_id" id="categorySelect1" class="form-select"
                                                        data-placeholder="{{ __('labels.select_category') }}"
                                                        onchange="getLavels($(this).val())"
                                                        aria-describedby="categorySelect-error">
                                                        <option value=""></option>
                                                        @forelse($categories as $category)
                                                            <option value="{{ $category->id }}"
                                                                data-handle="{{ $category->handle }}"
                                                                >
                                                                {{ $category->translateOrDefault()->name }}</option>
                                                        @empty
                                                        @endforelse
                                                    </select>
                                                    <span id="categorySelect-error" class="invalid-feedback"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group class_level">
                                                    <label
                                                        class="form-label subCategoryLavel">{{ __('labels.class_level') }}</label>
                                                    <select name="level_id" id="lavelSelect" class="form-select"
                                                        data-placeholder="{{ __('labels.select_levels') }}"
                                                        onchange="getGrates($(this).val())"
                                                        aria-describedby="lavelSelect-error">
                                                    </select>
                                                    <span id="lavelSelect-error" class="invalid-feedback"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6 grade-div" style="display: none;">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.grade') }}</label>
                                                    <select name="grade_id" id="gradeSelect" class="form-select"
                                                        data-placeholder="{{ __('labels.select_grade') }}"
                                                        aria-describedby="gradeSelect-error">
                                                    </select>
                                                    <span id="gradeSelect-error" class="invalid-feedback"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6 subject-div" style="display: none;">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.subjects') }}</label>
                                                    <select name="subject_id" id="subjectSelect" class="form-select"
                                                        data-placeholder="{{ __('labels.select_subjects') }}"
                                                        aria-describedby="subjectSelect-error">
                                                        <option value=""></option>
                                                    </select>
                                                    <span id="subjectSelect-error" class="invalid-feedback"></span>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.gender_preference') }}</label>
                                                    <select name="gender_preference" class="form-select"
                                                        data-placeholder="{{ __('labels.gender_preference') }}">
                                                        <option value="both">
                                                            {{ __('labels.both') }}</option>
                                                        <option value="male">
                                                            {{ __('labels.male') }}</option>
                                                        <option value="female">
                                                            {{ __('labels.female') }}</option>
                                                    </select>
                                                </div>
                                            </div>




                                            <div class="col-md-6">
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.classes_type') }}</label><br>
                                                    <input type="radio" id="click_single" name="class_type"
                                                        value="Single" checked> <label for="Single">Single</label>
                                                    <input type="radio" id="click_multiple" name="class_type"
                                                        value="Multiple" class="click_multiple"> <label
                                                        for="Multiple">Multiple</label>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-icon"
                                                            dir="{{ config('constants.date_format_direction') }}"
                                                            id="timepicker" data-target-input="nearest">
                                                            <label class="form-label">{{ __('labels.time') }}</label>
                                                            <input type="text" name="class_time"
                                                                class="form-control datetimepicker-input disbeldateTime"
                                                                value="" placeholder="{{ __('labels.time') }}"
                                                                data-target="#timepicker" />
                                                            <div class="input-group-append" data-target="#timepicker"
                                                                data-toggle="datetimepicker">
                                                                <i class="icon-time icon"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="col-md-6">
                                                <div class="row" id="hide_on_click_multiple">
                                                    <div class="col-md-12">
                                                        <div class="form-group form-group-icon" id="datepicker1"
                                                            dir="{{ config('constants.date_format_direction') }}"
                                                            data-target-input="nearest">
                                                            <label class="form-label">{{ __('labels.date') }}</label>
                                                            <input type="text" name="class_date" id="multiple_date"
                                                                class="form-control datetimepicker-input disbeldateTime"
                                                                value="" placeholder="{{ __('labels.date') }}"
                                                                data-target="#datepicker1" required />
                                                            <div class="input-group-append" data-target="#datepicker1"
                                                                data-toggle="datetimepicker">
                                                                <i class="icon-calendar-2 icon"></i>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="row d-none" id="multiple_class">
                                            <div class="col-md-4">
                                                <label class="form-label">{{ __('labels.number_of_class') }}</label>
                                                <input type="text" name="number_of_class" id="number_of_class"
                                                    class="form-control" value="1"
                                                    placeholder="{{ __('labels.number_of_class') }}" readonly="" />
                                            </div>
                                            <div class="col-md-6">
                                                <div class="form-group form-group-icon" id="datepicker2"
                                                    dir="{{ config('constants.date_format_direction') }}"
                                                    data-target-input="nearest">
                                                    <label class="form-label">{{ __('labels.date') }}</label>
                                                    <input type="text" name="class[0][date]"
                                                        class="form-control datetimepicker-input disbeldateTime"
                                                        value="" placeholder="{{ __('labels.date') }}"
                                                        data-target="#datepicker2" />
                                                    <div class="input-group-append" data-target="#datepicker2"
                                                        data-toggle="datetimepicker">
                                                        <i class="icon-calendar-2 icon"></i>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="col-sm-2">
                                                <button type="button" class="btn btn-primary btn-sm btn-lg "
                                                    id="add_class_field" style="margin-top:35px;">Add</button>
                                            </div>
                                        </div>

                                        <div class="" id="add_new_field"></div>

                                    <div class="row">
                                        <div class="col-md-12">
                                            <label class="form-label">{{ __('labels.message') }}</label>
                                            <textarea type="text" name="note" id="message"
                                                class="form-control" rows="5" dir="rtl"></textarea>
                                        </div>
                                    </div>


                                        <div class="btn-row">
                                            <button type="submit" id="classRequestBtn"
                                                class="btn btn-primary btn-block btn-lg mw-300 m-auto ripple-effect">{{ __('labels.request') }}</button>
                                        </div>
                                        <br><br><br><br><br>
                                    </form>
                                    {!! JsValidator::formRequest('App\Http\Requests\Student\ClassRequestRequest', '#classRequestBtn') !!}

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </section>
        </div>
    </main>
    @include('frontend.image-cropper-modal')
@endsection
@push('scripts')
    <script type="text/javascript" src="{{ asset('assets/js/frontend/image-cropper.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/student/class-request.js') }}"></script>
    <script src="https://cdn.ckeditor.com/4.14.1/standard/ckeditor.js"></script>
    <script
        src="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/js/tempusdominus-bootstrap-4.min.js">
    </script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/tutor/class.js') }}"></script>
    <script type="text/javascript" src="{{ asset('assets/js/frontend/tutor/topic.js') }}"></script>
@endpush

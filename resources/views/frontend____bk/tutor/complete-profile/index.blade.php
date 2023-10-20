@extends('layouts.tutor.app')
@section('title',__('labels.complete_profile'))
@push('css')
<link href="{{ asset('assets/css/frontend/auth.css') }}" rel="stylesheet" type="text/css" />
@endpush
@section('content')
<main class="mainContent">
    <div class="authPage bg-green">
        <div class="authPage-content d-flex">
            <div class="authPage-content_left d-flex flex-column">
                <div class="authSlider my-auto" id="authSlider">
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.search_qualified_tutors') }}</h2>
                            <p>{{ __('labels.we_have_qualified_tutors_to_teach') }} <br> {{ __('labels.make_that_subject_easy') }}</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.book_classes') }}</h2>
                            <p>{{ __('labels.book_the_desired_class') }} <br> {{ __('labels.of_class_and_tutor_ratings') }}</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.payment') }}</h2>
                            <p>{{ __('labels.quick_and_easy_payment') }} <br> {{ __('labels.class_booking') }}</p>
                        </div>
                    </div>
                    <div class="authSlider-slides">
                        <div class="authSlider-slides_content text-center text-white">
                            <h2 class="font-eb">{{ __('labels.start_learning') }}</h2>
                            <p>{{ __('labels.start_your_class_and_enjoy_learning') }} <br> {{ __('labels.with_taqwea') }}</p>
                        </div>
                    </div>
                </div>
                <div class="imgBox">
                    <img src="{{ asset('assets/images/auth.png') }}" class="img-fluid" alt="{{ __('labels.auth') }}">
                </div>
            </div>
            <div class="authPage-content_right">
                <div class="boxContent my-auto">
                    <div class="boxContent-inner boxContent-inner-stepForm">

                        <ul class="list-unstyled d-flex steps" id="progressbar">
                            <li class="steps-step active">
                                <span class="steps-step_count">1</span>
                                <div class="steps-step_title font-bd">{{ __('labels.personal_details') }}</div>
                            </li>
                            <li class="steps-step">
                                <span class="steps-step_count">2</span>
                                <div class="steps-step_title font-bd">{{ __('labels.educational_details') }}</div>
                            </li>
                            <li class="steps-step">
                                <span class="steps-step_count">3</span>
                                <div class="steps-step_title font-bd">{{ __('labels.professional_details') }}</div>
                            </li>
                        </ul>

                        <fieldset class="boxContent-form position-relative">
                            <form action="{{ route('tutor/personal-details', ['id' => $user->id]) }}" method="POST" id="personalDetailsForm" novolidate>
                                <input type="hidden" id="pageType" value="completeProfile">
                                <!-- <div class="boxContent-nav text-center">
                                    <ul class="nav nav-pills d-inline-flex">
                                        <li class="nav-item">
                                            <a class="nav-link active" onclick="getUserDetail('en')" data-lang="en" data-toggle="pill" href="#step1-english">English</a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link" onclick="getUserDetail('ar')" data-lang="ar" data-toggle="pill" href="#step1-arabic">Arabic(عربى)</a>
                                        </li>
                                    </ul>
                                </div> -->
                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="step1-english" role="tabpanel">
                                        <div class="imgUpload position-relative mx-auto">
                                            <img src="" class="rounded-circle userimage" id="imagePreview" alt="{{ __('labels.user') }}">
                                            <div class="imgUpload-icon">
                                                <label for="uploadImg">
                                                    <span class="icon-camera"></span>
                                                </label>
                                                <input type="file" id="uploadImg" class="d-none" onchange="setImage(this,$(this),'profile_image');" data-width-height="{{ config('constants.profile_image.dimension') }}" data-max-size="{{ config('constants.profile_image.maxSize') }}" data-accept-file="{{ config('constants.profile_image.acceptType') }}" data-preview-id="imagePreview" data-base64-id="uploadImageBase64" accept="image/png,image/jpg,image/jpeg">
                                                <input type="hidden" name="profile_image" id="uploadImageBase64" value="">
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.name') }}</label>
                                            {{-- <label class="form-label">{{ __('labels.name_in_english') }}</label> --}}
                                            <input name="en[name]" type="text" class="form-control name_en" id="name_en" placeholder="{{ __('labels.enter_name') }}" {{ ($user->name)?'disabled':'' }} autocomplete="nope">
                                            @if($user->name)
                                            <input name="en[name]" type="hidden" value="{{ $user->name }}">
                                            @endif
                                        </div>
                                        <div class="form-group" style="display: none">
                                            <label class="form-label">{{ __('labels.name_in_arabic') }}</label>
                                            <input name="ar[name]" type="text" class="form-control name_ar" id="name_ar" placeholder="{{ __('labels.enter_name') }}" dir="rtl">
                                        </div>

                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.email_id') }}</label>
                                            <input type="email" name="email" class="form-control email_en" placeholder="{{ __('labels.enter_email_id') }}" {{ ($user->email)?'disabled':'' }} autocomplete="nope">
                                            @if($user->email)
                                            <input name="email" type="hidden" value="{{ $user->email }}">
                                            @endif
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.mobile_number') }}</label>
                                            <input type="text" dir="rtl" name="phone_number" class="form-control phone_number_en only-number" placeholder="{{ __('labels.mobile_number') }}" {{ ($user->phone_number)?'readonly':'' }} autocomplete="nope">
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label d-block">{{__('labels.gender')}}</label>
                                            <div class="custom-control custom-radio d-inline-flex">
                                                <input type="radio" name="gender" value="male" id="male" name="signup" class="custom-control-input" {{ ($user->gender)?'disabled':'' }} {{ ($user->gender=='male')?'checked':'' }}>
                                                <label class="custom-control-label font-bd" for="male">{{__('labels.male')}}</label>
                                            </div>
                                            <div class="custom-control custom-radio d-inline-flex ml-5">
                                                <input type="radio" name="gender" value="female" id="female" name="signup" class="custom-control-input" {{ ($user->gender)?'disabled':'' }} {{ ($user->gender=='female')?'checked':'' }}>
                                                <label class="custom-control-label font-bd" for="female">{{__('labels.female')}}</label>
                                            </div>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.bio') }}</label>
                                            {{-- <label class="form-label">{{ __('labels.bio_in_english') }}</label> --}}
                                            <textarea name="en[bio]" rows="3" dir="rtl" class="form-control bio_en" id="bio_en" placeholder="{{ __('labels.enter_bio') }}"></textarea>
                                        </div>
                                        <div class="form-group" style="display: none">
                                            <label class="form-label">{{ __('labels.bio_in_arabic') }}</label>
                                            <textarea name="ar[bio]" rows="3" class="form-control bio_ar" id="bio_ar" placeholder="{{ __('labels.enter_bio') }}" dir="rtl"></textarea>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.address') }}</label>
                                            <input name="address" id="addressPlace" type="text" dir="rtl" class="form-control address_en" placeholder="{{ __('labels.enter_address') }}" autocomplete="nope">
                                        </div>
                                        @php $ext = pathinfo(@$user->tutor->id_card, PATHINFO_EXTENSION); @endphp
                                        <!-- <div class="form-group" style="display: {{ (@$user->tutor->id_card && $ext!='pdf')?'block':'none' }}" id="id_cardimagePreviewDiv">
                                            <div class="uploadPicture">
                                                <img src="{{ @$user->tutor->id_card_url }}" alt="" id="id_cardimagePreview">
                                                <a href="javascript:void(0);" class="delete-icon deleteIdCard">
                                                    <span class="icon-delete"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group uploadStuff updateIdCard" style="display: {{ (@$user->tutor->id_card && $ext!='pdf')?'none':'block' }};">
                                            <input name="id_card" type="file" id="uploadId" onchange="showImagePreview($(this))" class="d-none" data-max-size="{{ config('constants.id_card.maxSize') }}" accept="{{ config('constants.id_card.acceptType') }}">
                                            <label for="uploadId" class="d-flex flex-column align-items-center justify-content-center mb-0">
                                                <div class="my-auto text-center">
                                                    <span class="icon-upload"></span>
                                                    <div class="font-sm txt id_card_en showFileName">{{ (@$user->tutor->id_card &&  $ext=='pdf')?str_replace('tutor/id_card/','',@$user->tutor->id_card):__('labels.upload_national_ID') }}</div>
                                                </div>
                                                <p class="mb-0 textGray">{{ __('labels.max_upload_size', ['attribute' => '5MB']) }}</p>
                                            </label>
                                        </div> -->
                                    </div>
                                    <div class="tab-pane fade" id="step1-arabic" role="tabpanel">

                                    </div>
                                </div>
                                <div class="submitBtn">
                                    <button type="submit" id="personalDetailsBtn" class="btn btn-primary btn-block btn-lg ripple-effect mw-300 mx-auto next action-button">{{ __('labels.save_continue') }}</button>
                                </div>
                            </form>
                            {!! JsValidator::formRequest('App\Http\Requests\Tutor\PersonalDetailRequest', '#personalDetailsForm') !!}
                        </fieldset>

                        <fieldset class="boxContent-form position-relative">
                                <div class="blockContent">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="boxContent_subhead font-eb">{{ __('labels.education') }}</h5>
                                        <a href="javascript:void(0);" class="linkPrimary text-uppercase font-eb" onclick="educationModal()">{{ __('labels.add_new_education') }}</a>
                                    </div>
                                    <ul class="list-unstyled mb-0 commonDegree" id="educationList-en">
                                    </ul>
                                </div>
                                <span id="education-certificate-error" class="invalid-feedback" style="display: block;"></span>
                                <div class="blockContent">
                                    <div class="d-flex align-items-center justify-content-between">
                                        <h5 class="boxContent_subhead font-eb">{{ __('labels.certificate') }}</h5>
                                        <a href="javascript:void(0);" class="linkPrimary text-uppercase font-eb" onclick="certificateModal('en')">{{ __('labels.add_new_certificate') }}</a>
                                    </div>
                                    <ul class="list-unstyled mb-0 commonDegree" id="certificateList-en">

                                    </ul>
                                </div>
                            <div class="submitBtn d-flex justify-content-between">
                                <button type="button" class="btn btn-light ripple-effect-dark previous">{{ __('labels.back') }}</button>
                                <button type="button" class="btn btn-primary btn-block btn-lg ripple-effect mw-300 next" onclick="submitEducationDetail($(this))">{{ __('labels.save_continue') }}</button>
                            </div>
                        </fieldset>
                        <fieldset class="boxContent-form position-relative">
                            <form action="{{ route('tutor/professional-details', ['id' => $user->id]) }}" method="POST" id="professionalDetailForm" novolidate>
                                <input type="hidden" value="complete-profile" id="profileType">
                                <div class="tab-content">
                                    <div class="tab-pane fade show active" id="step3-english" role="tabpanel">
                                        <div class="form-group" id="introduction_videoimagePreviewDiv" style="display: {{ (@$user->tutor->introduction_video)?'block':'none' }}">
                                            <div class="uploadPicture">
                                                <video controls style="height: 100%; width:100%;">
                                                    <source src="{{ @$user->tutor->introduction_video_url }}" id="introduction_videovideoPreview" controls>
                                                    Your browser does not support HTML5 video.
                                                </video>
                                                <a href="javascript:void(0);" class="delete-icon deleteIntroductionVideo">
                                                    <span class="icon-delete"></span>
                                                </a>
                                            </div>
                                        </div>
                                        <div class="form-group uploadStuff uploadIntroductionVideo" style="display: {{ (@$user->tutor->introduction_video)?'none':'block' }}">
                                            <input name="introduction_video" type="file" id="introductionVideoId" class="d-none" onchange="showImagePreview($(this))" data-max-size="{{ config('constants.introduction_video.maxSize') }}" accept="{{ config('constants.introduction_video.acceptType') }}">
                                            <input name="introduction_video_old" type="hidden" id="introductionOldVideoId" value="{{@$user->tutor->introduction_video}}">
                                            <label for="introductionVideoId" class="d-flex flex-column align-items-center justify-content-center mb-0">
                                                <div class="my-auto text-center">
                                                    <span class="icon-upload"></span>
                                                    <div class="font-sm txt ">{{ __('labels.upload_a_video') }}</div>
                                                </div>
                                                <p class="mb-0 textGray">{{ __('labels.max_upload_size', ['attribute' => '5MB']) }}</p>
                                            </label>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.experience') }}</label>
                                            <input name="experience" type="number" class="form-control name_ar" min="0" id="experience" dir="rtl" placeholder="{{ __('labels.enter_experience') }}">
                                        </div>
                                        <h5 class="boxContent_subhead font-eb">{{ $education->translateOrDefault()->name }}</h5>
                                        <div class="form-group">
                                            <label class="form-label">{{__('labels.levels')}}</label>
                                            @php $levels = getSubCategory($education->id); @endphp
                                            <select name="levels[]" class="form-select" data-placeholder="{{__('labels.select_levels')}}" multiple id="educationLavel">
                                                <option value=""></option>
                                                @forelse($levels as $level)
                                                <option value="{{ $level->id }}">{{ $level->translateOrDefault()->name }}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                        </div>
                                        <div class="form-group education-grade-div">
                                            <label class="form-label">{{ __('labels.grade') }}</label>
                                            <select name="grades[]" class="form-select" data-placeholder="{{ __('labels.select_grade') }}" multiple id="educationGrade" data-category="{{ $education->id }}">
                                            </select>
                                        </div>
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.subjects') }}</label>
                                            <select name="subjects[]" class="form-select" data-placeholder="{{ __('labels.select_subjects') }}" multiple id="educationSubject">
                                            </select>
                                        </div>
                                        <h5 class="boxContent_subhead font-eb">{{ $generalKnowledge->translateOrDefault()->name }}</h5>
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.subjects') }}</label>
                                            @php $subjects = getSubCategory($generalKnowledge->id); @endphp
                                            <select name="general_knowledge[]" class="form-select" data-placeholder="{{ __('labels.select_general_knowledge') }}" multiple id="generalKnowledge">
                                                <option value=""></option>
                                                @forelse($subjects as $subject)
                                                <option value="{{ $subject->id }}">{{ $subject->translateOrDefault()->name }}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                        </div>
                                        <h5 class="boxContent_subhead font-eb">{{ $language->name }}</h5>
                                        <div class="form-group">
                                            <label class="form-label">{{ __('labels.language') }}</label>
                                            @php $languages = getSubCategory($language->id); @endphp
                                            <select name="languages[]" class="form-select" data-placeholder="{{ __('labels.select_language') }}" multiple id="language">
                                                <option value=""></option>
                                                @forelse($languages as $language)
                                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                                                @empty

                                                @endforelse
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="submitBtn d-flex justify-content-between">
                                    <button type="button" class="btn btn-light ripple-effect-dark previous">{{ __('labels.back') }}</button>
                                    <button type="submit" class="btn btn-primary btn-block btn-lg ripple-effect mw-300" id="professionalDetailBtn">{{ __('labels.save_continue') }}</button>
                                </div>
                            </form>
                            {!! JsValidator::formRequest('App\Http\Requests\Tutor\ProfessionalDetailRequest', '#professionalDetailForm') !!}
                        </fieldset>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@include('frontend.image-cropper-modal')
@include('frontend.tutor.complete-profile.add-education-modal')
@include('frontend.tutor.complete-profile.add-certificate-modal')
@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/complete-profile.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/education.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/certificate.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/image-cropper.js')}}"></script>
<script src="https://maps.googleapis.com/maps/api/js?key={{config('services.google_places_api_key')}}&libraries=places"></script>
<script >
    function editinitialize() {
        var input = document.getElementById('addressPlace');
        var autocomplete = new google.maps.places.Autocomplete(input);
        // autocomplete.setComponentRestrictions({
        //     'country': ['']
        // });
    }
    google.maps.event.addDomListener(window, 'load', editinitialize);
</script>
@endpush

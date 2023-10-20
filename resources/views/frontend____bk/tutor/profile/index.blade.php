@extends('layouts.tutor.app')
@section('title', __('labels.edit_profile'))
@section('content')
<main class="mainContent">
    <div class="editProfilePage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="d-sm-flex align-items-center justify-content-between">
                    <div class="pageTitle__leftSide">
                        <div class="commonBreadcrumb">
                            <nav aria-label="breadcrumb">
                                <ol class="breadcrumb">
                                    <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                                    <li class="breadcrumb-item active" aria-current="page">{{ __('labels.edit_profile') }}</li>
                                </ol>
                            </nav>
                        </div>
                        <h3 class="h-32 pageTitle__title">{{ __('labels.edit_profile') }}</h3>
                    </div>

                </div>
        </section>
        <section class="editProfilePage__inner">
            <div class="container">
                <div class="d-flex align-items-center mb-3">
                    <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
                </div>
                <div class="flexRow d-xl-flex">
                    <div class="column-1">
                        @include('layouts.tutor.side-bar')
                    </div>
                    <div class="column-2">
                        <div class="editProfilePage__Form">
                            <div class="common-tabs mb-3 mb-lg-4">
                                <ul class="nav nav-tabs">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="tab" href="#personalDetails">{{__('labels.personal_details')}}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#educationalDetails">{{ __('labels.education_details') }}</a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="tab" href="#professionalDetails">{{ __('labels.professional_details') }}</a>
                                    </li>
                                </ul>
                            </div>
                            <div class="tab-content">
                                <div class="tab-pane fade show active" id="personalDetails" role="tabpanel">
                                <div class="editProfilePage__personalDetails commonBox">
                                        <div class="editFormSec">
                                            <form action="{{ route('tutor/personal-details', ['id' => $user->id]) }}" method="POST" id="personalDetailsForm" novolidate>
                                                <input type="hidden" id="pageType" value="editProfile">
                                                <div class="profile-language profile-en">
                                                    <div class="imgUpload position-relative mx-auto">
                                                        <img src="{{ $user->profile_image_url }}" id="imagePreview" class="rounded-circle" alt="user">
                                                        <div class="imgUpload-icon">
                                                            <label for="uploadImg">
                                                                <span class="icon-camera"></span>
                                                            </label>
                                                            <input type="file" id="uploadImg" class="d-none" onchange="setImage(this,$(this),'profile_image');" data-width-height="{{ config('constants.profile_image.dimension') }}" data-max-size="{{ config('constants.profile_image.maxSize') }}" data-accept-file="{{ config('constants.profile_image.acceptType') }}" data-preview-id="imagePreview" data-base64-id="uploadImageBase64" accept="{{ config('constants.profile_image.acceptType') }}">
                                                            <input type="hidden" name="profile_image" id="uploadImageBase64" value="">
                                                        </div>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('labels.name_in_english')}}</label>
                                                        <input name="en[name]" type="text" dir="rtl" class="form-control" placeholder="{{__('labels.enter_name')}}" value="{{ $user->translateOrDefault()->name }}" autocomplete="nope" id="name_en">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label d-none">{{__('labels.name_in_arabic')}}</label>
                                                        <input name="ar[name]" type="hidden"  class="form-control" placeholder="{{ __('labels.enter_name')}}" value="{{ $user->{'name:ar'} }}" autocomplete="nope" id="name_ar">
                                                    </div>

                                                    <div class="form-group">
                                                        <label class="form-label">{{__('labels.email_id')}}</label>
                                                        <input name="email" dir="rtl"  type="email" class="form-control" placeholder="{{__('labels.enter_email_id')}}" value="{{ $user->email }}" {{ (Auth::user()->userSocialLogin && Auth::user()->password == null)?'disabled':'' }} autocomplete="nope">
                                                        @if((Auth::user()->userSocialLogin) && Auth::user()->password == null)
                                                        <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                                                        @endif
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('labels.mobile_number')}}</label>
                                                        <input name="phone_number" dir="rtl"  type="text" class="form-control only-number" placeholder="{{__('labels.enter_mobile_number')}}" value="{{ $user->phone_number }}" autocomplete="nope">
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{ __('labels.bio_in_english') }}</label>
                                                        <textarea name="en[bio]" rows="3" dir="rtl"  class="form-control" placeholder="{{ __('labels.enter_bio') }}" id="bio_en">{{ $user->translateOrDefault()->bio }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label d-none">{{ __('labels.bio_in_arabic') }}</label>
                                                        <textarea name="ar[bio]" rows="3" dir="rtl" class="form-control d-none" placeholder="{{__('labels.enter_bio')}}" id="bio_ar">{{ $user->{'bio:ar'} }}</textarea>
                                                    </div>
                                                    <div class="form-group">
                                                        <label class="form-label">{{__('labels.address')}}</label>
                                                        <input name="address" type="text" dir="rtl" class="form-control" id="addressPlace" placeholder="{{__('labels.enter_address')}}" value="{{ $user->address }}" autocomplete="nope">
                                                    </div>
                                                    @php $ext = pathinfo(@$user->tutor->id_card, PATHINFO_EXTENSION); @endphp
                                                    <!-- <div class="form-group" style="display: {{ (@$user->tutor->id_card && $ext!='pdf')?'block':'none' }}" id="id_cardimagePreviewDiv">
                                                        <div class="uploadPicture">
                                                            <img src="{{ @$user->tutor->id_card_url }}" alt="" id="id_cardimagePreview">
                                                            <a href="#" class="delete-icon deleteIdCard">
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
                                                    

                                                     <div class="form-group">
                                                        <label class="form-label">{{ __('labels.is_available') }}</label>
                                                        <select name="is_available" class="form-select"
                                                            id="is_available" dir="rtl">
                                                            <option value="1" @if($user->is_available  == 1) selected @endif>{{ __('labels.active') }}</option>
                                                            <option value="0" @if($user->is_available  == 0) selected @endif>{{ __('labels.inactive') }}</option>
                                                        </select>
                                                    </div>

                                                </div>
                                                <div class="profile-language profile-ar" style="display: none;">

                                                </div>
                                                <div class="btn-row">
                                                    <button type="button" id="personalDetailsBtn" class="btn btn-primary btn-block btn-lg mw-300 m-auto ripple-effect">{{ __('labels.update') }}</button>
                                                </div>
                                            </form>
                                            {!! JsValidator::formRequest('App\Http\Requests\Tutor\PersonalDetailRequest', '#personalDetailsForm') !!}
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="educationalDetails" role="tabpanel">
                                    <div class="boxContent">
                                        <div class="blockContent">
                                            <div class="profile-language profile-en">
                                                <div class="blockContent__list common-shadow bg-white">
                                                    <div class="blockContent__inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="boxContent_subhead font-eb mb-0">{{ __('labels.education') }}</h5>
                                                            <a href="#" class="linkPrimary text-uppercase font-eb" onclick="educationModal('en')">{{ __('labels.add_new_education') }}</a>
                                                        </div>
                                                        <ul class="list-unstyled mb-0 commonDegree" id="educationList-en">
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="blockContent__list common-shadow bg-white">
                                                    <div class="blockContent__inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="boxContent_subhead font-eb mb-0">{{ __('labels.certificate') }}</h5>
                                                            <a href="#" class="linkPrimary text-uppercase font-eb" onclick="certificateModal('en')">{{ __('labels.add_new_certificate') }}</a>
                                                        </div>
                                                        <ul class="list-unstyled mb-0 commonDegree" id="certificateList-en">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="profile-language profile-ar" style="display: none;">
                                                <div class="blockContent__list common-shadow bg-white">
                                                    <div class="blockContent__inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="boxContent_subhead font-eb mb-0">{{ __('labels.education') }}</h5>
                                                            <a href="#" class="linkPrimary text-uppercase font-eb" onclick="educationModal('ar')">{{ __('labels.add_new_education') }}</a>
                                                        </div>
                                                        <ul class="list-unstyled mb-0 commonDegree" id="educationList-ar">
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="blockContent__list common-shadow bg-white">
                                                    <div class="blockContent__inner">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <h5 class="boxContent_subhead font-eb mb-0">{{ __('labels.certificate') }}</h5>
                                                            <a href="#" class="linkPrimary text-uppercase font-eb" onclick="certificateModal('ar')">{{ __('labels.add_new_certificate') }}</a>
                                                        </div>
                                                        <ul class="list-unstyled mb-0 commonDegree" id="certificateList-ar">
                                                        </ul>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="tab-pane fade" id="professionalDetails" role="tabpanel">
                                    <div class="editProfilePage__professionalDetails commonBox">
                                        <div class="editFormSec">
                                            <form action="{{ route('tutor/professional-details', ['id' => $user->id]) }}" method="POST" id="professionalDetailForm" novolidate>
                                                <input type="hidden" value="edit-profile" id="profileType">
                                                <div class="form-group" id="introduction_videoimagePreviewDiv" style="display: {{ (@$user->tutor->introduction_video)?'block':'none' }}">
                                                    <div class="uploadPicture">
                                                        <video controls style="height: 100%; width:100%;">
                                                            <source src="{{ @$user->tutor->introduction_video_url }}" id="introduction_videovideoPreview" controls>
                                                            Your browser does not support HTML5 video.
                                                        </video>
                                                        <a href="#" class="delete-icon deleteIntroductionVideo">
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
                                                        <p class="mb-0 textGray"> {{ __('labels.max_upload_size', ["attribute" => '5MB']) }}</p>
                                                    </label>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.experience') }}</label>
                                                    <input name="experience" type="number" class="form-control name_ar" min="0" id="experience" placeholder="{{ __('labels.enter_experience') }}">
                                                </div>
                                                <h5 class="boxContent_subhead font-eb">{{ __('labels.education')}}</h5>
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.levels')}}</label>
                                                    @php $levels = getSubCategory($education->id); @endphp
                                                    <select name="levels[]" class="form-select" data-placeholder="{{ __('labels.select_level')}}" multiple id="educationLavel">
                                                        <option value=""></option>
                                                        @forelse($levels as $level)
                                                        <option value="{{ $level->id }}">{{ $level->name }}</option>
                                                        @empty

                                                        @endforelse
                                                    </select>
                                                </div>
                                                <div class="form-group"  id="grade">
                                                    <label class="form-label">{{ __('labels.grade') }}</label>
                                                    <select name="grades[]" class="form-select" data-placeholder="{{ __('labels.select_grade') }}" multiple id="educationGrade" data-category="{{ $education->id }}">
                                                    </select>
                                                </div>
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.subjects') }}</label>
                                                    <select name="subjects[]" class="form-select" data-placeholder="{{ __('labels.select_subjects') }}" multiple id="educationSubject">
                                                    </select>
                                                </div>
                                                <h5 class="boxContent_subhead font-eb">{{ __('labels.general_knowledge') }}</h5>
                                                <div class="form-group">
                                                    <label class="form-label">{{ __('labels.subjects') }}</label>
                                                    @php $subjects = getSubCategory($generalKnowledge->id); @endphp
                                                    <select name="general_knowledge[]" class="form-select" data-placeholder="{{ __('labels.select_general_knowledge') }}" multiple id="generalKnowledge">
                                                        <option value=""></option>
                                                        @forelse($subjects as $subject)
                                                        <option value="{{ $subject->id }}">{{ $subject->name }}</option>
                                                        @empty

                                                        @endforelse
                                                    </select>
                                                </div>
                                                <h5 class="boxContent_subhead font-eb">{{ __('labels.language') }}</h5>
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
                                                <div class="btn-row">
                                                    <button type="submit" class="btn btn-primary btn-block btn-lg mw-300 m-auto ripple-effect">{{ __('labels.update') }}</button>
                                                </div>
                                            </form>
                                            {!! JsValidator::formRequest('App\Http\Requests\Tutor\ProfessionalDetailRequest', '#professionalDetailForm') !!}
                                        </div>
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

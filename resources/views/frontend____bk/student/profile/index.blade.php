@extends('layouts.student.app')
@section('title',__('labels.edit_profile'))
@section('content')
<main class="mainContent">
    <div class="editProfilePage commonPad bg-green">
    <section class="pageTitle">
        <div class="container">
            <div class="commonBreadcrumb">
                <nav aria-label="breadcrumb">
                <ol class="breadcrumb">
                    <li class="breadcrumb-item"><a href="{{route('student/dashboard')}}">{{ __('labels.home') }}</a></li>
                    <li class="breadcrumb-item active" aria-current="page">{{__('labels.edit_profile')}}</li>
                </ol>
                </nav>
            </div>
            <h3 class="h-32 pageTitle__title">{{__('labels.edit_profile')}}</h3>
        </div>
    </section>
    <section class="editProfilePage__inner">
        <div class="container">
            <div class="d-flex align-items-center mb-3">
                <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
            </div>
            <div class="flexRow d-xl-flex">
                <div class="column-1">
                @include('layouts.student.side-bar')
                </div>
                <div class="column-2">
                <div class="editProfilePage__Form commonBox">
                    <div class="editFormSec">
                    <form action="{{ route('student.profile.update', ['id' => $user->id]) }}" method="POST" id="updateProfileForm" novolidate>
                            <div class="imgUpload position-relative mx-auto">
                            <img src="{{ $user->profile_image_url }}" id="imagePreview" class="rounded-circle" alt="user">

                            <div class="imgUpload-icon">
                                <label for="uploadImg">
                                    <span class="icon-camera"></span>
                                </label>
                                <input type="file" id="uploadImg" class="d-none" onchange="setImage(this,$(this),'profile_image');" data-width-height="{{ config('constants.profile_image.dimension') }}" data-max-size="{{ config('constants.profile_image.maxSize') }}" data-accept-file="{{ config('constants.profile_image.acceptType') }}" data-preview-id="imagePreview" data-base64-id="uploadImageBase64" accept="image/png,image/jpg,image/jpeg">
                                <input type="hidden" name="profile_image" id="uploadImageBase64" value="">
                            </div>
                            </div>
                            <div class="form-group">
                            <label class="form-label">{{ __('labels.name')}}</label>
                            <input name="en[name]" type="text" class="form-control" placeholder="{{__('labels.enter_name')}}" dir="rtl" value="{{ @$user->translateOrDefault()->name }}" >

                            </div>
                            <div class="form-group">
                            <label class="form-label">{{__('labels.email_id')}}</label>
                            <input name="email" type="email" class="form-control" placeholder="{{__('labels.enter_email_id')}}" dir="rtl" value="{{ $user->email }}" {{ (Auth::user()->userSocialLogin && Auth::user()->password == null)?'disabled':'' }} autocomplete="nope">
                            @if((Auth::user()->userSocialLogin) && Auth::user()->password == null)
                                <input type="hidden" name="email" value="{{ Auth::user()->email }}">
                            @endif
                            </div>
                            <div class="form-group">
                            <label class="form-label">{{__('labels.gender') }}</label>
                            <input name="gender" type="text" class="form-control" placeholder="" value="{{ $user->gender }}" dir="rtl" disabled>
                            </div>
                            <div class="form-group">
                            <label class="form-label">{{ __('labels.mobile_number') }}</label>
                            <input name="phone_number" type="text" class="form-control" placeholder="{{__('labels.enter_mobile_number')}}" dir="rtl" value="{{ $user->phone_number }}">
                            </div>
                            <div class="form-group">
                            <label class="form-label">{{ __('labels.bio') }}</label>
                            <textarea name="en[bio]" rows="3" class="form-control" placeholder="{{__('labels.enter_bio')}}" dir="rtl">{{ $user->translateOrDefault()->bio }}</textarea>
                            </div>
                            <h5 class="boxContent_subhead font-eb">{{ __('labels.education') }}</h5>
                            <div class="form-group">
                            <label class="form-label">{{ __('labels.levels') }}</label>
                            @php $levels = getSubCategory($education->id); @endphp
                            <select name="levels[]" class="form-select" data-placeholder="{{__('labels.select_level')}}" multiple id="educationLavel">
                                <option value=""></option>
                                @forelse($levels as $level)
                                    <option value="{{ $level->id }}">{{ $level->name }}</option>
                                @empty

                                @endforelse
                            </select>
                            </div>
                            <div class="form-group">
                            <label class="form-label">{{ __('labels.grade') }}</label>
                            <select name="grades[]" class="form-select" data-placeholder="{{ __('labels.select_grade') }}" multiple id="educationGrade" data-category="{{ $education->id }}">
                                                    </select>
                            </div>
                            <div class="form-group">
                            <label class="form-label">{{ __('labels.subjects') }}</label>
                            <select name="subjects[]" class="form-select" data-placeholder="{{ __('labels.select_subjects') }}" multiple id="educationSubject">
                                </select>

                            </div>
                            <h5 class="boxContent_subhead font-eb">{{__('labels.general_knowledge')}}</h5>
                            <div class="form-group">
                            <label class="form-label">{{ __('labels.subjects') }}</label>
                            @php $subjects = getSubCategory($generalKnowledge->id); @endphp
                            <select name="general_knowledge[]" class="form-select" data-placeholder="{{ __('labels.select_general_knowledge') }}" multiple id="generalKnowledge">
                                <option value=""></option>
                                @forelse($subjects as $subject)
                                <option value="{{ $subject->id }}">{{ @$subject->translateOrDefault()->name }}</option>
                                @empty

                                @endforelse
                            </select>
                            </div>
                            <h5 class="boxContent_subhead font-eb">{{ __('labels.language') }}</h5>
                            <div class="form-group">
                            <label class="form-label">{{ __('labels.language') }}</label>
                            @php $languages = getSubCategory($language->id); @endphp
                            <select name="languages[]" class="form-select"
                             data-placeholder="{{ __('labels.select_language') }}" multiple id="language">
                                <option value=""></option>
                                @forelse($languages as $language)
                                <option value="{{ $language->id }}">{{ $language->name }}</option>
                                @empty

                                @endforelse
                            </select>
                            </div>
                            <div class="btn-row">
                                <button type="submit" id="updateProfileBtn" class="btn btn-primary btn-block btn-lg mw-300 m-auto ripple-effect">{{ __('labels.update') }}</button>
                            </div>
                        </form>
                        {!! JsValidator::formRequest('App\Http\Requests\Student\ProfileRequest', '#updateProfileForm') !!}

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
<script type="text/javascript" src="{{asset('assets/js/frontend/image-cropper.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/profile.js')}}"></script>
@endpush

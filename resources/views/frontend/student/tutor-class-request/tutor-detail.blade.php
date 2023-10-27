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

                                        <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a>

                                        </li>

                                        <li class="breadcrumb-item active" aria-current="page">

                                            {{ __('labels.edit_profile') }}</li>

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

                        <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span

                                class="icon-menu"></span></button>

                    </div>

                    <div class="flexRow d-xl-flex">

                        <div class="column-1">

                            @include('layouts.student.side-bar')

                        </div>

                        <div class="column-2">

                            <div class="editProfilePage__Form">

                                <div class="tab-content">

                                    <div class="tab-pane fade show active" id="personalDetails" role="tabpanel">

                                        <div class="editProfilePage__personalDetails commonBox">

                                            <div class="editFormSec">

                                                <div class="profile-language profile-en">

                                                    <div class="imgUpload position-relative mx-auto">

                                                        <img src="{{ $user->profile_image_url }}" id="imagePreview"

                                                            class="rounded-circle" alt="user">

                                                        <div class="imgUpload-icon">

                                                            <input type="file" id="uploadImg" class="d-none"

                                                                onchange="setImage(this,$(this),'profile_image');"

                                                                data-width-height="{{ config('constants.profile_image.dimension') }}"

                                                                data-max-size="{{ config('constants.profile_image.maxSize') }}"

                                                                data-accept-file="{{ config('constants.profile_image.acceptType') }}"

                                                                data-preview-id="imagePreview"

                                                                data-base64-id="uploadImageBase64"

                                                                accept="{{ config('constants.profile_image.acceptType') }}">

                                                            <input type="hidden" name="profile_image"

                                                                id="uploadImageBase64" value="" readonly="">

                                                        </div>

                                                    </div>

                                                    

                                                    <div class="form-group">

                                                        <label class="form-label">{{ __('labels.name_in_english') }}</label>

                                                        <input name="en[name]" type="text" class="form-control"

                                                            placeholder="{{ __('labels.enter_name') }}"

                                                            value="{{ $user->translateOrDefault()->name }}"

                                                            autocomplete="nope" readonly="">

                                                    </div>

                                                    <div class="form-group">

                                                        <label class="form-label">{{ __('labels.name_in_arabic') }}</label>

                                                        <input name="ar[name]" type="text" dir="rtl"

                                                            class="form-control"

                                                            placeholder="{{ __('labels.enter_name') }}"

                                                            value="{{ $user->{'name:ar'} }}" autocomplete="nope" readonly="">

                                                    </div>
                                     
                                                    <div class="form-group">

                                                        <label class="form-label">{{ __('labels.bio_in_english') }}</label>

                                                        <textarea name="en[bio]" rows="3" class="form-control" placeholder="{{ __('labels.enter_bio') }}" readonly="">{{ $user->translateOrDefault()->bio }}</textarea>

                                                    </div>

                                                    <div class="form-group">

                                                        <label class="form-label">{{ __('labels.bio_in_arabic') }}</label>

                                                        <textarea name="ar[bio]" rows="3" dir="rtl" class="form-control" placeholder="{{ __('labels.enter_bio') }}" readonly="">{{ $user->{'bio:ar'} }}</textarea>

                                                    </div>

                                                    <div class="form-group">

                                                        <label class="form-label">{{ __('labels.address') }}</label>

                                                        <input name="address" type="text" class="form-control"

                                                            id="addressPlace"

                                                            placeholder="{{ __('labels.enter_address') }}"

                                                            value="{{ $user->address }}" autocomplete="nope" readonly="">

                                                    </div>

                                                    @php $ext = pathinfo(@$user->tutor->id_card, PATHINFO_EXTENSION); @endphp

                                                </div>

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

    <script type="text/javascript" src="{{ asset('assets/js/frontend/tutor/complete-profile.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/frontend/tutor/education.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/frontend/tutor/certificate.js') }}"></script>

    <script type="text/javascript" src="{{ asset('assets/js/frontend/image-cropper.js') }}"></script>

    <script

        src="https://maps.googleapis.com/maps/api/js?key={{ config('services.google_places_api_key') }}&libraries=places">

    </script>

    <script>

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


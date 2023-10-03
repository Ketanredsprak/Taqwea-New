<!-- Education modal -->
<div class="modal fade" id="educationModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--education">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{ __('labels.education') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <div class="boxContent-nav text-center">
                <ul class="nav nav-pills d-inline-flex">
                    <li class="nav-item">
                        <a class="nav-link active"  data-lang="en" data-toggle="pill" href="#step1-english-education">English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-lang="ar" data-toggle="pill" href="#step1-arabic-education">Arabic(عربى)</a>
                    </li>
                </ul>
            </div> --}}
            <form action="{{ url('tutor/educations') }}" id="addEducationForm" novalidate>
                <input type="hidden" name="language" value="" />
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="step1-english-education" role="tabpanel">
                        <div class="modal-body">
                            <div class="form-group" style="display: none;" id="education_certificateimagePreviewDiv">
                                <div class="uploadPicture">
                                    <img src="" alt="" id="education_certificateimagePreview">
                                    <a href="javascript:void(0);" class="delete-icon deleteEducationCertificate">
                                        <span class="icon-delete"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group uploadStuff uploadEducationCertificate">
                                <input name="education_certificate" type="file" id="uploadDegree" class="d-none" onchange="showImagePreview($(this))" data-max-size="{{ config('constants.education_document.maxSize') }}" accept="{{ config('constants.education_document.acceptType') }}">
                                <label for="uploadDegree" class="d-flex flex-column align-items-center justify-content-center mb-0">
                                    <div class="my-auto text-center">
                                        <span class="icon-upload"></span>
                                        <div class="font-sm txt showFileName">{{ __('labels.upload_education_degree') }}</div>
                                    </div>
                                    <p class="mb-0 textGray">{{ __('labels.max_upload_size', ['attribute' => '5MB']) }}</p>
                                </label>
                            </div>
                            <div class="form-group">
                                <label class="form-label">{{ __('labels.degree_name') }}</label>
                                <input name="en[degree]" type="text" class="form-control" id="degree_en" dir="rtl" placeholder="{{ __('labels.enter_degree_name') }}">
                            </div>
                            <div class="form-group mb-0">
                                <label class="form-label">{{ __('labels.university_name') }}</label>
                                <input name="en[university]" type="text" class="form-control" id="university_en" dir="rtl" placeholder="{{ __('labels.enter_university_name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="step1-arabic-education" role="tabpane1">
                        <div class="modal-body">

                            <div class="form-group">
                                <label class="form-label">{{ __('labels.degree_name') }}</label>
                                <input name="ar[degree]" dir="rtl" type="text" class="form-control" id="degree_ar" placeholder="{{ __('labels.enter_degree_name') }}">
                            </div>
                            <div class="form-group mb-0">
                                <label class="form-label">{{ __('labels.university_name') }}</label>
                                <input name="ar[university]" dir="rtl" type="text" class="form-control" id="university_ar" placeholder="{{ __('labels.enter_university_name') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="submit" class="btn btn-primary btn-lg w-100 ripple-effect" id="addEducationBtn">{{ __('labels.add') }}</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Tutor\AddEducationRequest', '#addEducationForm') !!}
        </div>
    </div>
</div>

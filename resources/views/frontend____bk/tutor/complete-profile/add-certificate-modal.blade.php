<div class="modal fade" id="certificateModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--education">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{ __('labels.certificate') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            {{-- <div class="boxContent-nav text-center">
                <ul class="nav nav-pills d-inline-flex">
                    <li class="nav-item">
                        <a class="nav-link active"  data-lang="en" data-toggle="pill" href="#step1-english-certificate">English</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-lang="ar" data-toggle="pill" href="#step1-arabic-certificate">Arabic(عربى)</a>
                    </li>
                </ul>
            </div> --}}
            <form action="{{ url('tutor/certificates') }}" id="addCertificateForm" method="post" novalidate>
                <input type="hidden" name="language" value="" />
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="step1-english-certificate" role="tabpanel">
                        <div class="modal-body">
                            <div class="form-group" style="display: none;" id="certificateimagePreviewDiv">
                                <div class="uploadPicture">
                                    <img src="" alt="" id="certificateimagePreview">
                                    <a href="javascript:void(0);" class="delete-icon deleteIdCertificate">
                                        <span class="icon-delete"></span>
                                    </a>
                                </div>
                            </div>
                            <div class="form-group uploadStuff uploadCertificate">
                                <input name="certificate" type="file" id="uploadCertificate" class="d-none" onchange="showImagePreview($(this))" data-max-size="{{ config('constants.education_document.maxSize') }}" accept="{{ config('constants.education_document.acceptType') }}">
                                <label for="uploadCertificate" class="d-flex flex-column align-items-center justify-content-center mb-0">
                                    <div class="my-auto text-center">
                                        <span class="icon-upload"></span>
                                        <div class="font-sm txt showFileName">{{ __('labels.upload_cetificate') }}</div>
                                    </div>
                                    <p class="mb-0 textGray">{{ __('labels.max_upload_size', ['attribute' => '5MB']) }}</p>
                                </label>
                            </div>
                            <div class="form-group mb-0">
                                <label class="form-label">{{ __('labels.certificate_name') }}</label>
                                <input name="en[certificate_name]" type="text" class="form-control" id="certificate_name_en" dir="rtl" placeholder="{{ __('labels.enter_certificate_name') }}">
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="step1-arabic-certificate" role="tabpanel">
                        <div class="modal-body">
                            <div class="form-group mb-0">
                                <label class="form-label">{{ __('labels.certificate_name') }}</label>
                                <input name="ar[certificate_name]" dir="rtl" type="text" class="form-control" id="certificate_name_ar" placeholder="{{ __('labels.enter_certificate_name') }}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="submit" class="btn btn-primary btn-lg w-100 ripple-effect" id="addCertificateBtn">{{ __('labels.add') }}</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Tutor\AddCertificateRequest', '#addCertificateForm') !!}
        </div>
    </div>
</div>

    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit FAQ</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{route('faqs.update', ['faq' => $faq->id])}}" class="form-validate is-alter" method="POST" id="edit-faq-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    @method('PATCH')
                    <div class="row gy-4">
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Question in English</label>
                                <div class="form-control-wrap">
                                    <input type="hidden" class="form-control" id="faqId" name="id" value="{{$faq->id}}">
                                    <input type="text" class="form-control" placeholder="Question" name="en[question]" value="{{$faq->translate('en')->question}}">
                                </div>
                                <label class="form-label">Answer in English</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control content" placeholder="Answer" id="edit_en_content" name="en[content]">{{($faq->translate('en')->content)}}</textarea>
                                </div>

                            </div>
                            <!-- </div>
                        <div class="col-sm-12"> -->
                            <div class="form-group">
                                <label class="form-label">Question in Arabic</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control" dir="rtl" placeholder="Question" name="ar[question]" value="{{$faq->translate('ar')->question}}">
                                </div>
                                <label class="form-label">Answer in Arabic</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control content" dir="rtl" placeholder="Answer" id="edit_ar_content" name="ar[content]">{{($faq->translate('ar')->content)}}</textarea>
                                </div>
                            </div>
                            <!-- </div>

                        <div class="col-sm-12"> -->
                            <div class="form-group" style="display: {{ ($faq->faq_file ?'block':'none')}}" id="faq_fileimagePreviewDiv">
                                <input type="hidden" id="old_images" name="old_images" value="{{$faq ? $faq->faq_file : ''}}">
                                <div class="uploadPicture">
                                    <img src="{{ $faq->faq_file ? $faq->faq_file_url:'' }}" alt="" id="faq_fileimagePreview">
                                    <video controls style="height: 100%; width:100%;">
                                        <source src="" id="videoPreview" controls>
                                        Your browser does not support HTML5 video.
                                    </video>
                                    <a href="javascript:void(0);" class="delete-icon deleteFaqImage">
                                        <span class="icon ni ni-trash"></span>
                                    </a>
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="col-sm-12"> -->
                            <div class="form-group" style="display: {{ $faq->faq_file ? 'none':'block' }};" id="faqAddImageDiv">
                                <div class="uploadStuff">
                                    <input type="file" name="faq_file" id="uploadId" aria-describedby="uploadId-error" onchange="showImagePreview($(this))" data-max-size="{{ config('constants.faq_file.maxSize') }}" accept="{{ config('constants.faq_file.acceptType') }}" aria-describedby="categorySelect-error">
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
                    <div class="col-sm-12">
                        <div class="mt-4 text-center">
                            <button type="button" id="button-edit-faq" class="btn btn-lg btn-primary">Update</button>
                        </div>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\FaqRequest','#edit-faq-form') !!}
            </div>
        </div>
    </div>
<script>
    $('input[type="file"]').change(function(e) {
        var imgName = e.target.files[0].name;
        $('#preImageName').text(imgName);
    });
  
</script>
<script src="{{asset('assets/js/admin/faqs/faq.js')}}"></script>
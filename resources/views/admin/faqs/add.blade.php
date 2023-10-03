    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Add FAQ</h5>
                <a href="" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{route('faqs.store')}}" method="POST" id="add-faq-form" enctype="multipart/form-data">
                    {{csrf_field()}}
                    <div class="row gy-4">
                        @foreach (config('translatable.locales') as $locale)
                        <div class="col-sm-12">
                            <div class="form-group">
                                <label class="form-label">Question in {{($locale == 'en' ? "English" : ($locale == 'ar' ? "Arabic" : "" ) )}}</label>
                                <div class="form-control-wrap">
                                    <input type="text" class="form-control"  @if($locale == 'ar') dir="rtl" @endif  placeholder="Question" name="{{$locale}}[question]">
                                </div>
                            </div>
                            <!-- </div> -->
                            <!-- <div class="col-sm-12"> -->
                            <div class="form-group">
                                <label class="form-label">Answer in {{($locale == 'en' ? "English" : ($locale == 'ar' ? "Arabic" : "" ) )}}</label>
                                <div class="form-control-wrap">
                                    <textarea class="form-control answer" @if($locale == 'ar') dir="rtl" @endif id="{{$locale}}_content" placeholder="Answer" name="{{$locale}}[content]"></textarea>
                                </div>
                            </div>
                            <!-- </div> -->
                            @endforeach
                            <!-- <div class="col-sm-12"> -->
                            <div class="form-group" style="display: {{ ($faq?'block':'none')}}" id="faq_fileimagePreviewDiv">
                                <div class="uploadPicture">
                                    <img src="{{ $faq ? $faq->faq_file_url:'' }}" alt="" id="faq_fileimagePreview">
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
                            <div class="form-group" style="display: {{ $faq ? 'none':'block' }};" id="faqAddImageDiv">
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
                            <button type="button" id="button-faq" class="btn btn-lg btn-primary">Add</button>
                        </div>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\FaqRequest','#add-faq-form') !!}
            </div>
        </div>
    </div>
<script >
    $('input[type="file"]').change(function(e) {
        var imgName = e.target.files[0].name;
        $('#preImageName').text(imgName);
    });
</script>
<script src="{{asset('assets/js/admin/faqs/faq.js')}}"></script>
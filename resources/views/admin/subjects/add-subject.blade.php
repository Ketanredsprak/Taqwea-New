<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{ $subject ? 'Update' : 'Add' }} Subject</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
        </div>
        <div class="modal-body">
            <form enctype="multipart/form-data" method="{{ $subject ? 'PUT' : 'POST' }}" id="subject-frm"
                action="{{ $subject ? route('subjects.update', $subject->id) : route('subjects.store') }}"
                class="form-validate is-alter">
                {{ csrf_field() }}
                <input type="hidden" id="subject-id" name="id" value="{{ $subject ? $subject->id : null }}" />
                <div class="col-12">
                    <div class="form-group">
                        <div class="upload_photo mb-2 mb-md-3 mx-auto text-center">
                            <div class="img-box">
                                <img src="{{ $subject ? $subject->subject_icon_url : null }}" alt="Tutor-Profile"
                                    class="img-fluid" id="imagePreview">
                            </div>
                            <label class="mb-0 ripple-effect" for="uploadImage">
                                <input type="file" id="uploadImage" onchange="setImage(this,$(this),'subject_icon');"
                                    data-width-height="{{ config('constants.profile_image.dimension') }}"
                                    data-max-size="{{ config('constants.profile_image.maxSize') }}"
                                    data-accept-file="{{ config('constants.profile_image.acceptType') }}"
                                    data-preview-id="imagePreview" data-base64-id="uploadImageBase64"
                                    accept="{{ config('constants.profile_image.acceptType') }}">
                                <input type="hidden" name="subject_icon" id="uploadImageBase64" value="">
                                <em class="icon ni ni-pen2"></em>
                            </label>
                        </div>
                    </div>
                </div>

                <div class="row gy-4">
                    <div class="col-md-12">
                        @foreach (config('translatable.locales') as $locale)
                            <div class="form-group">
                                <label class="form-label">Subject Name({{ $locale }})</label>
                                <input type="text" name="{{ $locale }}[subject_name]"
                                    value="{{ $subject ? $subject->translate($locale)->subject_name : '' }}"
                                    placeholder="subject({{ $locale }})"
                                    class="form-control rounded-0 shadow-none required" required>
                            </div>
                        @endforeach
                    </div>

                </div>
                <div class="mt-4 text-center">
                    <button type="submit" id="subject-btn"
                        class="btn btn-lg btn-primary">{{ $subject ? 'Update' : 'Add' }} Subject</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Admin\AddSubjectRequest', '#subject-frm') !!}
        </div>
    </div>
</div>

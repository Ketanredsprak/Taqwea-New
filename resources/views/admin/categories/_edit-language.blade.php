<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">{{$category ? "Update" : 'Add'}} Language</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
        </div>
        <div class="modal-body">
            <form method="{{ $category ? 'PUT' : 'POST' }}" id="language-frm" action="{{ $category ? route('categories.update', $category->id) : route('categories.store') }}" class="form-validate is-alter">
                {{csrf_field()}}
                <input type="hidden" name="parent_id" value="{{$parent->id}}" />
                <input type="hidden" id="category-id" name="category" value="{{$category ? $category->id : null}}" />
                <div class="col-12">
                    <div class="form-group">
                        <div class="upload_photo mb-2 mb-md-3 mx-auto text-center">
                            <div class="img-box">
                                <img src="{{ $category ? $category->icon_url : null }}" alt="Language-Icon"
                                    class="img-fluid" id="imagePreview">
                            </div>
                            <label class="mb-0 ripple-effect" for="uploadImage">
                                <input type="file" id="uploadImage" onchange="setImage(this,$(this),'icon');"
                                    data-width-height="{{ config('constants.profile_image.dimension') }}"
                                    data-max-size="{{ config('constants.profile_image.maxSize') }}"
                                    data-accept-file="{{ config('constants.profile_image.acceptType') }}"
                                    data-preview-id="imagePreview" data-base64-id="uploadImageBase64"
                                    accept="{{ config('constants.profile_image.acceptType') }}">
                                <input type="hidden" name="icon" id="uploadImageBase64" value="">
                                <em class="icon ni ni-pen2"></em>
                            </label>
                        </div>
                    </div>
                </div>
                <div class="row gy-4">
                  <div class="col-md-12">
                    @foreach (config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label class="form-label">Name({{$locale}})</label>
                            <input type="text" dir="{{ ($locale == 'ar') ? 'rtl' : 'ltr'}}" name="{{$locale}}[name]" value="{{$category ? $category->translate($locale)->name : ''}}" placeholder="Category({{$locale}})" class="form-control rounded-0 shadow-none required" required>
                        </div>
                    @endforeach
                </div><!-- .col -->

                </div>
                <div class="mt-4 text-center">
                    <button type="submit" id="language-btn" class="btn btn-lg btn-primary">{{$category ? "Update" : 'Add'}} Language</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateCategoryRequest','#language-frm') !!}
        </div>
    </div>
</div>
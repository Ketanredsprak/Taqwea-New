  <!-- edit student modal -->

  <div class="modal-dialog" role="document">
      <div class="modal-content">
          <div class="modal-header">
              <h5 class="modal-title">Edit student</h5>
              <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                  <em class="icon ni ni-cross"></em>
              </a>
          </div>
          <div class="modal-body">
              <form action="{{route('students.update', $result->id)}}" method="PUT" enctype="multipart/form-data" id="student-edit-form" class="form-validate is-alter">
                  <div class="row gy-4">
                      <div class="col-12">
                          <div class="form-group">
                              <div class="upload_photo mb-2 mb-md-3 mx-auto text-center">
                                  <div class="img-box">
                                      <img src="{{ $result->profile_image_url }}" alt="Tutor-Profile" class="img-fluid" id="imagePreview">
                                  </div>
                                  <label class="mb-0 ripple-effect" for="uploadImage">
                                      <input type="file" id="uploadImage" onchange="setImage(this,$(this),'profile_image');" data-width-height="{{ config('constants.profile_image.dimension') }}" data-max-size="{{ config('constants.profile_image.maxSize') }}" data-accept-file="{{ config('constants.profile_image.acceptType') }}" data-preview-id="imagePreview" data-base64-id="uploadImageBase64" accept="{{ config('constants.profile_image.acceptType') }}">
                                      <input type="hidden" name="profile_image" id="uploadImageBase64" value="">
                                      <em class="icon ni ni-pen2"></em>
                                  </label>
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Name</label>
                              <div class="form-control-wrap">
                                  <input type="text" placeholder="Name" data-msg="Required" name="name" value="{{$result->name}}" class="form-control rounded-0 shadow-none required">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Email Address</label>
                              <div class="form-control-wrap">
                                  <input type="email" placeholder="Email Address" name="email" data-msg="Required" data-msg-email="Wrong Email" value="{{$result->email}}" class="form-control rounded-0 shadow-none required email">
                              </div>
                          </div>
                      </div><!-- .col -->
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Gender</label>
                              <div class="form-control-wrap">
                                  {{ ($result->gender) ? ucfirst($result->gender) : '-'}}
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Phone Number</label>
                              <div class="form-control-wrap">
                                  <input type="text" placeholder="Phone Number" name="phone_number" value="{{$result->phone_number}}" class="form-control rounded-0 shadow-none">
                              </div>
                          </div>
                      </div>
                      <div class="col-md-6">
                          <div class="form-group">
                              <label class="form-label">Date of Registration</label>
                              <div class="form-control-wrap">
                                  <div class="form-icon form-icon-right">
                                      <em class="icon ni ni-calendar-alt"></em>
                                  </div>
                                  <input type="text" name="created_at" value="{{$result->created_at->format('d/m/y')}}" class="form-control date-picker rounded-0 shadow-none" placeholder="Date of Registration" disabled="">
                              </div>
                          </div>
                      </div><!-- .col -->
                      <div class="col-md-12">
                          <div class="form-group">
                              <label class="form-label">About Me</label>
                              <div class="form-control-wrap">
                                  <textarea name="bio" placeholder="About Me" class="form-control rounded-0 shadow-none">{{$result->bio}}</textarea>
                              </div>
                          </div>
                      </div>
                  </div>
                  <div class="mt-4 text-center">
                      <button type="submit" id="student-edit-btn" class="btn btn-lg btn-primary">Update</button>
                  </div>
              </form>
          </div>
      </div>
  </div>
  {!! JsValidator::formRequest('App\Http\Requests\Admin\StudentEditRequest','#student-edit-form') !!}
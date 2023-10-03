<div class="modal fade" tabindex="-1" role="dialog" id="updatePassword">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            <div class="modal-body modal-body-md">
                <h5 class="title text-center mb-3">Update Password</h5>
                <form action="{{URL::to('/admin/changePassword')}}" method="post" id="user-change-password-form">
                    {{csrf_field()}}
                    <input type="hidden" class="form-control form-control-lg" name="id" id="id" value="">
                    <input type="hidden" class="form-control form-control-lg" name="email" id="email" value="">
                    <div class="form-group">
                        <div class="form-group passwordInfo">
                            <h6>Password contains:</h6>
                            <p class="done"><em class="icon ni ni-check"></em> A capital letter & a small letter.</p>
                            <p class="done"><em class="icon ni ni-check"></em> A special character & a number.</p>
                            <p><em class="icon ni ni-check"></em> 8-32 characters long.</p>
                        </div>
                        <div class="form-label-group">
                            <label class="form-label" for="newPassword">New Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="new_password">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" maxlength="32" class="form-control form-control-lg" name="new_password" id="new_password" placeholder="Enter new password" aria-describedby="new_password-error"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="form-label-group">
                            <label class="form-label" for="confirmPassword">Confirm New Password</label>
                        </div>
                        <div class="form-control-wrap">
                            <a href="#" class="form-icon form-icon-right passcode-switch" data-target="confirmPassword">
                                <em class="passcode-icon icon-show icon ni ni-eye"></em>
                                <em class="passcode-icon icon-hide icon ni ni-eye-off"></em>
                            </a>
                            <input type="password" maxlength="32" class="form-control form-control-lg" name="confirm_password" id="confirmPassword" placeholder="Confirm new password" aria-describedby="confirmPassword-error"/>
                        </div>
                    </div>
                    <div class="form-group">
                        <div class="custom-control custom-control-sm custom-checkbox">
                            <input type="checkbox" class="custom-control-input" name="is_notify" id="is_notify" checked>
                            <label class="custom-control-label" for="is_notify">
                                Notify {{isset($notifyUser)?$notifyUser:'tutor'}} via registered email
                            </label>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" data-dismiss="modal" class="btn btn-light width-120 ripple-effect mr-2">Cancel</button>
                        <button type="button" id="submit-btn" class="btn btn-primary width-120 ripple-effect">Update</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\UserChangePasswordRequest','#user-change-password-form') !!}
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
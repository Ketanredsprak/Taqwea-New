<div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Payment for tutor</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form id="payAmountRequestFrm" method='post'>
                    <input type="hidden" name="id" value="{{$id}}">
                    <div class="form-group">
                        <label class="form-label">Pay amount</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" id="amount" name="amount" value="{{$amount}}" placeholder="amount" >
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Beneficiary Name</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control"  value="{{$user->tutor->beneficiary_name}}" placeholder="Beneficiary name" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Account Number</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="{{$user->tutor->account_number}}" placeholder="Account Name" disabled>
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Bank Code</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" value="{{$user->tutor->bank_code}}" placeholder="Bank Code" disabled>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="submit" id="paynow-submit" class="btn btn-primary width-120 ripple-effect">Submit</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\PayoutRequest', '#payAmountRequestFrm') !!}
            </div>
        </div>
    </div>

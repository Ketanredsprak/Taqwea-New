<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <div class="d-block">
                <h5 class="modal-title">Manage Points</h5>
                <h6 class="tutor_name"> {{@$data->name}}</h6>
            </div>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
        </div>
        <div class="modal-body">
            <form id="managePointsRequestFrm" method='post'>
                <input type="hidden" name="user_id" value="{{@$data->id}}">
                <div class="form-group">
                    <label class="form-label">Enter Points</label>
                    <div class="form-control-wrap">
                        <input type="text" class="form-control" id="points" name="points" value="" placeholder="points">
                    </div>
                </div>
                <p>Current Balance: {{$data->points? $data->points : "0.0"}} </p>
                <div class="form-group">
                    <div class="custom-control custom-radio d-inline-flex">
                                        <input type="radio" id="credit" name="type" class="custom-control-input" value="credit" checked>
                                        <label class="custom-control-label font-bd" for="credit">Credit</label>
                                    </div>
                                    <div class="custom-control custom-radio d-inline-flex ml-2">
                                        <input type="radio" id="debit" name="type" value="revert" class="custom-control-input" >
                                        <label class="custom-control-label font-bd" for="debit">Debit</label>
                                    </div>
                </div>
                <div class="text-center mt-4">
                    <button type="submit" id="manage-points"
                        class="btn btn-primary width-120 ripple-effect">Submit</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Admin\ManagePointRequest', '#managePointsRequestFrm') !!}
        </div>
    </div>
</div>

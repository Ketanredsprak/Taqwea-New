<!-- Rasie Dispute -->
<div class="modal fade" id="rasieDisputeModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered commonModal commonModal">
            <div class="modal-content">
                <div class="modal-header align-items-center border-bottom-0">
                    <h5 class="modal-title">{{__('labels.raise_dispute')}}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form action="{{route('student.feedback.dispute-reason')}}" id="raiseDispute-frm" method="post">
                        {{csrf_field()}}
                        <input type="hidden" id="class_id" name="class_id" value="{{$class_id}}">
                        <div class="form-group mb-0">
                            <label class="form-label">{{__('labels.write_your_dispute_reason')}}</label>
                            <textarea class="form-control" name="dispute_reason" id="dispute_reason"></textarea>
                        </div>
                        <div class="modal-footer border-top-0">
                            <button type="button" id=submit-button class="btn btn-primary btn-lg w-100 ripple-effect">{{__('labels.submit')}}</button>
                        </div>
                    </form>
                    {!! JsValidator::formRequest('App\Http\Requests\Student\RaiseDisputeRequest', '#raiseDispute-frm') !!}
                </div>
            </div>
        </div>
    </div>
<div class="modal fade" id="quoteModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--education">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{ __('labels.send_price') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form action="{{ route('tutor.tutorquote.store') }}" id="addQuoteForm" method="post" novalidate>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="step1-english-certificate" role="tabpanel">
                        <div class="modal-body">
                            <div class="form-group mb-0">
                                <label class="form-label">{{ __('labels.price') }}</label>
                                <input name="tutor_request_id" type="hidden" class="form-control" id="tutor_request_id">
                                <input name="class_request_id" type="hidden" class="form-control" id="class_request_id">
                                <input name="tutor_id" type="hidden" class="form-control" id="tutor_id">
                                <input name="student_id" type="hidden" class="form-control" id="student_id">
                                <input name="price" type="number" class="form-control" placeholder="{{ __('labels.price') }}" id="price">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="submit" class="btn btn-primary btn-lg w-100 ripple-effect" id="addQuoteBtn">{{ __('labels.send_price') }}</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Tutor\AddQuoteRequest', '#addQuoteForm') !!}
        </div>
    </div>
</div>
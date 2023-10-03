    <div class="modal-dialog modal-md modal-dialog-centered commonModal commonModal--newTopic">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{__('labels.purchase_top')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="{{ route('student.checkout.index')}}" method="get" id="addTopUpForm" novalidate>
                    <input type="hidden" name="top_up_id", value="{{$topUp->id}}">
                    <div class="form-group">
                        <label class="form-label">{{__('labels.top_up_class_purchase', ['price'=> __('labels.sar').' '. $topUp->class_per_hours_price])}}</label>
                        <input type="text" dir="rtl" name="class_hours" class="form-control" placeholder="{{__('labels.enter_top_up_class_purchase')}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{__('labels.top_up_webinar_purchase', ['price'=> __('labels.sar').' '. $topUp->webinar_per_hours_price])}}</label>
                        <input type="text" dir="rtl" name="webinar_hours" class="form-control" placeholder="{{__('labels.enter_top_up_webinar_purchase')}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{__('labels.top_up_blog_purchase',  ['price'=> __('labels.sar').' '. $topUp->blog_per_hours_price])}}</label>
                        <input type="text" dir="rtl" name="blog" class="form-control" placeholder="{{__('labels.enter_top_up_blog_purchase')}}">
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{__('labels.top_up_is_featured',  ['price'=> __('labels.sar').' '. $topUp->is_featured_price])}}</label>
                        <input type="text" dir="rtl" name="is_featured" class="form-control" placeholder="{{__('labels.enter_top_up_is_featured')}}">
                    </div>
                    <div class="btn-row">
                        <button type="submit" id="addTopUpBtn" class="btn btn-primary btn-block btn-lg ripple-effect mw-300 m-auto">{{__('labels.purchase')}}</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Tutor\PurchaseTopUpRequest', '#addTopUpForm') !!}
            </div>
        </div>
    </div>

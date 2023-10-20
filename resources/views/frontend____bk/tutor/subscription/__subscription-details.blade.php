<div class="modal-dialog modal-dialog-centered commonModal commonModal--transaction">
    <div class="modal-content">
        <div class="modal-header align-items-center border-bottom-0">
            <h5 class="modal-title">{{__('labels.transaction_detail')}}</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
            </button>
        </div>
        <div class="modal-body">
            <div class="transactionBox d-flex justify-content-between align-items-center text-center">
                <div class="transactionBox-txt">
                    <h5 class="font-bd">{{__('labels.amount')}}</h5>
                    <p class="font-rg textDanger mb-0">{{ __('labels.sar') }}  <span class="font-bd">{{$subscription->transaction->total_amount}}</span></p>
                </div>
            </div>
            <h5 class="font-eb mb-2">{{__('labels.booking_detail')}}</h5>
            <div class="transcationDetail">
                <div class="transcationDetail_list d-flex">
                    <div class="listName textGray">{{__('labels.subscription_name')}}</div>
                    <span class="mb-0">{{$subscription->subscription->subscription_name}}</span>
                </div>
                <div class="transcationDetail_list d-flex">
                    <div class="listName textGray">{{__('labels.no_of_students')}}</div>
                    <span class="mb-0">{{$subscription->allow_booking}}</span>
                </div>
                <div class="transcationDetail_list d-flex">
                    <div class="listName textGray ">{{__('labels.transaction_id')}}</div>
                    <span class="mb-0 idNumber">{{'#'}}{{$subscription->transaction->external_id}}</span>
                </div>
                <div class="transcationDetail_list d-flex">
                    <div class="listName textGray">{{__('labels.class_hours')}}</div>
                    <span class="mb-0">{{$subscription->class_hours}} {{__('labels.hours')}}</span>
                </div>
                <div class="transcationDetail_list d-flex">
                    <div class="listName textGray">{{__('labels.webinar_hours')}}</div>
                    <span class="mb-0">{{$subscription->webinar_hours}} {{__('labels.hours')}}</span>
                </div>
                <div class="transcationDetail_list d-flex">
                    <div class="listName textGray">{{__('labels.blog')}}</div>
                    <span class="mb-0">{{$subscription->blog}}</span>
                </div>
                <div class="transcationDetail_list d-flex">
                    <div class="listName textGray">{{__('labels.class_commission')}} (%)</div>
                    <span class="mb-0">{{$subscription->commission}}</span>
                </div>
                <div class="transcationDetail_list d-flex">
                    <div class="listName textGray">{{__('labels.blog_commission')}} (%)</div>
                    <span class="mb-0">{{$subscription->blog_commission}}</span>
                </div>
                <div class="transcationDetail_list d-flex mb-0">
                    <div class="listName textGray">{{__('labels.date_time')}}</div>
                    <span class="mb-0" dir="{{config('constants.date_format_direction')}}">{{ convertDateToTz($subscription->created_at, 'UTC', 'd M Y') }},{{ convertDateToTz($subscription->created_at, 'UTC', 'h:i A') }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
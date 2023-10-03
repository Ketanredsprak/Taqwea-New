<div class="modal fade" tabindex="-1" id="studentDetails">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Student Refund Request Details</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="user-card customerInfo user-card-s2 mb-4">
                    <div class="user-avatar lg bg-primary">
                        <img src="{{$student_details->student->profile_image_url}}" alt="Profile">
                    </div>
                    <div class="user-info ">
                        <h5>{{$student_details->student->name}}</h5>
                        <span class="sub-text">{{$student_details->student->email}}</span>
                    </div>
                </div>
                <h6 class="overline-title-alt mb-2">Information</h6>
                <div class="row g-3">

                    <div class="col-6">
                        <span class="sub-text">Class Name</span>
                        <span>{{$student_details->class->class_name}}</span>
                    </div>
                    <div class="col-6">
                        <span class="sub-text">Hourly Rate</span>
                        <span>{{ __('labels.sar') }} {{$student_details->class->hourly_fees}}</span>
                    </div>
                    <div class="col-6">
                        <span class="sub-text">Duration</span>
                        <span>{{ convertMinutesToHours($student_details->class->duration)}}</span>
                    </div>
                    <div class="col-6">
                        <span class="sub-text">Request Date & Time</span>
                        <span>{{ convertDateToTz($student_details->created_at, 'UTC', 'm/d/Y h:i a') }}</span>
                    </div>
                    <div class="col-6">
                        <span class="sub-text">Refund Amount</span>
                        <span>{{ __('labels.sar') }} {{$student_details->transactionItem?($student_details->transactionItem->status == "refund" ?$student_details->transactionItem->total_amount:0.0):0.0 }}</span>
                    </div>
                    @if($student_details->transactionItem?$student_details->transactionItem->status == "refund":false)
                    <div class="col-6">
                        <span class="sub-text">Refund Date & Time</span>
                        <span>{{$student_details->transactionItem?($student_details->transactionItem->status == "refund" ?convertDateToTz($student_details->transactionItem->updated_at , 'UTC', 'm/d/Y h:i a') :''):''}}</span>
                    </div>
                    @endif
                    <div class="col-12">
                        <span class="sub-text">Class Description</span>
                        <span>
                            {!! $student_details->class->class_description !!}
                        </span>
                    </div>
                    <div class="col-12">
                        <span class="sub-text">Dispute Reason</span>
                        <span>
                            {{$student_details->dispute_reason}}
                        </span>
                    </div>
                    @if($student_details->status == 'cancel')
                    <div class="col-12">
                        <span class="sub-text">Cancel Reason</span>
                        <span>
                            {{$student_details->cancel_reason}}
                        </span>
                    </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
</div>
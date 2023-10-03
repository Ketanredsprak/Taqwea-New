<div class="modal fade" tabindex="-1" role="dialog" id="editSubscription">
    <div class="modal-dialog modal-dialog-centered modal-md" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Edit Subscription</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <form action="{{ route('subscriptions.update', $subscription->id)}}" method="PUT" id="subscription-frm">
                    <input type="hidden" value="{{$subscription->default_plan}}" name="default_plan">
                    {{csrf_field()}}
                    <div class="form-group">
                        <label class="form-label">Subscription Name(en)</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="en[subscription_name]" value="{{$subscription->translate('en')->subscription_name}}" placeholder="Subscription Name" />
                        </div>
                    </div>
                    
                    <div class="form-group">
                        <label class="form-label">Subscription Name(ar)</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" dir="rtl" name="ar[subscription_name]" value="{{$subscription->translate('ar')->subscription_name}}" placeholder="Subscription Name" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Subscription Descriptions(en)</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="en[subscription_description]" value="{{$subscription->translate('en')->subscription_description}}" placeholder="Subscription description" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Subscription Descriptions(ar)</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" dir="rtl" name="ar[subscription_description]" value="{{$subscription->translate('ar')->subscription_description}}" placeholder="Subscription description" />
                        </div>
                    </div>
                    <!-- <div class="form-group">
                        <label class="form-label">No. Of Student</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="allow_booking" placeholder="No Of Students" value="{{$subscription->allow_booking}}" />
                        </div>
                    </div> -->
                    <div class="form-group">
                        <label class="form-label">Class Hours</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="class_hours" placeholder="Class Hours" value="{{$subscription->class_hours}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Webinar Hours</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="webinar_hours" placeholder="Webinar Hours" value="{{$subscription->webinar_hours}}" />
                        </div>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Featured</label>
                        <select class="form-select form-select-sm" data-placeholder="features" name="featured" id='featured'>
                            <option value="Yes" {{($subscription->featured == "Yes")?'selected':''}}>Yes</option>
                            <option value="No" {{($subscription->featured == "No")?'selected':''}}>No</option>
                        </select>
                    </div>

                    <div class="form-group">
                        <label class="form-label">Class && Webinar Commission%</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="commission" placeholder="Commission Hours" value="{{$subscription->commission}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Blog Commission%</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="blog_commission" placeholder="Commission Hours" value="{{$subscription->blog_commission}}" />
                        </div>
                    </div>
                    <div class="form-group">
                        <label class="form-label">Blog</label>
                        <div class="form-control-wrap">
                            <input type="text" class="form-control" name="blog" value="{{$subscription->blog}}" placeholder="Blog" />
                        </div>
                    </div>
                    <div class="form-group moreOption">
                        <div id="more-option">
                            <div class="closeOption">                                
                                <div class="form-group ">
                                    <label class="form-label">Duration(In Month)</label>
                                    <input type="text" class="form-control mb-2" name="duration" placeholder="Duration" value="{{$subscription->duration}}" />
                                </div>
                                <div class="form-group ">
                                    <label class="form-label">Amount</label>
                                    <input type="text" class="form-control mb-2" name="amount" placeholder="Amount" value="{{$subscription->amount}}" />
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="text-center mt-4">
                        <button type="button" data-dismiss="modal" class="btn btn-light width-120 ripple-effect mr-2">Cancel</button>
                        <button type="button" id="subscription-btn" class="btn btn-primary width-120 ripple-effect">Update</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Admin\SubscriptionEditRequest','#subscription-frm') !!}
            </div>
            <!-- .modal-body -->
        </div>
        <!-- .modal-content -->
    </div>
    <!-- .modal-dialog -->
</div>
<script src="{{asset('assets/js/admin/subscription/index.js')}}"></script>

<script>
   
</script>
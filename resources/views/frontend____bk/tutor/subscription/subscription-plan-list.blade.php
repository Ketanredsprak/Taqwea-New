<div class="row">
    @forelse($newSubscriptions as $subscription)
        @php 
            $activePlan = $subscription->activePlan;
        @endphp
    
    <div class="col-sm-6 pt-4">
        <div class="subscriptionPage__PlansBox">
            <div class="activeTxt">
                <h4 class="text-center mb-0">{{$subscription->subscription_name}}</h4>
                @isset($activePlan)
                <span class="textSuccess">{{__('labels.active')}}</span>
                @endisset
            </div>
            @if($subscription->amount)
            <h5 class="text-center">{{__('labels.sar')}}
            <span class="font-bd">{{$subscription->amount}}</span>
            </h5>
            @else
            <h5 class="text-center">{{__('labels.free')}}</h5>
            @endif
            @isset($activePlan)
                @isset($activePlan->tutor->tutor->class_hours)
                <div class="hoursTxt">
                    <span class="textSuccess">{{__('labels.remaining_plan_details',
                        ["class" => $subscription->activePlan->tutor->tutor->class_hours,
                        "webinar" => $subscription->activePlan->tutor->tutor->webinar_hours,
                        "blog" => $subscription->activePlan->tutor->tutor->blog
                    ]
                        )}}
                        
                        @if($activePlan->tutor->tutor->is_featured)
                        {{ __('labels.profile_featured', ["remaining" => expiryDays($activePlan->tutor->tutor->is_featured_end_date)])}}
                        @endif
                    </span>
                </div>
            @endisset
            @if($activePlan->end_date)
            <div class="warningBox">
                <h6 class="text-danger mb-0"> {{ __('labels.to_be_expired', ['expiry' => expiryDays($activePlan->end_date)])  }}</h6>
            </div>
            @endif
            @endisset
            <div class="planList">
                <ul class="list-unstyled mb-0">
                    @if(!$activePlan)
                        <li>{{__('labels.max_student_allowed', ['student' => $subscription->allow_booking])}}</li>
                        <li>{{__('labels.class_allowed', ['hours' => $subscription->class_hours])}}</li>
                        <li>{{__('labels.webinar_allowed', ['hours' => $subscription->webinar_hours])}}</li>
                        <li>{{__('labels.allowed_blog', ['count' => $subscription->blog])}}</li>
                        <li>{{__('labels.allowed_commission', ['commission' => $subscription->commission])}}</li>
                        <li>{{__('labels.allowed_commission_blog', ['commission' => $subscription->blog_commission])}}</li>
                    @else
                        <li>{{__('labels.max_student_allowed', ['student' =>$activePlan->allow_booking])}}</li>
                        <li>{{__('labels.class_allowed', ['hours' => $activePlan->class_hours])}}</li>
                        <li>{{__('labels.webinar_allowed', ['hours' => $activePlan->webinar_hours])}}</li>
                        <li>{{__('labels.allowed_blog', ['count' => $activePlan->blog])}}</li>
                        <li>{{__('labels.allowed_commission', ['commission' => $activePlan->commission])}}</li>
                        <li>{{__('labels.allowed_commission_blog', ['commission' => $activePlan->blog_commission])}}</li>
                    @endif
                </ul>
            </div>
            @if(empty($subscription->activePlan))
            <div class="text-center buyBtn">
                <a href="{{ route('student.checkout.index').'?subscription_id='.Crypt::encryptString($subscription->id)}}&duration={{$subscription->duration}}" class="btn btn-primary btn-lg w-50 ripple-effect">{{__('labels.subscribe')}}</a>
            </div>
            @endif
        </div>
    </div>
    @empty
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
        </div>
    </div>
    @endforelse
</div>
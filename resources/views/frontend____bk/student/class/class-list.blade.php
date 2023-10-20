<ul class="list-unstyled commonList mb-0">
    @forelse($classes as $class)
    <li class="commonList-item common-shadow d-md-flex bg-white">
        @if($class->class->class_type=='class')
        @php $url = route('classes/show', ['class' => $class->class->slug]) @endphp
        @else
        @php $url = route('webinars/show', ['class' => $class->class->slug]) @endphp
        @endif
        <div class="commonList-item_img position-relative">
            <a href="{{$url}}">
                <img src="{{ $class->class->class_image_url }}" alt="list-image">
            </a>
            @if(@$class->class->subject->subject_name)
            <span class="commonTag text-uppercase">{{ $class->class->subject->translateOrDefault()->subject_name }}</span>
            @endif
            <div class="userInfo">
                <span class="font-sm">
                    @if (isset($class->class->tutor->name))
                    {{$class->class->tutor->translateOrDefault()->name}}
                    @endif
                </span>
            </div>
        </div>
        <div class="commonList-item_info">
            <div class="d-flex justify-content-between">
                <a href="{{$url}}" class="linkBlack">
                    <h5 class="font-bd mb-0">{{ $class->class->translateOrDefault()->class_name }}</h5>
                </a>
                <div class="price">{{ __('labels.sar') }} 
                    <span class="font-eb">{{ (!empty($class->class->total_fees))? number_format($class->class->total_fees,2):number_format( round(($class->class->duration/60)*$class->class->hourly_fees,2),2) }}</span>
                </div>

            </div>
            <div class="textGray my-3">
                @if(@$class->class->class_type=='class')
                {{ count(@$class->class->bookings) }}/{{$class->class->no_of_attendee}} {{__('labels.students')}} <span class="dot">&#183;</span>
                @endif
                {{ getDuration($class->class->duration) }} {{__('labels.duration')}}
            </div>
            <div class="my-3" dir="{{config('constants.date_format_direction')}}">
                <span class="font-bd">{{ convertDateToTz($class->class->start_time, 'UTC', 'd M Y') }}</span>
                {{ convertDateToTz($class->class->start_time, 'UTC', 'h:i A') }}
            </div>
            <div class="btnRow d-flex justify-content-between align-items-end flex-row">
                <div class="class-actions">
                    <a href="{{ $url }}" class="btn btn-primary ripple-effect">{{__('labels.view_details')}}</a>
                    @if (@$class->class->status == 'active')
                    @if(in_array($class->status, ['confirm', 'pending']))
                    <a href="Javascript:void(0)" onclick="cancelBooking($(this),{{ $class->id }},true)" class="btn btn-primary btn-primary--outline ripple-effect">{{__('labels.cancel')}}</a>
                    @endif
                    @endif
                </div>
                @php
                if($class->status == 'pending'){
                $status = __('labels.pending');
                $badge = 'textWarning';
                }elseif($class->status == 'confirm'){
                $status = __('labels.confirmed');
                $badge = 'textSuccess';
                }elseif($class->status == 'complete'){
                $status = __('labels.completed');
                $badge = 'textSuccess';
                }else{
                $status = __('labels.cancelled_by_me');
                if(@$class->cancelledBy->user_type == 'tutor'){
                $status = __('labels.cancelled_by_tutor');
                }
                $badge = 'textDanger';
                }
                @endphp
                <p class="font-bd mb-0 text-capitalize {{$badge}}">{{$status}}</p>
            </div>
        </div>
    </li>
    @empty
    <div class="row">
        <div class="col-12">
            <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
        </div>
    </div>
    @endforelse

</ul>
<div class="d-flex align-items-center paginationBottom justify-content-end ">
    <nav aria-label="Page navigation example ">
        <div id="pagination"> {{ $classes->links() }}</div>
    </nav>
</div>
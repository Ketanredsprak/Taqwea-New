@foreach($classes as $class)
<div class="listSlider-item">
    <div class="gridList">
        <div class="gridList__img">
            @if(@$class->subject->subject_name)
            <div class="subject">
                {{$class->subject->translateOrDefault()->subject_name}}
            </div>
            @endif
            @if($class->class_type=='class')
            @php $url = route('classes/show', ['class' => $class->slug]) @endphp
            @else
            @php $url = route('webinars/show', ['class' => $class->slug]) @endphp
            @endif
            <img src="{{ $class->class_image_url }}"
                alt="{{$class->class_name}}" class="img-fluid" />
            <div class="info d-flex align-items-center justify-content-between">
                <div class="info__left">
                    <div class="userInfo__name text-truncate">
                    @if (isset($class->tutor->name))
                    {{$class->tutor->translateOrDefault()->name}}
                    @endif
                    </div>
                </div>
                <div class="info__right">
                    <span class="price">{{ __('labels.sar') }} 
                    <span class="font-bd">{{ (!empty($class->total_fees))?number_format($class->total_fees, 2): number_format(round(($class->duration/60)*$class->hourly_fees,2),2) }}</span></span>
                </div>
            </div>
        </div>

        <div class="gridList__cnt">
            <h4 class="gridList__title">{{$class->translateOrDefault()->class_name}}</h4>
        
            <span class="gridList__info">{{ @$class->bookings_count }}/{{$class->no_of_attendee}} {{__('labels.students')}}</span>
            <span class="gridList__info">{{ getDuration($class->duration) }} {{__('labels.duration')}}</span>
        </div>

        <div class="gridList__footer d-flex justify-content-between">
            <div class="gridList__footer__left" dir="{{config('constants.date_format_direction')}}">
                <div class="date">{{ convertDateToTz($class->start_time, 'UTC', 'd M Y') }} </div>
                <div class="time">{{ convertDateToTz($class->start_time, 'UTC', 'h:i A') }}</div>
            </div>
            <div class="gridList__footer__left">
                <a class="btn btn-primary ripple-effect"
                    href="{{$url}}">{{__('labels.view_details')}}</a>
            </div>
        </div>

    </div>
</div>

@endforeach

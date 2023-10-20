<div class="tutorSchedule-right common-shadow" nice-scroll>
    <h5 class="font-eb">{{ ($calender_type == 'hijri')?convertGeorgianToHijriDate($schedule_date):convertDateToTz($schedule_date, 'UTC', 'd M Y') }}</h5>
    <ul class="tutorSchedule-right_scheduleList list-unstyled mb-0">
        @forelse($classes as $class)

        <li class="d-flex">
            <div class="time font-sm" dir="{{config('constants.date_format_direction')}}">{{ convertDateToTz($class->start_time, 'UTC', 'h:i') }}</div>
            <div class="scheduleBox d-md-flex">
                <div class="scheduleBox_img">
                    @if(@$class->subject->subject_name)
                        <span class="font-bd text-uppercase">{{ $class->subject->subject_name }}</span>
                    @endif
                    <img src="{{ $class->class_image_url }}" alt="schedule-image">
                </div>
                <div class="scheduleBox_detail">
                    <h6 class="font-bd">{{ $class->class_name }}</h6>
                    <div class="textGray font-sm f-14">
                    @if(@$class->class_type=='class')
                        {{ count(@$class->bookings) }}/{{$class->no_of_attendee}} {{__('labels.students')}}
                    @endif
                    
                    <span class="dot px-2">&#183;</span> {{ getDuration($class->duration) }} {{__('labels.duration')}}</div>
                    <div class="dateTime" dir="{{config('constants.date_format_direction')}}"><span class="font-bd">{{ ($calender_type == 'hijri')?convertGeorgianToHijriDate($class->start_time):convertDateToTz($class->start_time, 'UTC', 'd M Y') }}</span> <span class="font-sm f-14">  {{ convertDateToTz($class->start_time, 'UTC', 'h:i A') }}</span></div>
                    <div class="d-md-flex flex-wrap align-items-end justify-content-between">
                        <div class="price">{{ __('labels.sar') }}  <span class="font-eb">{{ (!empty($class->total_fees))?number_format($class->total_fees, 2): number_format(round(($class->duration/60)*$class->hourly_fees,2),2) }}</span></div>
                        @if(Auth::check() && Auth::user()->user_type == 'tutor')
                        @if($class->class_type=='class')
                        @php $href = route('tutor.classes.detail', ['slug' => $class->slug]) @endphp
                        @else
                        @php $href = route('tutor.webinars.detail', ['slug' => $class->slug]) @endphp
                        @endif
                        @else
                        @if($class->class_type=='class')
                        @php $href = route('classes/show', ['class' => $class->slug]) @endphp
                        @else
                        @php $href = route('webinars/show', ['class' => $class->slug]) @endphp
                        @endif
                        @endif
                        <a href="{{$href}}" class="btn btn-primary btn-sm ripple-effect">{{__('labels.view_details')}}</a>
                       
                    </div>
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
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        classList(url);
    });
</script>
</div>
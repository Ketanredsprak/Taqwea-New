{{-- <div class="topnav">
    <input type="text" class="text-right" placeholder="Search..">
</div>  --}}


   <form action="" method="POST"  id="addClassRequestForm" novolidate>

            <div class="row align-items-center">
                <div class="col-sm-3">
                    <div class="form-group">
                            <label class="form-label">{{ __('labels.status') }}</label>
                            <select name="status" class="form-control select2"
                            data-placeholder="{{ __('labels.status') }}" id="status">

                                    <option value="">ALL</option>

                                    <option value="Active">Active</option>

                                    <option value="Cancel">Cancel</option>
                                    
                                    <option value="Expired">Expired</option>
                                
                            </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                            <label class="form-label">{{ __('labels.class_type') }}</label>
                            <select name="class_type" class="form-control select2"
                            data-placeholder="{{ __('labels.class_type') }}" id="class_type">

                                    <option value="">Both</option>
                                    
                                    <option value="Single">Single</option>

                                    <option value="Multiple">Multiple</option>
                        
                            </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group">
                        <label class="form-label">{{ __('labels.time') }}</label>
                        <select name="time" class="form-control select2"
                            data-placeholder="{{ __('labels.time') }}" id="time">

                                    <option value="">Both</option>

                                    <option value="Desc">DESC</option>

                                    <option value="Asc">ASC</option>
                        
                        </select>
                    </div>
                </div>
                <div class="col-sm-3">
                    <div class="form-group" style="margin-top:25px;">
                    <button href="test" type="button" class="btn btn-primary btn-sm btn-lg text-right">Apply</button>
                    </div>
                </div>
            </div>
            </form> 


<table class="table">
    <thead>

        <tr>

            <th>{{ __('labels.id') }}</th>

            <th>{{ __('labels.status') }}</th>

            <th>{{ __('labels.subjects') }}</th>

            <th>{{ __('labels.class_type') }}</th>

            <th>{{ __('labels.class_duration') }}</th>

            <th>{{ __('labels.time') }} </th>

            <th>{{ __('labels.action') }}</th>

            <th></th>

        </tr>

    </thead>

    <tbody>

        <?php $i = 1; ?>

        @forelse($classrequests as $key=>$data)
            <tr>

                <td>{{ $i }}</td>

                <td>
                    @if ($data->status == 'Active')
                        <label class="text-success">{{ __('labels.active') }}</label>
                    @elseif($data->status == 'Expired')
                        <label class="text-warning">{{ __('labels.expired') }}</label>
                    @elseif($data->status == 'Confirm')
                        <label class="text-info">{{ __('labels.confirmed') }}</label>
                    @else
                        {{ $data->status }}
                    @endif
                </td>

                <td>@if($data->subjects != null) {{ $data->subjects->subject_name }} @endif
                </td>

                <td>{{ $data->class_type }}</td>

                <td>{{ date('G:i', mktime(0, $data->class_duration)) }} {{ __('labels.hours') }}</td>

                <td>

                    @php
                        $start_time = \Carbon\Carbon::now();
                        $end_time = \Carbon\Carbon::parse($data->created_at)->addMinutes(11);
                        $diff = $start_time->diffInMinutes($end_time, false);
                    @endphp


                    @if ($data->status == 'Active')
                        @if ($diff < 0)
                            <p id="clockdiv">Expired</p>
                        @else
                            <p id="clockdiv{{ $key }}"></p>
                            <script>
                                // 10 minutes from now
                                var time_in_minutes{{ $key }} = "{{ @$diff }}";
                                var current_time{{ $key }} = Date.parse(new Date());
                                var deadline{{ $key }} = new Date(current_time{{ $key }} + time_in_minutes{{ $key }} *
                                    60 * 1000);


                                function time_remaining(endtime) {
                                    var t{{ $key }} = Date.parse(endtime) - Date.parse(new Date());
                                    var seconds{{ $key }} = Math.floor((t{{ $key }} / 1000) % 60);
                                    var minutes{{ $key }} = Math.floor((t{{ $key }} / 1000 / 60) % 60);
                                    var hours{{ $key }} = Math.floor((t{{ $key }} / (1000 * 60 * 60)) % 24);
                                    var days{{ $key }} = Math.floor(t{{ $key }} / (1000 * 60 * 60 * 24));
                                    return {
                                        'total': t{{ $key }},
                                        'days': days{{ $key }},
                                        'hours': hours{{ $key }},
                                        'minutes': minutes{{ $key }},
                                        'seconds': seconds{{ $key }}
                                    };
                                }

                                function run_clock(id, endtime) {
                                    var clock = document.getElementById(id);

                                    function update_clock() {
                                        var t = time_remaining(endtime);
                                        clock.innerHTML = '<p style="color:red;">' + t.minutes + ': ' + t.seconds + '</p>';
                                        if (t.total <= 0) {
                                            clearInterval(timeinterval);
                                        }
                                    }
                                    update_clock(); // run function once at first to avoid delay
                                    var timeinterval = setInterval(update_clock, 1000);
                                }
                                run_clock('clockdiv{{ $key }}', deadline{{ $key }});
                            </script>
                        @endif
                    @elseif ($data->status == 'Confirm')
                              <p id="clockdiv" class="text-info">Confirm</p>
                    @else
                              <p id="clockdiv">Expired</p>
                    @endif


                </td>

                <td>

                    <a href="{{ route('student.classrequest.show', $data->id) }}" type="button"
                        class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-eye"></em></a>

                     {{-- @if ($data->status == 'Active')
                        @if($diff < 0)
                        @else  --}}
                                <a href="{{ route('student.classrequest.getrequest', $data->id) }}" type="button"
                                class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-notsicon2"></em></a>
                         {{-- @endif
                    @endif  --}}

                     {{-- @if ($data->status == 'Active')
                            @if($diff < 0)
                            @else --}}
                               <a href="#" onclick="Cancelrequest('{{ $data->id }}')" type="button"
                                 class="btn btn-primary btn-sm" title="Cancel Request"><em class="icon-delete"></em></a>
                            {{-- @endif
                    @endif  --}}
 

                </td>

            </tr>

            <?php $i++; ?>

        @empty

            <tr>

                <td colspan="7" class="px-0">

                    <div class="alert alert-danger font-rg">{{ __('labels.record_not_found') }}</div>

                </td>

            </tr>
        @endforelse

    </tbody>

</table>

<div class="d-flex align-items-center paginationBottom justify-content-end">

    <nav aria-label="Page navigation example">

        <div id="pagination"> {{ $classrequests->links() }}</div>

    </nav>

</div>

<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        classRequestList(url);
    });
</script>



<script type="text/javascript" src="{{ asset('assets/js/frontend/student/student-class-request.js') }}"></script>

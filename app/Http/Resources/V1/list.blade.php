<table class="table">
    <thead>

        <tr>

            <th>{{ __('labels.id') }}</th>

            <th>{{ __('labels.status') }}</th>

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

                <td>{{ $key }}</td>

                <td>
                    @if ($data->status == 'Active')
                        <label class="text-success">{{ __('labels.active') }}</label>
                    @elseif($data->status == 'Expired')
                        <label class="text-warning">{{ __('labels.expired') }}</label>
                    @else
                        {{ $data->status }}
                    @endif
                </td>

                <td>{{ $data->class_type }}</td>

                <td>{{ date('G:i', mktime(0, $data->class_duration)) }} {{ __('labels.hours') }}</td>

                <td>
                    
                @php
                    $start_time = \Carbon\Carbon::now();
                    $end_time = \Carbon\Carbon::parse($data->created_at)->addMinutes(10);
                    $diff = $end_time->diffInMinutes($start_time);
                @endphp
                @if ($diff > 10)
                <p id="clockdiv">Expired</p>
                @else
                <p id="clockdiv{{ $key }}"></p>
                <script>
                    // 10 minutes from now
                    var time_in_minutes{{ $key }} = "{{ @$diff }}";
                    var current_time{{ $key }} = Date.parse(new Date());
                    var deadline{{ $key }} = new Date(current_time{{ $key }} + time_in_minutes{{ $key }} * 60 * 1000);


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
                            clock.innerHTML = 'minutes: ' + t.minutes + '<br>seconds: ' + t.seconds;
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
                

                </td>

                

                <td>

                    <a href="{{ route('student.classrequest.show', $data->id) }}" type="button"
                        class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-eye"></em></a>

                    @if ($data->status == 'Active')
                        {{-- @if ($data->status == 'Active' && $data->won_quote_id == null) --}}
                        <a href="{{ route('student.classrequest.getrequest', $data->id) }}" type="button"
                            class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-notsicon2"></em></a>
                    @endif

                    @if ($data->status == 'Active')
                        <a href="#" onclick="Cancelrequest('{{ $data->id }}')" type="button"
                            class="btn btn-primary btn-sm" title="Cancel Request"><em class="icon-delete"></em></a>
                    @endif

                    @if ($data->won_quote_id != null && $data->won_quote_id != 0 && $data->status == 'Active')
                        <a class="btn btn-primary btn-sm"
                            href="{{ route('student.checkout.index') . '?class_request_id=' . Crypt::encryptString($data->id) }}"
                            tabindex="0">{{ __('labels.book_now') }}</a>
                    @endif



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

<div class="d-flex align-items-center paginationBottom justify-content-end ">

    <nav aria-label="Page navigation example ">

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

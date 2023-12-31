<table class="table">

    <thead>

        <tr>

            <th>{{ __('labels.id')}}</th>

            <th>{{ __('labels.student_name')}}</th>

            {{-- <th>{{ __('labels.status')}}</th> --}}

             <th>{{ __('labels.subjects')}}</th> 

            <th>{{ __('labels.class_duration') }}</th>

            <th>{{ __('labels.note') }}</th>
            
            <th>{{ __('labels.time') }} </th>

            <th>{{ __('labels.action') }}</th>

            <th></th>

        </tr>

    </thead>

    <tbody>

    <?php $i = 1; ?>

        @forelse($datas as $key=>$data)


        <tr>

            <td>{{$i}}</td>

            <td><img src="@if($data->userdata) @if($data->userdata->profile_image_url){{ $data->userdata->profile_image_url }} @endif @endif" alt="user" class="userImg img-fluid" width="40px">
            <span class="name"> @if($data->userdata != null){{ $data->userdata->name }} @else Not Added @endif</span></td>

            <td>test</td> 

            <td>{{$data->classrequest->class_duration}} {{ __('labels.minutes') }}</td>

            <td>{{ $data->classrequest->note }}</td>

            <td>  @php
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
                    @else
                              <p id="clockdiv">Cancel</p>
                    @endif</td>

            <td><a href="{{ route('tutor.classrequest.show', $data->id) }}" type="button" class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-eye"></em></a>

                @if($data->tutor_quote  == "0")

                    <a href="#" onclick="quoteModal('{{ $data->id }}','{{ $data->class_request_id }}','{{ $data->tutor_id }}','{{ $data->user_id }}')" type="button" class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-pencil"></em></a>

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

        <div id="pagination"> {{ $datas->links() }}</div>

    </nav>

</div>

@include('frontend.tutor.quote.add-quote-modal')

{{-- {!! JsValidator::formRequest('App\Http\Requests\Tutor\ProfessionalDetailRequest', '#professionalDetailForm') !!} --}}

<script>

    $('#pagination a').on('click', function(e) {

        e.preventDefault();

        var url = $(this).attr('href');

        tutorClassRequestList(url);

    });

</script>

<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/quote.js')}}"></script>




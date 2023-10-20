<table class="table">

    <thead>

        <tr>

            <th>{{ __('labels.id')}}</th>

            <th>{{ __('labels.student_name')}}</th>

            <th>{{ __('labels.student_email_id')}}</th>

            <th>{{ __('labels.status')}}</th>

            {{-- <th>{{ __('labels.class_type') }}</th> --}}

            <th>{{ __('labels.class_duration') }}</th>

            {{-- <th>{{ __('labels.request_time') }}</th>

            <th>{{ __('labels.expired_time') }}</th> --}}

            <th>{{ __('labels.action') }}</th>

            <th></th>

        </tr>

    </thead>

    <tbody>

    <?php $i = 1; ?>

    {{-- @dd($datas); --}}

        @forelse($datas as $data)

        <tr>

            <td>{{$i}}</td>

            <td>{{ $data->userdata->name }}</td>

            <td>{{ $data->userdata->email }}</td>

            <td> @if($data->status) <label class="text-success">{{ __('labels.active') }}</label> @else {{ $data->status }} @endif</td>

            {{-- <td>{{$data->classrequest->class_type}}</td> --}}

            <td>{{$data->classrequest->class_duration}} {{ __('labels.hours') }}</td>

            {{-- <td>{{  date('g:i a', strtotime($data->classrequest->request_time))  }}</td>

            <td>{{ date('g:i a', strtotime($data->classrequest->expired_time))}}</td> --}}

            <td><a href="{{ route('tutor.classrequest.show', $data->id) }}" type="button" class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-eye"></em></a>

                @if($data->tutor_quote  == "0")

                    <a href="#" onclick="quoteModal('{{ $data->id }}','{{ $data->class_request_id }}','{{ $data->tutor_id }}','{{ $data->user_id }}')" type="button" class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-pencil"></em></a>

                @endif     

            </td>

            {{-- <a href="#" class="linkPrimary text-uppercase font-eb" onclick="quoteModal()">{{ __('labels.send_price') }}</a> --}}



       

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




<table class="table">
    <thead>
        <tr>
            <th>{{ __('labels.id')}}</th>
            <th>{{ __('labels.status')}}</th>
            <th>{{ __('labels.class_type') }}</th>
            <th>{{ __('labels.class_duration') }}</th>
            <th>{{ __('labels.action') }}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
    <?php $i = 1; ?>
        @forelse($classrequests as $data)
        <tr>
            <td>{{$i}}</td>
            <td> @if($data->status == 'Active') <label class="text-success">{{ __('labels.active') }}</label> @elseif($data->status == 'Expired') <label class="text-warning">{{ __('labels.expired') }}</label> @else {{ $data->status }} @endif</td>
            <td>{{$data->class_type}}</td>
            <td>{{ date('G:i', mktime(0, $data->class_duration)) }} {{ __('labels.hours') }}</td>
            <td><a href="{{ route('student.classrequest.show', $data->id) }}" type="button" class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-eye"></em></a><a href="{{ route('student.classrequest.getrequest',$data->id) }}" type="button" class="btn btn-primary btn-sm btn-lg text-right"><em class="icon-notsicon2"></em></a></td>
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


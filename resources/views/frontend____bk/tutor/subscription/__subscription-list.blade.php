<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>{{ __('labels.transaction_id')}}</th>
            <th>{{ __('labels.name') }}</th>
            <th>{{ __('labels.purpose') }}</th>
            <th>{{ __('labels.date') }}</th>
            <th>{{ __('labels.amount') }}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($subscriptions as $subscription)
        <tr>
            <td>
                <div class="transactionIcon">
                    <em class="icon-subscription textPrimary"></em>
                </div>
            </td>
            <td>
                #{{$subscription->transaction->external_id}}
            </td>
            <td>{{$subscription->subscription->translateOrDefault()->subscription_name}}</td> 
            <td class="text-capitalize">{{  __('labels.'.$subscription->transaction->transaction_type)}}</td>
            <td>
                <div class="dateTime d-flex align-items-center" dir="{{config('constants.date_format_direction')}}">
                    <div class="date mr-1">{{ convertDateToTz($subscription->created_at, 'UTC', 'd M Y') }},</div>
                    <div class="Time">{{ convertDateToTz($subscription->created_at, 'UTC', 'h:i A') }}</div>
                </div>
            </td>
            <td>
                <div class="amount textDanger">
                    <span class="text-uppercase mr-1 font-rg">{{ __('labels.sar') }} </span>{{ number_format($subscription->transaction->total_amount,2) }}
                </div>
            </td>
            <!-- <td>
                <div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="action" data-toggle="dropdown">
                        <span class="icon-ellipse-v"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="action">
                        <a class="dropdown-item textGray font-bd" href="javascript:void(0);" onclick="transactionDetailModal({{$subscription->id}})">{{__('labels.view_details')}}</a>
                    </div>
                </div>
            </td> -->
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
        <div id="pagination"> {{ $subscriptions->links() }}</div>
    </nav>
</div>
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        getTransactionList(url);
    });
</script>
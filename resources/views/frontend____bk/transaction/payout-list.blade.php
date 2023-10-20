<table class="table" aria-describedby="mydesc">
    <thead>
        <tr>
            <th></th>
            <th>{{ __('labels.transaction_id') }}</th>
            <th>{{ __('labels.date_time') }}</th>
            <th>{{ __('labels.payment_to') }}</th>
            <th>{{ __('labels.total_payout')}}</th>
            <th>{{ __('labels.status')}}</th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $transaction)
        
        <tr>
            <td>
                <div class="transactionIcon">
                    <em class="icon-wallet"></em>
                </div>
            </td>
            <td>
                #{{$transaction->transaction_id}}
            </td>
            <td>
                <div class="dateTime d-flex align-items-center" dir="{{config('constants.date_format_direction')}}">
                    <div class="date mr-1">{{ convertDateToTz($transaction->created_at, 'UTC', 'd M Y') }},</div>
                    <div class="Time">{{ convertDateToTz($transaction->created_at, 'UTC', 'h:i A') }}</div>
                </div>
            <td>
                XXXX{{substr($transaction->account_number, -4)}}
            </td>
            <td>
            <span class="text-uppercase mr-1 font-rg">{{ __('labels.sar') }} </span>{{ number_format($transaction->amount, 2) }}
            </td>
            @php

            if($transaction->status == 'success'){
            $status = __('labels.success');
            $class = 'textSuccess';
            }elseif($transaction->status == 'pending') {
            $status = __('labels.pending');
            $class = 'text-warning';
            }elseif($transaction->status == 'failed'){
            $status = __('labels.failed');
            $class = 'textDanger';
            }
            @endphp
            <td>
                <div class="{{$class}}">
                    <span class="text-uppercase mr-1 font-rg">{{($status)}}</span>
                </div>
            </td>
         
        </tr>
        @empty
        <tr>
            <td colspan="7">
                <div class="alert alert-danger font-rg">{{ __('labels.record_not_found') }}</div>
            </td>
        </tr>
        @endforelse
    </tbody>
</table>
<div class="d-flex align-items-center paginationBottom justify-content-end ">
    <nav aria-label="Page navigation example ">
        <div id="pagination"> {{ $transactions->links() }}</div>
    </nav>
</div>
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        transactionList(url);
    });
</script>
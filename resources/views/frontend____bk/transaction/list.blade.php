<table class="table" aria-describedby="mydesc">
    <thead>
        <tr>
            <th></th>
            <th>{{ __('labels.transaction_id') }}</th>
            <th>{{ __('labels.puropse') }}</th>
            <th>{{ __('labels.date_time') }}</th>
            <th>{{ __('labels.amount') }}</th>
            <th>{{ __('labels.payment_status')}}</th>
            <th></th>

        </tr>
    </thead>
    <tbody>
        @forelse($transactions as $transaction)
            @php
                if (@$transaction->transaction_type == 'add_to_wallet') {
                    $puropse = __('labels.add_to_wallet');
                    $icon = 'icon-wallet';
                    $class = 'textSuccess';
                    $creditDebit = '+';
                }elseif(@$transaction->transaction_type == 'subscription') {
                    $puropse = __('labels.subscription');
                    $icon = 'icon-class-booking';
                    $class = 'textDanger';
                    $creditDebit = '-';
                }elseif(@$transaction->transaction_type == 'redeem') {
                    $puropse = __('labels.redeem');
                    $icon = 'icon-class-booking';
                    $class = 'textSuccess';
                    $creditDebit = '+';
                }elseif(@$transaction->transaction_type == 'top_up') {
                    $puropse = __('labels.top_up');
                    $icon = 'icon-class-booking';
                    $class = 'textDanger';
                    $creditDebit = '-';
                }elseif(@$transaction->transaction_type == 'refund') {
                    $puropse = __('labels.refund');
                    $icon = 'icon-class-booking';
                    $class = 'textSuccess';
                    $creditDebit = '+';
                }elseif(@$transaction->transaction_type == 'extra_hours') {
                    $puropse = __('labels.extra_hours');
                    $icon = 'icon-class-booking';
                    $class = 'textSuccess';
                    $creditDebit = '+';
                }elseif(@$transaction->transaction_type == 'fine') {
                    $puropse = __('labels.penalty');
                    $icon = 'icon-class-booking';
                    $class = 'textDanger';
                    $creditDebit = '-';
                }else{
                    $puropse = __('labels.booking');
                    $icon = 'icon-class-booking';
                    $class = 'textDanger';
                    $creditDebit = '-';
                }
            @endphp
            <tr>
                <td>
                    <div class="transactionIcon">
                        <em class="{{ $icon }}"></em>
                    </div>
                </td>
                <td>
                    #{{ $transaction->external_id }}
                </td>
                <td>{{ $puropse }}</td>
                <td>
                    <div class="dateTime d-flex align-items-center" dir="{{config('constants.date_format_direction')}}">
                        <div class="date mr-1">{{ convertDateToTz($transaction->created_at, 'UTC', 'd M Y') }},</div>
                        <div class="Time">{{ convertDateToTz($transaction->created_at, 'UTC', 'h:i A') }}</div>
                    </div>
                </td>
                <td>
                    <div class="amount {{$class}}">
                        <span class="text-uppercase mr-1 font-rg">{{ __('labels.sar') }} </span>{{$creditDebit }}{{ number_format($transaction->total_amount, 2) }}
                    </div>
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
                }elseif($transaction->status == 'refunded'){
                $status = __('labels.refunded');
                $class = 'textDanger';
                }
                @endphp
                <td>
                    <div class="{{$class}}">
                        <span class="text-uppercase mr-1 font-rg">{{($status)}}</span>
                    </div>
                </td>
                {{-- <td>
                    <div class="dropdown">
                        <a class="dropdown-toggle" href="#" role="button" id="action" data-toggle="dropdown">
                            <span class="icon-ellipse-v"></span>
                        </a>
                        <div class="dropdown-menu" aria-labelledby="action">
                            <a class="dropdown-item textGray font-bd" href="javascript:void(0);" onclick="transactionReceived();">View
                                Details</a>
                        </div>
                    </div>
                </td> --}}
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

<table class="table">
    <thead>
        <tr>
            <th></th>
            <th>{{ __('labels.transaction_id')}}</th>
            <th>{{ __('labels.purpose') }}</th>
            <th>{{ __('labels.date_time') }}</th>
            <th>{{ __('labels.amount') }}</th>
            <th></th>
        </tr>
    </thead>
    <tbody>
        @forelse($wallets as $wallet)
        <tr>
            @php
            if (@$wallet->transaction->transaction_type == 'add_to_wallet') {
            $puropse = __('labels.add_to_wallet');
            $icon = 'icon-wallet';
            }elseif(@$wallet->transaction->transaction_type == 'booking'){
            $puropse = __('labels.booking');
            $icon = 'icon-class-booking';
            }elseif(@$wallet->transaction->transaction_type == 'subscription'){
            $puropse = __('labels.subscription');
            $icon = 'icon-class-booking';
            }elseif(@$wallet->transaction->transaction_type == 'top_up') {
                $puropse = __('labels.top_up');
                $icon = 'icon-class-booking';
            }elseif(@$wallet->transaction->transaction_type == 'extra_hours') {
            $puropse = __('labels.extra_hours');
            $icon = 'icon-class-booking';
            $class = 'textSuccess';
            $creditDebit = '+';
            }else{
            $puropse = __('labels.redeem');
            $icon = 'icon-wallet';
            }
            if (@$wallet->transaction->status == 'refunded') {
            $puropse = __('labels.refund');
            $icon = 'icon-wallet';
            }
            @endphp
            <td>
                <div class="transactionIcon">
                    <em class="{{ $icon }}"></em>
                </div>
            </td>
            <td>
                #{{ @$wallet->transaction->external_id }}
            </td>
            <td>{{ $puropse }}</td>
            <td>
                <div class="dateTime d-flex align-items-center" dir="{{config('constants.date_format_direction')}}">
                    <div class="date mr-1">{{ convertDateToTz($wallet->created_at, 'UTC', 'd M Y') }},</div>
                    <div class="Time">{{ convertDateToTz($wallet->created_at, 'UTC', 'h:i A') }}</div>
                </div>
            </td>
            <td>
                @if($wallet->type == 'credit')
                <div class="amount textSuccess">
                    <span class="text-uppercase mr-1 font-rg">{{ __('labels.sar') }}</span>+{{ number_format($wallet->amount, 2) }}
                </div>
                @else
                <div class="amount textDanger">
                    <span class="text-uppercase mr-1 font-rg">{{ __('labels.sar') }}</span>{{ number_format($wallet->amount, 2) }}
                </div>
                @endif
            </td>
            <td>
                {{--<div class="dropdown">
                    <a class="dropdown-toggle" href="#" role="button" id="action" data-toggle="dropdown">
                        <span class="icon-ellipse-v"></span>
                    </a>
                    <div class="dropdown-menu" aria-labelledby="action">
                        <a class="dropdown-item textGray font-bd" href="javascript:void(0);">{{__('labels.view_details'))}}</a>
                    </div>
                </div>--}}
            </td>
        </tr>
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
        <div id="pagination"> {{ $wallets->links() }}</div>
    </nav>
</div>
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        getTransactionList(url);
    });
</script>
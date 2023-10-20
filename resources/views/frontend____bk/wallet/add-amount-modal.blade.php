<!-- Add amount modal -->
<div class="modal fade" id="addAmountModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--redeemPoint">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{ __('labels.add_amount')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(Auth::check() && Auth::user()->isTutor())
            @php $formAction = route('tutor.wallet.store') @endphp
            @elseif(Auth::check() && Auth::user()->isStudent())
            @php $formAction = route('student.wallet.store') @endphp
            @endif

            <form action="{{ $formAction }}" id="addWalletBalanceForm" novalidate>
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="textGray font-sm mb-0">{{__('labels.available_balance')}}</p>
                        <span class="font-eb">{{__('labels.sar')}} {{ $availableBalance }}</span>
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">{{__('labels.value_in')}} {{__('labels.sar')}}</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">{{__('labels.sar')}}</span>
                            </div>
                            <input name="amount" type="number" id="amount" class="form-control" min="1">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button type="submit" id="addWalletBalanceBtn" class="btn btn-primary btn-lg w-100 ripple-effect">{{__('labels.add')}}</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Wallet\AddAmountRequest', '#addWalletBalanceForm') !!}
        </div>
    </div>
</div>
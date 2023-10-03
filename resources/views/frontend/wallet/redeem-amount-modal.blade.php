<!-- Redeem Points -->
<div class="modal fade" id="redeemPointModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--redeemPoint">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{__('labels.redeem_point')}}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            @if(Auth::check() && Auth::user()->isTutor())
            @php $formAction = route('tutor.wallet.redeem') @endphp
            @elseif(Auth::check() && Auth::user()->isStudent())
            @php $formAction = route('student.wallet.redeem') @endphp
            @endif
            <form method="post" action="{{ $formAction }}" id="redeemForm" novalidate>
                @csrf
                <div class="modal-body">
                    <div class="d-flex justify-content-between align-items-center mb-3">
                        <p class="textGray font-sm mb-0">{{ __('labels.point_available')}}</p>
                        <span class="font-eb">
                            <h4>{{ $availablePoints }}</h4>
                        </span>
                    </div>
                    <div class="form-group">
                        <label class="form-label">{{__('labels.no_of_points')}}</label>
                        <input type="text" dir="rtl" name="points" id="points" class="form-control" onkeyup="updateSar()">
                    </div>
                    <div class="form-group mb-0">
                        <label class="form-label">{{__('labels.value_in')}} SAR</label>
                        <div class="input-group">
                            <div class="input-group-prepend">
                                <span class="input-group-text">SAR</span>
                            </div>
                            <input type="text" dir="rtl" name="sar" id="sar" readonly="readonly" value="" class="form-control">
                        </div>
                    </div>
                </div>
                <div class="modal-footer border-top-0">
                    <button id="redeemBtn" type="submit" class="btn btn-primary btn-lg w-100 ripple-effect">{{__('labels.confirm_redeem')}}</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Wallet\RedeemRequest', '#redeemForm') !!}
        </div>
    </div>
</div>

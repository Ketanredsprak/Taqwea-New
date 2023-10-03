<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title"> {{$bank ? 'Edit' : 'Add'}} Bank Details</h5>
            <a href="" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
        </div>
        <div class="modal-body">
            <form action="{{ $bank ? route('banks.update', $bank->id) : route('banks.store') }}" method="post" id="bank-form">
                {{csrf_field()}}
                <input type="hidden" id="id" value="{{$bank ? $bank->id : ''}}">
                <div class="row gy-3">
                    <div class="col-md-6">
                    @foreach (config('translatable.locales') as $locale)
                        <div class="form-group">
                            <label class="form-label">Bank Name ({{$locale}})</label>
                            <div class="form-control-wrap">
                                <input type="text" class="form-control" @if($locale == 'ar') dir="rtl" @endif placeholder="Enter Bank Name {{ ($locale == 'ar')? 'Arabic' : 'English' }}" name="{{$locale}}[bank_name]"
                                    value="{{$bank ? $bank->translate($locale)->bank_name : ''}}">
                            </div>
                        </div>
                    @endforeach
                    </div>
                    <div class="col-md-6">
                        <div class="form-group">
                            <label class="form-label">Bank code</label>
                            <div class="form-control-wrap">
                                <input type="text" name="bank_code" class="form-control" placeholder="Enter Bank Code"
                                    value="{{$bank ? $bank->bank_code: ''}}">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="btn-row mt-3 text-center">
                    <button type="button" id="submit-btn" onclick="submitBankDetails()"
                        class="btn btn-primary">{{$bank ? "Edit" : 'Add'}}</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Admin\BankRequest','#bank-form') !!}
        </div>
    </div>
</div>
<script>
    
</script>
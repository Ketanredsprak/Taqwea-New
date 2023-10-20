@forelse($cardLists as $key => $card)
<div class="cardImg col-md-6 position-relative">
    <div class="cardImg-innerText">
        <div class="cardImg-innerText_visaName d-flex align-items-center justify-content-between">
            <img src="{{ asset('assets/images/master-card.png') }}" alt="card">
            <div class="custom-control custom-radio">
                <input type="radio" id="card-{{$card->id}}" name="card_id" value="{{$card->card_id}}" class="custom-control-input" {{$key == 0 ? 'checked' : ''}}>
                <label class="custom-control-label" for="card-{{$card->id}}"></label>
            </div>
        </div>
        <div class="cardImg-innerText_num">
            <span>****</span><span>****</span><span>****</span><span>{{substr($card->card_number, -4)}}</span>
        </div>
        <div class="cardImg-innerText_valid d-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{ __('labels.valid_till') }}: <span class="font-eb">{{$card->exp_month}}/{{$card->exp_year}}</span></h5>
        </div>
    </div>
</div>
@empty
<tr>
    <td colspan="7" class="px-0">
        <div class="alert alert-danger font-rg">{{ __('labels.card_not_found') }}</div>
    </td>
</tr>
@endforelse
<div class="d-flex col-12 align-items-center paginationBottom justify-content-end ">
    <nav aria-label="Page navigation example ">
        <div id="pagination"> {{ $cardLists->links() }}</div>
    </nav>
</div>
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        getTransactionList(url);
    });
</script>
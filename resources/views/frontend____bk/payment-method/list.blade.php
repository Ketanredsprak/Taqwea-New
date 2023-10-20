@forelse($cardLists as $card)
<div class="cardImg col-6 position-relative">
    <div class="cardImg-innerText">
        <div class="cardImg-innerText_visaName d-flex justify-content-between align-items-center">
            <img src="{{asset('assets/images/master-card.png')}}" alt="card">
            <h6 class="delete mb-0">
                @if(Auth::check() && Auth::user()->isTutor())
                <a href="javascript:void(0);" onclick="deleteCard('tutor', {{$card->id}})" class="linkDark font-bd">
                    <em class="icon-delete"></em> <span>{{ __('labels.delete') }} </span>
                </a>
                @elseif(Auth::check() && Auth::user()->isStudent())
                <a href="javascript:void(0);" onclick="deleteCard('student', {{$card->id}})" class="linkDark font-bd">
                    <em class="icon-delete"></em> <span>{{ __('labels.delete') }}</span>
                </a>
                @endif

            </h6>
        </div>
        <div class="cardImg-innerText_num">
            <span>****</span><span>****</span><span>****</span><span>{{$card->card_number}}</span>
        </div>
        <div class="cardImg-innerText_valid d-flex align-items-center justify-content-between">
            <h5 class="mb-0">{{__('labels.valid_till')}}: <span class="font-eb">{{$card->exp_month}}/{{$card->exp_year}}</span></h5>
        </div>
    </div>
</div>
@empty
<div class="col-sm-12 p-0">
    <div class="alert alert-danger font-rg">{{ __('labels.card_not_found') }}</div>
</div>
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
        getCardList(url);
    });
</script>
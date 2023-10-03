@if($faqData->count() > 0)
<div class="card faqCard">
    <div id="faqs" class="accordion">
        @foreach($faqData as $faq)
        <div class="accordion-item">
            <div class="accordion-head w-100 text-left bg-white">
                <h6 class="title collapsed" data-toggle="collapse" data-target="#faq-q{{$loop->iteration}}">{{$faq->question}}</h6>
                <div class="action d-flex align-items-center">
                    <a href="javascript:void(0);" data-target="#editModal" onclick="editFaq('{{$faq->id}}')" class="d-flex"><em class="icon ni ni-pen"></em></a>
                    <a href="javascript:void(0);" id="a" class="d-flex eg-swal-av3" onclick="deleteFaq('{{$faq->id}}')"><em class="icon ni ni-trash"></em></a>
                    <buttton class="accordion-icon collapsed" data-toggle="collapse" data-target="#faq-q{{$loop->iteration}}" title="View Answer" /></buttton>
                </div>
            </div>
            <div class="accordion-body collapse" id="faq-q{{$loop->iteration}}" data-parent="#faqs">
                <div class="accordion-inner">
                    <p>{!! $faq->content !!}</p>
                </div>
            </div>
        </div><!-- .accordion-item -->
        @endforeach
    </div><!-- .accordion -->
</div><!-- .card -->
@else
<div class="alert alert-icon alert-danger" role="alert">
    <em class="icon ni ni-alert-circle"></em>
    <strong>No data found!</strong>
</div>
@endif
{{ $faqData->links() }}
@forelse ($faqs as $key => $faq )
<div class="accordion-item commonBox">
    <div class="accordion-head w-100 text-left bg-white" data-target="#faq-q{{ $key }}" data-toggle="collapse">
        <div class="action">
            <buttton class="accordion-icon {{ ($key==0) ? '' :'collapsed' }}" data-toggle="collapse" data-target="#faq-q{{ $key }}" title="View Answer">{{ $faq->translateOrDefault()->question }}</buttton>
        </div>
    </div>
    <div class="accordion-body collapse {{ ($key==0)?'show':'' }}" data-parent="#faqs" id="faq-q{{ $key }}">
        <div class="accordion-inner">
            @if(!empty($faq->faq_file_url))
            @if($faq->type == 'video')
            <div class="accordionVideo">
                <video class="embed-responsive-item videoThumb" controls style="width: 100%;">
                    <source src="{{$faq->faq_file_url}}">
                </video>
            </div>
            @endif
            @if($faq->type == 'image')
            <div class="accordionVideo">
                <img src="{{$faq->faq_file_url}}" alt="">
            </div>
            @endif
            @endif
            <p class="font-sm">
                {!! $faq->translateOrDefault()->content !!}
            </p>
        </div>
    </div>
</div>
@empty

@endforelse

<div class="d-flex align-items-center paginationBottom justify-content-end ">
    <nav aria-label="Page navigation example ">
        <div id="pagination"> {{{ $faqs->links() }}}</div>
    </nav>
</div>
<script >
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        $("#faqs").html('{{pageLoader()}}');
        var url = $(this).attr('href');
        faqList(url);
    });
</script>
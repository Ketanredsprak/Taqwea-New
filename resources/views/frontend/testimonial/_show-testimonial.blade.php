@if(!empty($testimonials) && count($testimonials))
<section class="customerSection postion-relative sectionPad" id="testimonial">
    <div class="container">
        <div class="heading text-center">
            <h2 class="sectionHeading">{{ __('labels.customer_success_highlights') }}</h2>
            <p class="headingPera mb-0">{{ __('labels.we_are_proud_to_support') }}</p>
        </div>
        <div class="listSlider">
            @foreach($testimonials as $data)
            <div class="customerSlider-item">
                <div class="customerInfo bgwhite">
                    <div class="customerInfo__img">
                        <img src="{{ $data->testimonial_image_url }}" alt="{{ $data->translateOrDefault()->name }}" />
                    </div>
                    <div class="customerInfo__name">
                        <span class="txt"> {{ $data->translateOrDefault()->name }}</span>
                        <div class="userInfo__rating">
                            @if ($data->rating)
                            <div class="userInfo__rating d-flex align-items-center justify-content-center">
                                <div class="rateStar w-auto" data-rating="{{$data->rating}}"></div>
                            </div>
                            @endif
                        </div>
                        <p class="mb-0">
                            @php
                            $content = str_replace(array("\r\n", "\n"), "<br>", $data->translateOrDefault()->content);
                            @endphp
                            {{ substr($data->translateOrDefault()->content,0,90)}}...
                            <a href="javascript:void(0);" class="textPrimary" onclick="showReadMore('{{$content}}','{{$data->translateOrDefault()->name}}')">{{__('labels.read_more')}}</a>
                        </p>
                        <div class="font-bd"> {{convertDateToTz($data->created_at, 'UTC', 'l, d F Y')}}</div>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
</section>
<div class="modal fade" id="readMoreModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--fullText">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title"></h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <p>
                </p>
            </div>
        </div>
    </div>
</div>
@endif
    <div class="modal-dialog modal-md modal-dialog-centered commonModal commonModal--newTopic">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">{{ (@$topic->id)?__('labels.update_topic'):__('labels.add_new_topic') }}</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="" id="addTopicForm" novalidate>
                    <input type="hidden" name="topic_id" value="{{ @$topic->id }}">
                    <div class="boxContent-nav text-center">
                        {{-- <ul class="nav nav-pills d-inline-flex">
                            <li class="nav-item">
                                <a class="nav-link active" data-toggle="pill" href="#step2-english" onclick="changeTopicLanguage('en')">English</a>
                            </li>
                            <li class="nav-item">
                                <a class="nav-link" data-toggle="pill" href="#step2-arabic" onclick="changeTopicLanguage('ar')">Arabic(عربى)</a>
                            </li>
                        </ul> --}}
                    </div>
                    <div class="topic-language topic-lang-en">
                        <div class="form-group">
                            <label class="form-label">{{__('labels.title')}}</label>
                            <input type="text" name="en[topic_title]" dir="rtl" class="form-control" placeholder="{{__('labels.title')}}" value="{{ @$topic->topic_title }}" id="topic_title_en">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{__('labels.agenda')}}</label>
                            <textarea rows="3" name="en[topic_description]" dir="rtl" class="form-control mb-2" placeholder="{{__('labels.agenda')}}" id="topic_description_en">{{ @$topic->topic_description }}</textarea>
                        </div>
                        <div class="form-group moreOption">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-label">{{__('labels.highlighted_option')}}</label>
                                <a href="javascript:void(0);" class="linkPrimary font-bd text-uppercase add-more" onclick="addMoreSubTopic('en')">+{{__('labels.add_more')}}</a>
                            </div>
                            <div id="more-option-en">
                                @if(@$topic->subTopics)
                                @forelse(@$topic->subTopics as $key => $subTopic)
                                @if(@$subTopic->sub_topic)
                                @if($subTopic->translate('en'))
                                <div class="form-group form-group-icon mb-2 closeOption">
                                    <input type="text" name="sub_topics[]" dir="rtl" class="form-control" placeholder="{{__('labels.enter_option')}}" value="{{ $subTopic->sub_topic }}">
                                    <a href="javascript:void(0);" class="icon remove-btn deleteSubTopic" data-id="{{ $subTopic->id }}"><span class="icon-close"></span></a>
                                </div>
                                @endif
                                @endif
                                @empty

                                @endforelse
                                @else
                                <div class="form-group form-group-icon mb-2 closeOption">
                                    <input type="text" name="sub_topics[]" dir="rtl" class="form-control" placeholder="{{__('labels.enter_option')}}" value="">
                                </div>
                                @endif
                            </div>
                        </div>
                    </div>
                    <div class="topic-language topic-lang-ar" style="display: none;">
                        <div class="form-group">
                            <label class="form-label">{{__('labels.title')}}</label>
                            <input type="text" name="ar[topic_title]" dir="rtl" class="form-control" placeholder="{{__('labels.title')}}" value="{{ @$topic->{'topic_title:ar'} }}" id="topic_title_ar">
                        </div>
                        <div class="form-group">
                            <label class="form-label">{{__('labels.agenda')}}</label>
                            <textarea rows="3" name="ar[topic_description]" dir="rtl" class="form-control mb-2" placeholder="{{__('labels.agenda')}}" id="topic_description_ar">{{ @$topic->{'topic_description:ar'} }}</textarea>
                        </div>
                        {{-- <div class="form-group moreOption">
                            <div class="d-flex align-items-center justify-content-between">
                                <label class="form-label">{{__('labels.highlighted_option')}}</label>
                                <a href="javascript:void(0);" class="linkPrimary font-bd text-uppercase add-more" onclick="addMoreSubTopic('ar')">+{{__('labels.add_more')}}</a>
                            </div>
                            <div id="more-option-ar">
                                @if(@$topic->subTopics)
                                @forelse(@$topic->subTopics as $key => $subTopic)
                                @if($subTopic->translate('ar'))
                                <div class="form-group form-group-icon mb-2 closeOption">
                                    <input type="text" name="sub_topics_ar[]" dir="rtl" class="form-control" placeholder="{{__('labels.enter_option')}}" value="{{ $subTopic->{'sub_topic:ar'} }}">
                                    <a href="javascript:void(0);" class="icon remove-btn deleteSubTopic" data-id="{{ $subTopic->id }}"><span class="icon-close"></span></a>
                                </div>
                                @endif
                                @empty

                                @endforelse
                                @else
                                <div class="form-group form-group-icon mb-2 closeOption">
                                    <input type="text" name="sub_topics_ar[]" dir="rtl" class="form-control" placeholder="{{__('labels.enter_option')}}" value="">
                                </div>
                                @endif
                            </div>
                        </div> --}}
                    </div>
                    <div class="btn-row">
                        <button type="submit" id="addTopicBtn" class="btn btn-primary btn-block btn-lg ripple-effect mw-300 m-auto">{{ (@$topic->id)?__('labels.update'):__('labels.add') }}</button>
                    </div>
                </form>
                {!! JsValidator::formRequest('App\Http\Requests\Tutor\AddTopicRequest', '#addTopicForm') !!}
            </div>
        </div>
    </div>
    <script>
        $("#topic_title_en").keyup(function () {
    var val = $(this).val();
    $("#topic_title_ar").val(val);
});

$("#topic_description_en").keyup(function () {
    var val = $(this).val();
    $("#topic_description_ar").val(val);
});
    </script>
    {{-- <script type="text/javascript" src="{{asset('assets/js/frontend/tutor/topic.js')}}"></script> --}}



@php $count = 1 @endphp
@forelse($topics as $topic)
<div class="accordion-item">
    <div class="accordion-head w-100 text-left" data-target="#topic-{{ $count }}" data-toggle="collapse">
        <div class="action">
            <buttton class="accordion-icon" data-toggle="collapse" data-target="#topic-{{ $count }}" title="">{{ $count }}: {{ $topic->translateOrDefault()->topic_title }}
            </buttton>
            <a href="javascript:void(0)" class="edit-link" onclick="showTopicList({{ $topic->class_id }},{{ $topic->id }})"><em class="icon-pencil"></em></a>
        </div>
    </div>
    <div class="accordion-body collapse {{ ($count==1)?'show':'' }}" data-parent="#topics" id="topic-{{ $count }}">
        <div class="accordion-inner">
            <p>
                {{ $topic->translateOrDefault()->topic_description }}
            </p>
            <ul class="list-unstyled">
              
                @forelse(@$topic->subTopics as $subTopic)
                @if(@$subTopic->sub_topic && @$subTopic->translations[0]->language == config('app.locale'))
                <li>{{ @$subTopic->translateOrDefault()->sub_topic }}</li>
                @endif
                @empty

                @endforelse
            </ul>
        </div>
    </div>
</div>
@php $count++ @endphp
@empty

@endforelse
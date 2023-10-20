@forelse($students as $student)
<li class="leftSide-searchBox d-flex justify-content-between align-items-center">
    <div class="userInfo d-flex align-items-center">
        <div class="userInfo-userImg">
            <img src="{{$student->student->profile_image_url}}" alt="user" class="img-fluid" />
        </div>
        <h5 class="font-bd mb-0 text-truncate">{{$student->student->name}}</h5>
        <h5 class="student_id{{$loop->index}}" style="display:none;">{{$student->student_id}}</h5>
        <h5 class="class_id{{$loop->index}}" style="display:none;">{{$student->class_id}}</h5>

    </div>
    <a href="javascript:void(0);" onclick="getFindStudent({{$student->student_id}},{{$student->class_id}})" class="font-bd linkPrimary">{{__('labels.give_feedback')}}</a>
</li>
@empty
<li>
    <div class="alert alert-danger font-rg">{{ __('labels.record_not_found') }}</div>
</li>
@endforelse
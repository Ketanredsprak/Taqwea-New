@if(empty($student->rating))
<div class="rightSide text-center commonBox">
    <div class="userInfo">
        <img src="{{$student->student->profile_image_url}}" alt="user" class="img-fluid" />
    </div>
    <h5 class="font-bd">{{__('labels.how_was_your_experience_with')}} {{$student->student->name}}?</h5>
    <div class="d-flex">
        <div class="ratingStar w-auto"></div>
    </div>
    <div class="rightSide-txt">
        <form action="{{route('tutor.feedback.store')}}" method="POST" id="feedback-frm">
            {{csrf_field()}}
            <input type="hidden" id="student_id" name="id" value="{{$student->student_id}}">
            <input type="hidden" id="class_id" name="class_id" value="{{$student->class_id}}">
            <div class="form-group mb-0 text-left">
                <label class="form-label">{{__('labels.write_a_review')}}</label>
                <textarea id="review" name="review" class="form-control" dir="rtl"></textarea>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
            <div>
                <button id="ratingSubmit" type="button" class="btn btn-primary btn-lg w-50 ripple-effect">Submit</button>
            </div>
        </form>
        {!! JsValidator::formRequest('App\Http\Requests\Tutor\FeedbackRequest', '#feedback-frm') !!}
    </div>
    @else
    <div class="rightSide text-center commonBox">
        <div class="userInfo">
            <img src="{{$student->student->profile_image_url}}" alt="user" class="img-fluid" />
        </div>
        <h5 class="font-bd">{{__('labels.how_was_your_experience_with')}} {{$student->student->name}}?</h5>
        <div class="userInfo__rating d-flex align-items-center justify-content-center">
            <div class="rateStar1 w-auto" data-rating="{{$student->rating->rating}}"></div>
        </div>
        <div class="rightSide-txt">
            <div class="form-group mb-0 text-left">
                <label class="form-label">{{__('labels.write_a_review')}}</label>
                <textarea id="review" name="review" class="form-control" dir="rtl" disabled>{{$student->rating->review}}</textarea>
            </div>
            &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
        </div>
        @endif

        <!-- <p class="font-rg textGray mb-0">Do you want to raise dispute?</p> -->
        <!-- <a href="javascript:void(0);" class="font-bd textDanger" onclick="rasieDisputeModal();">Raise Dispute</a> -->
    </div>
    <script type="text/javascript" src="{{asset('assets/js/frontend/tutor/feedback/tutor-feedback.js')}}"></script>

<!-- view student modal -->
<div class="modal fade" tabindex="-1" id="studentDetails">
    <div class="modal-dialog" role="document">
        <div class="modal-content">

            <div class="modal-header">
                <h5 class="modal-title">Student Details</h5>
                <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                    <em class="icon ni ni-cross"></em>
                </a>
            </div>
            <div class="modal-body">
                <div class="user-card customerInfo user-card-s2 mb-4">
                    <div class="user-avatar lg bg-primary">
                        <img src="{{$result->profile_image_url}}" alt="Profile">
                    </div>
                    <div class="user-info ">
                        <h5>{{$result->name}}</h5>
                        <span class="sub-text">{{$result->email}}</span>
                    </div>
                </div>
                <h6 class="overline-title-alt mb-2">Information</h6>
                <div class="row g-3">
                    <div class="col-6">
                        <span class="sub-text">Date of Registration</span>
                        <span>{{$result->created_at->format('d/m/Y')}}</span>
                    </div>
                    <div class="col-6">
                        <span class="sub-text">Rating</span>
                        <span>
                            <div class="ratingstarIcons">
                                @php
                                $rating = isset($result->ratingReview->rating) ? $result->ratingReview->rating : '';
                                @endphp
                                @for($i = 1;$i<=5;$i++) @if($i <=$rating) <em class="ni ni-star-fill"></em>
                                    @else
                                    <em class="ni ni-star"></em>
                                    @endif
                                    @endfor
                            </div>
                        </span>
                    </div>
                    <div class="col-6">
                        <span class="sub-text">Refund/Dispute</span>
                        @if($result->status === 'active')
                        <span class="text-success">{{ucfirst($result->status)}}</span>
                        @else
                        <span class="text-danger">{{ucfirst($result->status)}}</span>
                        @endif
                    </div>
                    <div class="col-12">
                        <span class="sub-text">About me</span>
                        <span>{{$result->bio}}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
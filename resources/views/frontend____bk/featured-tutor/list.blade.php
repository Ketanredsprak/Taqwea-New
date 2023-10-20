<div class="common-shadow bg-white p-4">
    <div class="common-table">
        <div class="table-responsive">
            <table class="table">
                <thead>
                    <tr>
                        <th>{{ __('labels.name') }}</th>
                        <th>{{ __('labels.experience') }}</th>
                        <th>{{ __('labels.classes') }}</th>
                        <th>{{ __('labels.webinars') }}</th>
                        <th>{{ __('labels.blogs') }}</th>
                        <th></th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tutors as $tutor)
                    <tr>
                        <td>
                            <div class="userInfo d-flex align-items-center">
                                <div class="userInfo_img">
                                    <img src="{{ $tutor->profile_image_url }}" class="rounded-circle" alt="user-image">
                                </div>
                                <div class="userInfo_detail">
                                    <h5 class="userInfo_name">{{$tutor->translateOrDefault()->name}}</h5>
                                    <div class="userInfo_rating">
                                        <div class="userInfo__rating d-flex">
                                            <div class="rateStar w-auto" data-rating="{{@$tutor->rating}}"></div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                        <td>{{ isset($tutor->tutor->experience) ? $tutor->tutor->experience : 0}} {{ (@$tutor->tutor->experience>1)?'Years':'Year' }}</td>
                        <td>{{$tutor->total_classes}}</td>
                        <td>{{$tutor->total_webinars}}</td>
                        <td>{{$tutor->total_blogs}}</td>
                        <td>
                            <div class="dropdown">
                                <a class="dropdown-toggle" href="#" role="button" id="action" data-toggle="dropdown">
                                    <span class="icon-ellipse-v"></span>
                                </a>

                                <div class="dropdown-menu" aria-labelledby="action">
                                    <a class="dropdown-item textGray font-bd" href="{{ route('featured.tutors.show', ['tutor' => $tutor->id]) }}">{{ __('labels.view_details') }}</a>
                                    <a class="dropdown-item textGray font-bd" href="{{route('classes.schedules')}}?tutor={{ Crypt::encrypt($tutor->id) }}">{{ __('labels.view_courses') }}</a>
                                    
                                </div>
                            </div>
                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td colspan="6">
                            <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                        </td>
                    </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>
<div class="d-flex align-items-center paginationBottom justify-content-end ">
    <nav aria-label="Page navigation example ">
        <div id="pagination"> {{ $tutors->links() }}</div>
    </nav>
</div>
<script>
    $('#pagination a').on('click', function(e) {
        e.preventDefault();
        var url = $(this).attr('href');
        tutorList(url);
    });
    $(".rateStar").each(function(index) {
        var rating = $(this).attr("data-rating");
        $(this).rateYo({
            normalFill: "#E1E1E1",
            ratedFill: "#FFC100",
            rating: rating,
            readOnly: true,
            spacing: "2px"
        });
    });
</script>
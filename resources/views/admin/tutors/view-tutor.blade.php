@extends('layouts.admin.app')
@section('title','Tutor Details')
@section('content')
@push('css')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.css" />
@endpush
<div class="nk-content viewManageDoctor">
    <div class="container-xl wide-lg">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm pageHead">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{route('adminDashboard')}}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{route('tutors.index')}}">TUTOR MANAGEMENT</a></li>
                                    <li class="breadcrumb-item active">Tutor Details</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Tutor Details</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{route('tutors.index')}}" class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em class="icon ni ni-arrow-left"></em><span>Back</span></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-between -->
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="card-content">
                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#otherInfo" role="tab" aria-controls="otherInfo" aria-selected="false">
                                            <span>Availability Schedule</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#tutorDetails" role="tab" aria-controls="tutorDetails" aria-selected="true">
                                            <span>Tutor Details</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#blog" role="tab" aria-controls="blog" aria-selected="false">
                                            <span>Blogs</span>
                                        </a>
                                    </li>
                                    <li class="nav-item nav-item-trigger d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em class="icon ni ni-user-list-fill"></em></a>
                                    </li>
                                </ul><!-- .nav-tabs -->
                                <div class="tab-content mt-0" id="pills-tabContent">
                                    <div class="tab-pane mt-0 fade" id="tutorDetails" role="tabpanel" aria-labelledby="otherInfo">
                                        <div class="card-inner">
                                            <div class="nk-block">
                                                <div class="profile-ud-list mw-100">
                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider">
                                                            <span class="profile-ud-label">Levels:</span>
                                                            <span class="profile-ud-value">
                                                                @foreach($user->levels as $data)
                                                                {{ $loop->first ? '' : ', ' }}
                                                                {{$data->name}}
                                                                @endforeach
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider">
                                                            <span class="profile-ud-label">Grades:</span>
                                                            <span class="profile-ud-value">
                                                                @foreach($user->grades as $data)
                                                                {{ $loop->first ? '' : ', ' }}
                                                                {{$data->grade_name}}
                                                                @endforeach
                                                            </span>
                                                        </div>
                                                    </div>

                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider">
                                                            <span class="profile-ud-label">Subjects:</span>
                                                            <span class="profile-ud-value">
                                                                @foreach($user->subjects as $data)
                                                                {{$loop->first ? '' : ', '}}
                                                                {{$data->subject_name}}
                                                                @endforeach
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider">
                                                            <span class="profile-ud-label">Verification Status:</span>
                                                            @php
                                                            $class= '';
                                                            $approvalStatus = 'Approved';
                                                            if ($user->approval_status == 'approved') {
                                                            $class = 'text-success';
                                                            } elseif ($user->approval_status == 'rejected') {
                                                            $class = 'text-danger';
                                                            $approvalStatus = "Rejected";
                                                            } else {
                                                            $class = 'text-muted';
                                                            $approvalStatus = "Pending";
                                                            }
                                                            @endphp
                                                            <span class="profile-ud-value {{$class}}">{{$approvalStatus}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider">
                                                            <span class="profile-ud-label">Status:</span>
                                                            <span class="profile-ud-value">
                                                                @php
                                                                $checked = '';
                                                                if ($user->status == 'active') {
                                                                $checked = 'checked = checked';
                                                                }
                                                                @endphp
                                                                <div class="custom-control custom-switch">
                                                                    <input type="checkbox" class="custom-control-input" onchange="updateStatus('{{$user->id}}')" id="tutor-status" value="{{$user->id}}" {{$checked}}>
                                                                    <label class="custom-control-label" for="tutor-status"></label>
                                                                </div>
                                                            </span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-ud-item w-100 mb-3">
                                                        <span class="sub-text">About Me</span>
                                                        <p>{{$user->bio}}</p>
                                                    </div>
                                                </div><!-- .profile-ud-list -->
                                            </div><!-- .nk-block -->
                                            <div class="nk-divider divider md"></div>
                                            <div class="nk-block">
                                                <div class="nk-block-head">
                                                    <h5 class="title">Education</h5>
                                                </div><!-- .nk-block-head -->
                                                @foreach($user->educations as $data)
                                                <div class="profile-ud-list educationList">
                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider">
                                                            <span class="profile-ud-label">Degree</span>
                                                            <span class="profile-ud-value">{{$data->degree}}</span>
                                                        </div>
                                                    </div>
                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider">
                                                            <span class="profile-ud-label">University</span>
                                                            <span class="profile-ud-value">{{$data->university}}</span>
                                                        </div>
                                                    </div>
                                                    @if($data->certificate)
                                                    <div class="d-inline-block align-items-center education-action">
                                                   
                                                        <button onclick="downloadEducationCertification('{{$data->id}}')" title="download"><em class="icon ni ni-download" ></em></button>
                                                        @if ($data->certificate_type == 'pdf')
                                                            <a href="{{$data->certificate_url}}" target="_blank" class="viewDoc">
                                                                <em class="icon ni ni-eye"></em>
                                                            </a>
                                                        @else
                                                            <a href="#degreeView" data-link="{{getImageUrl($data->certificate)}}" data-certificate="{{$data->certificate}}" data-toggle="modal" class="viewDoc">
                                                                <em class="icon ni ni-eye"></em>
                                                            </a>
                                                        @endif   
                                                    </div>
                                                    @endif
                                                </div>
                                                @endforeach
                                            </div>

                                            <div class="nk-divider divider md"></div>
                                            <div class="nk-block">
                                                <div class="nk-block-head">
                                                    <h5 class="title">Certificate</h5>
                                                </div><!-- .nk-block-head -->
                                                <div class="profile-ud-list mw-100">
                                                    @foreach($user->certificates as $data)
                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider d-block">
                                                            @if (getExtensionFromKey($data->certificate) == 'pdf')
                                                            <img src="{{asset('assets/images/pdf-thumb.jpg')}}" alt="Certificate">
                                                            @else
                                                            <img src="{{$data->certificate_url}}" alt="Certificate">
                                                            @endif
                                                            <div class="d-inline-flex align-items-center action">
                                                                <span class="profile-ud-value d-block text-left">{{$data->certificate_name}}</span>
                                                                @if($data->certificate)
                                                                <button onclick="downloadExperienceCertification('{{$data->id}}')" title="Download"><em class="icon ni ni-download" ></em></button>
                                                                @endif
                                                            </div>
                                                        </div>
                                                    </div>
                                                    @endforeach
                                                </div><!-- .profile-ud-list -->
                                            </div>
                                            <!-- <div class="nk-divider divider md"></div> -->
                                            <!-- <div class="nk-block">
                                                <div class="nk-block-head">
                                                    <h5 class="title">ID</h5>
                                                </div>
                                                <div class="profile-ud-list mw-100">
                                                    <div class="profile-ud-item">
                                                        <div class="profile-ud wider d-block">
                                                            <img src="{{$user->tutor->id_card_url}}" alt="Certificate">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div> -->
                                        </div>

                                    </div>
                                    <div class="tab-pane mt-0 fade active show" id="otherInfo" role="tabpanel" aria-labelledby="otherInfo">
                                        <div id='calendar' class="fullCalendar"></div>
                                    </div>
                                    <div class="tab-pane mt-0 fade" id="blog" role="tabpanel" aria-labelledby="blog">
                                        <div class="blogs">
                                            @foreach($user->blogs as $data)
                                            <div class="blogs__list">
                                                @if((isset($data->type) && $data->type == 'image'))
                                                <div class="img">
                                                    <img src="{{ $data->media_thumb_url }}" class="img-fluid" alt="blog">
                                                </div>
                                                @elseif ((isset($data->type) && $data->type == 'video'))
                                                <div class="blogVideo">
                                                    <video controls="">
                                                        <source src="{{ $data->media_url }}">
                                                    </video>
                                                </div>
                                                @else
                                                <div class="document">
                                                    <img src="{{ $data->media_thumb_url }}" alt="blog">
                                                </div>
                                                @endif
                                                <div class="blogs__list__head d-flex justify-content-between">
                                                    <h4>{{$data->blog_title}}</h4>
                                                    @php
                                                    $checked = '';
                                                    if ($data->status == 'active') {
                                                    $checked = 'checked = checked';
                                                    }
                                                    @endphp
                                                    <div class="custom-control custom-switch">
                                                        <input type="checkbox" class="custom-control-input" onchange="updateBlogStatus(this, '{{$data->id}}')" id="customSwitch{{$data->id}}" {{$checked}}>
                                                        <label class="custom-control-label" for="customSwitch{{$data->id}}"></label>
                                                    </div>
                                                </div>
                                                <p>{!! $data->blog_description !!}</p>
                                            </div>
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card-content -->
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-right toggle-break-lg" data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true" data-toggle-body="true">
                                <div class="card-inner-group" data-simplebar>
                                    <div class="card-inner">
                                        <div class="user-card user-card-s2">
                                            <div class="user-avatar lg bg-primary">
                                                <img src="{{$user->profile_image_url}}" alt="Doctor's Profile Image">
                                            </div>
                                            <div class="user-info">
                                                <!--  <div class="badge badge-outline-light badge-pill ucap">
                                                                    Pediatrician</div> -->
                                                <h5>{{$user->name}}</h5>
                                                <span class="sub-text">{{$user->email}}</span>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                    <div class="card-inner">
                                        <h6 class="overline-title-alt mb-2">Personal Information</h6>
                                        <div class="row g-3">
                                            <div class="col-6">
                                                <span class="sub-text">Experience:</span>
                                                <span>{{($user->tutor) ? $user->tutor->experience : 0 }}</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Mobile Number:</span>
                                                <span>{{$user->phone_number}}</span>
                                            </div>

                                            <div class="col-12">
                                                <span class="sub-text">Address:</span>
                                                <span>{{$user->address}}</span>
                                            </div>
                                        </div>
                                    </div><!-- .card-inner -->
                                </div><!-- .card-inner -->
                            </div><!-- .card-aside -->
                        </div><!-- .card-aside-wrap -->
                    </div><!-- .card -->
                </div><!-- .nk-block -->
            </div>
        </div>
    </div>
</div>

<!-- @@ Profile Edit Modal @e -->
<div class="modal fade" tabindex="-1" role="dialog" id="eventDetails" data-backdrop="static">
</div><!-- .modal -->

<div class="modal fade" tabindex="-1" id="degreeView">
    <div class="modal-dialog" role="degreeView">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-0">Document View</h5>
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            </div>
            <div class="modal-body text-center">
                <img src="" class="img-fluid" alt="Certificate">
                <p id="data"></p>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
@endsection
@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/fullcalendar@5.10.1/main.js"></script>
<script>
    var tutorId = {{$user->id}}
</script>
<script src="{{asset('assets/js/admin/tutors/view-tutor.js')}}"></script>
@endpush
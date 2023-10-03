@extends('layouts.frontend.app')
@section('title',__('labels.search'))
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
@section('content')
<main class="mainContent">
    <div class="searchResult bg-green">
        <div class="container">
            <div class="searchResult-box">
                <div class="common-tabs">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a class="nav-link active" data-toggle="tab" href="#tutor">Tutor <span class="number">{{count($search['tutors'])}}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#class">Class <span class="number">{{count($search['classes'])}}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#webinar">Webinar <span class="number">{{count($search['webinars'])}}</span></a>
                        </li>
                        <li class="nav-item">
                            <a class="nav-link" data-toggle="tab" href="#blog">Blog <span class="number">{{count($search['blogs'])}}</span></a>
                        </li>
                    </ul>
                </div>
                <div class="tab-content">
                    <div class="tab-pane fade show active" id="tutor" role="tabpanel">
                        
                        <div class="searchList common-table" nice-scroll="" style="overflow: hidden; outline: currentcolor none medium;" tabindex="3">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Name</th>
                                            <th>Experience</th>
                                            <th>Classes</th>
                                            <th>Webinars</th>
                                            <th>Blogs</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse ($search['tutors'] as $tutor)
                                            <tr>
                                                <td>
                                                    <div class="userInfo d-flex align-items-center">
                                                        <div class="userInfo_img">
                                                            <img src="{{getImageUrl($tutor->image_url)}}" class="rounded-circle" alt="user-image">
                                                        </div>
                                                        <div class="userInfo_detail">
                                                            <a href="{{ route('featured.tutors.show',['tutor'=>$tutor->id])}}" class="linkBlack">
                                                                <h5 class="userInfo_name">{{$tutor->name}}</h5>
                                                            </a>
                                                            <div class="userInfo_rating">
                                                                <div class="rateStar" data-rateyo-rating="{{($tutor->rating ?? '0')}}" data-rateyo-num-stars="5"></div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                                <td>{{((isset($tutor->experience) && $tutor->experience > 0) ? $tutor->experience.'+' : $tutor->experience) ?? 0}}</td>
                                                <td>{{$tutor->total_classes ?? 0}}</td>
                                                <td>{{$tutor->total_webinars ?? 0}}</td>
                                                <td>{{$tutor->total_blogs ?? 0}}</td> 
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="6">
                                                    <div class="row">
                                                        <div class="col-12">
                                                            <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                            @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="class" role="tabpanel">
                        
                        <div class="searchList common-table" nice-scroll="" style="overflow: hidden; outline: currentcolor none medium;" tabindex="5">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Class Name</th>
                                            <th>Tutor</th>
                                            <th>Date &amp; Time</th>
                                            <th>Amount</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($search['classes'] as $class)
                                        <tr>
                                            <td>
                                                <a href="{{route('classes/show',['class' => $class->slug])}}" class="linkBlack">
                                                    <div class="desc">{{$class->name}}</div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="userInfo_detail">
                                                    <h6 class="mb-0">{{$class->tutor->name}}</h6>
                                                    <div class="userInfo_rating">
                                                        <div class="rateStar" data-rateyo-rating="{{($class->rating ?? '0')}}" data-rateyo-num-stars="5"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$class->time}}</td>
                                            <td><span class="font-rg">{{__('labels.sar')}}</span> {{$class->amount}}</td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="webinar" role="tabpanel">
                        
                        <div class="searchList common-table" nice-scroll="" style="overflow: hidden; outline: currentcolor none medium;" tabindex="7">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Webinar Name</th>
                                            <th>Tutor</th>
                                            <th>Date &amp; Time</th>
                                            <th>Amount</th>
                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($search['webinars'] as $class)
                                        <tr>
                                            <td>
                                                <a href="{{route('webinars/show',['class' => $class->slug])}}" class="linkBlack">
                                                    <div class="desc">{{$class->name}}</div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="userInfo_detail">
                                                    <h6 class="mb-0">{{$class->tutor->name}}</h6>
                                                    <div class="userInfo_rating">
                                                        <div class="rateStar" data-rateyo-rating="{{($class->rating ?? '0')}}" data-rateyo-num-stars="5"></div> 
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$class->time}}</td>
                                            <td><span class="font-rg">{{__('labels.sar')}}</span> {{$class->amount}}</td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="5">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                    <div class="tab-pane fade" id="blog" role="tabpanel">
                        
                        <div class="searchList common-table" nice-scroll="" style="overflow: hidden; outline: currentcolor none medium;" tabindex="9">
                            <div class="table-responsive">
                                <table class="table">
                                    <thead>
                                        <tr>
                                            <th>Blog Name</th>
                                            <th>Tutor</th>
                                            <th>Created On</th>
                                            <th>Amount</th>

                                            <th></th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                    @forelse ($search['blogs'] as $blog)
                                        <tr>
                                            <td>
                                                <a href="{{route('blog/show', ['blog' => $blog->slug])}}" class="linkBlack">
                                                    <div class="desc">{{$blog->name}}</div>
                                                </a>
                                            </td>
                                            <td>
                                                <div class="userInfo_detail">
                                                    <h6 class="mb-0">{{$blog->tutor->name}}</h6>
                                                    <div class="userInfo_rating">
                                                        <div class="rateStar" data-rateyo-rating="{{($blog->rating ?? '0')}}" data-rateyo-num-stars="5"></div>
                                                    </div>
                                                </div>
                                            </td>
                                            <td>{{$blog->time}}</td>
                                            <td><span class="font-rg">{{__('labels.sar')}}</span> {{$blog->amount}}</td>
                                            
                                        </tr>
                                    @empty
                                        <tr>
                                            <td colspan="4">
                                                <div class="row">
                                                    <div class="col-12">
                                                        <div class="alert alert-danger">{{ __('labels.record_not_found') }}</div>
                                                    </div>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforelse
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript">
    // rateStar
    $(function () {
        $('.rateStar').rateYo({
            normalFill: "#E1E1E1",
            ratedFill: "#FFC100",
            readOnly: true,
            spacing: "2px",
            starWidth: "15px"
        });
    });
</script>
@endpush
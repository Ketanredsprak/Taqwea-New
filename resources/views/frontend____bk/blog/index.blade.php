@extends('layouts.frontend.app')
@section('title',__('labels.blogs'))
@section('content')
<main class="mainContent">
    <div class="blogPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.blogs') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.blogs') }}</h3>
            </div>
        </section>
        <div class="container">
            <div class="d-flex align-items-center mb-3">
                <button class="btn btn-primary ripple-effect ml-auto d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
            </div>
            <div class="flexRow d-xl-flex">
                <div class="column-1">
                    <div class="sideMenu common-shadow bg-white">
                        <a href="javascript:void(0);" id="closeMenu" class="linkPrimary closeMenu d-xl-none">&times;</a>
                        <div class="sideMenu-box">
                            <div class="sideMenu-box_head">
                                <div class=" d-flex align-items-center justify-content-between">
                                    <h4 class="font-eb mb-0">{{ __('labels.filter') }}</h4>
                                    <a href="javascript:void(0);" class="linkPrimary font-eb text-uppercase" onclick="clearAll()">{{ __('labels.clear_all') }}</a>
                                </div>
                                <ul class="list-inline mb-0" id="filterLabels">
                                </ul>
                            </div>
                            <form action="javascript:void(0)" method="get" id="filterForm">
                                <div class="sideMenu-box_list">
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-2">
                                            {{__('labels.category')}}
                                        </a>
                                        <div class="collapse show" id="listItem-2">
                                            <ul class="list-unstyled mb-0">
                                                @forelse($categories as $key => $category)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="category[]" value="{{ $category->id }}" class="custom-control-input" id="{{ str_replace(' ','___',$category->name) }}" onchange="blogList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$category->name) }}">{{ $category->name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-4">
                                            {{__('labels.class_level')}}
                                        </a>
                                        <div class="collapse" id="listItem-4">
                                            <ul class="list-unstyled mb-0">
                                                @php $levels = getSubCategory($education->id); @endphp
                                                @forelse($levels as $key => $level)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="level[]" value="{{ $level->id }}" class="custom-control-input" id="{{ str_replace(' ','___',$level->name) }}" onchange="blogList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$level->name) }}">{{ $level->name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-3">
                                            {{__('labels.grade')}}
                                        </a>
                                        <div class="collapse" id="listItem-3">
                                            <ul class="list-unstyled mb-0">
                                                @forelse($grades as $key => $grade)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="grade[]" value="{{ $grade->id }}" class="custom-control-input" id="{{ str_replace(' ','___',$grade->grade_name) }}" onchange="blogList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$grade->grade_name) }}">{{ $grade->grade_name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-7">
                                            {{ __('labels.subjects') }}
                                        </a>
                                        <div class="collapse" id="listItem-7">
                                            <ul class="list-unstyled mb-0">
                                                @forelse($subjects as $key => $subject)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="subject[]" value="{{ $subject->id }}" class="custom-control-input" id="{{ str_replace(' ','___',$subject->subject_name) }}" onchange="blogList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$subject->subject_name) }}">{{ $subject->subject_name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-5">
                                            {{__('labels.general_knowledge')}}
                                        </a>
                                        <div class="collapse" id="listItem-5">
                                            <ul class="list-unstyled mb-0">
                                                @php $levels = getSubCategory($generalKnowledge->id); @endphp
                                                @forelse($levels as $key => $level)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="gk_level[]" value="{{ $level->id }}" class="custom-control-input" id="{{ str_replace(' ','___',$level->name) }}" onchange="blogList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$level->name) }}">{{ $level->name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-6">
                                            {{__('labels.language')}}
                                        </a>
                                        <div class="collapse" id="listItem-6">
                                            <ul class="list-unstyled mb-0">
                                                @php $levels = getSubCategory($language->id); @endphp
                                                @forelse($levels as $key => $level)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="language_level[]" value="{{ $level->id }}" class="custom-control-input" id="___{{ str_replace(' ','___',$level->name) }}" onchange="blogList()">
                                                        <label class="custom-control-label" for="___{{ str_replace(' ','___',$level->name) }}">{{ $level->name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" aria-expanded="true" href="#listItem-8">
                                            {{ __('labels.price') }}
                                        </a>
                                        <div class="collapse" id="listItem-8">
                                            <ul class="list-unstyled mb-0" id="priceFilter">
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="price" class="custom-control-input" value="" id="rate-00" onchange="clearFilter()">
                                                        <label class="custom-control-label" for="rate-00">{{ __('labels.all') }}</label>
                                                    </div>
                                                </li>
                                                @php
                                                $loop = ceil($maxPrice/100);
                                                $start = 0;
                                                @endphp

                                                @for ($i = 0; $i <= $loop; $i++) <li>
                                                    @php
                                                    $priceData = getPriceText($start);
                                                    @endphp
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="price" class="custom-control-input" value="{{ $priceData[0] }}" id="{{ str_replace(' ','___',str_replace('+','',$priceData[1])) }}" onchange="blogList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',str_replace('+','',$priceData[1])) }}">{{ $priceData[1] }}</label>
                                                    </div>
                                                    </li>
                                                    @php
                                                    if ($start==500) {
                                                    break;
                                                    }
                                                    $start = $priceData[2]
                                                    @endphp
                                                    @endfor
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
                <div class="column-2" id="blogList">

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script >
    var tutor_id = "{{ $tutor_id }}";
</script>
<script type="text/javascript" src="{{asset('assets/js/frontend/blog.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/cart.js')}}"></script>
@endpush
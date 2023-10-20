@extends('layouts.frontend.app')
@section('title', $title)
@section('content')
<main class="mainContent">
    <div class="classListPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ $title }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ $title }}</h3>
            </div>
        </section>
        <div class="container">
            <div class="d-flex align-items-center mb-3">
                <div class="sortBy ml-auto d-flex align-items-center">
                    <span class="textGray font-bd text-nowrap pr-2">{{ __('labels.sort_by') }}:</span>
                    <select class="form-select" id="priceFilter" onchange="classesList()">
                        <option value="asc">{{ __('labels.price_low_to_high') }}</option>
                        <option value="desc">{{ __('labels.price_high_to_low') }}</option>
                    </select>
                </div>
                <button class="btn btn-primary ripple-effect ml-1 ml-sm-3 d-inline-flex d-xl-none" id="sideMenuToggle"><span class="icon-menu"></span></button>
            </div>
            <div class="flexRow d-xl-flex">
                <div class="column-1">
                    <div class="sideMenu common-shadow bg-white">
                        <a href="javascript:void(0);" id="closeMenu" class="linkPrimary closeMenu d-xl-none">&times;</a>
                        <input type="hidden" id="classType" value="{{ $class_type }}">
                        <form action="javascript:void(0)" method="get" id="filterForm">
                            <div class="sideMenu-box">
                                <div class="sideMenu-box_head">
                                    <div class=" d-flex align-items-center justify-content-between">
                                        <h4 class="font-eb mb-0">{{ __('labels.filter') }}</h4>
                                        <a href="javascript:void(0);" class="linkPrimary font-eb text-uppercase" onclick="clearAll()">{{ __('labels.clear_all') }}</a>
                                    </div>
                                    <ul class="list-inline mb-0" id="filterLabels">
                                    </ul>
                                </div>
                                <div class="sideMenu-box_list">
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-1">
                                            {{ __('labels.gender') }}
                                        </a>
                                        <div class="collapse {{ isset($id) ? '' : 'show' }}" id="listItem-1">
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="male" name="gender" class="custom-control-input" id="Male" onchange="classesList()">
                                                        <label class="custom-control-label" for="Male">{{ __('labels.male') }}</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" value="female" name="gender" class="custom-control-input" id="Female" onchange="classesList()">
                                                        <label class="custom-control-label" for="Female">{{ __('labels.female') }}</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-2">
                                            {{ __('labels.class_level') }}
                                        </a>
                                        <div class="collapse {{ isset($id) ? 'show' : ''}}" id="listItem-2">
                                            <ul class="list-unstyled mb-0">
                                                @php $levels = getSubCategory($education->id);
                                                @endphp
                                                @forelse($levels as $key => $level)
                                                @php $checked = (isset($id) && $id == $level->id ?"checked=checked":"");@endphp
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="level[]" value="{{ $level->id }}" class="custom-control-input" id="{{ str_replace(' ','___',$level->name) }}" onchange="classesList()" {{$checked}}>
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$level->name) }}">{{ $level->translateOrDefault()->name }}</label>
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
                                                        <input type="checkbox" name="grade[]" value="{{ $grade->id }}" class="custom-control-input" id="{{ str_replace(' ','___',$grade->grade_name) }}" onchange="classesList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$grade->grade_name) }}">{{ $grade->translateOrDefault()->grade_name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                            <a href="javascript:void(0);" class="linkPrimary text-uppercase font-eb">{{ __('labels.show_more') }}</a>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" href="#listItem-4">
                                            {{ __('labels.subjects') }}
                                        </a>
                                        <div class="collapse" id="listItem-4">
                                            <ul class="list-unstyled mb-0">
                                                @forelse($category_subjects as $key => $subject)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="subject[]" value="{{ @$subject->subject_id }}" class="custom-control-input" id="{{ str_replace(' ','___',@$subject->subject_name) }}" onchange="classesList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$subject->subject_name) }}">{{@$subject->subject_name }}</label>
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
                                                        <input type="checkbox" name="gk_level[]" value="{{ $level->id }}" class="custom-control-input" id="{{ str_replace(' ','___',@$level->name) }}" onchange="classesList()">
                                                        <label class="custom-control-label" for="{{ str_replace(' ','___',$level->name) }}">{{ @$level->translateOrDefault()->name }}</label>
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
                                                        <input type="checkbox" name="language_level[]" value="{{ $level->id }}" class="custom-control-input" id="___{{ str_replace(' ','___',$level->name) }}" onchange="classesList()">
                                                        <label class="custom-control-label" for="___{{ str_replace(' ','___',$level->name) }}">{{ $level->translateOrDefault()->name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="column-2" id="classList">

                </div>
            </div>
        </div>
    </div>
</main>

@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/frontend/class.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/student/cart.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/booking-operations.js')}}"></script>
@endpush
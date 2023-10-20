@extends('layouts.frontend.app')
@section('title', __('labels.featured_tutors'))
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
@section('content')
<main class="mainContent">
    <div class="tutorsPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>
                            <li class="breadcrumb-item active" aria-current="page">{{ __('labels.featured_tutors') }}</li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{ __('labels.featured_tutors') }}</h3>
            </div>
        </section>
        <div class="container">
            <div class="flexRow d-xl-flex">
                <div class="column-1">
                    <div class="sideMenu common-shadow bg-white">
                        <a href="javascript:void(0);" id="closeMenu" class="linkPrimary closeMenu d-xl-none">&times;</a>
                        <form action="javascript:void(0)" method="get" id="filterForm">
                            <div class="sideMenu-box">
                                <div class="sideMenu-box_head">
                                    <div class=" d-flex align-items-center justify-content-between">
                                        <h4 class="font-eb mb-0">{{ __('labels.tutors') }}</h4>
                                        <a href="javascript:void(0);" class="linkPrimary font-eb text-uppercase" onclick="clearAll()">{{ __('labels.clear_all') }}</a>
                                    </div>
                                    <ul class="list-inline mb-0" id="filterLabels">
                                    </ul>
                                </div>
                                <div class="sideMenu-box_list">
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" aria-expanded="true" href="#listItem-2">
                                            {{ __('labels.class_level') }}
                                        </a>
                                        <div class="collapse" id="listItem-2">
                                            <ul class="list-unstyled mb-0">
                                                @php $levels = getSubCategory($education->id); @endphp
                                                @forelse($levels as $key => $level)
                                                @php $checked = (isset($id) && $id == $level->id ? "checked=checked":""); @endphp
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="level[]" value="{{ $level->id }}" class="custom-control-input" id="{{ $level->translateOrDefault()->name }}" onchange="tutorList()" {{$checked}}>
                                                        <label class="custom-control-label" for="{{ $level->translateOrDefault()->name }}">{{ $level->translateOrDefault()->name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" aria-expanded="true" href="#listItem-3">
                                            {{ __('labels.grade') }}
                                        </a>
                                        <div class="collapse" id="listItem-3">
                                            <ul class="list-unstyled mb-0">
                                                @forelse($grades as $key => $grade)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="grade[]" value="{{ $grade->id }}" class="custom-control-input" id="{{ $grade->translateOrDefault()->grade_name }}" onchange="tutorList()">
                                                        <label class="custom-control-label" for="{{ $grade->translateOrDefault()->grade_name }}">{{ $grade->translateOrDefault()->grade_name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" aria-expanded="true" href="#listItem-7">
                                            {{ __('labels.subjects') }}
                                        </a>
                                        <div class="collapse" id="listItem-7">
                                            <ul class="list-unstyled mb-0">
                                                @forelse($subjects as $key => $subject)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="subject[]" value="{{ $subject->id }}" class="custom-control-input" id="{{ $subject->translateOrDefault()->subject_name }}" onchange="tutorList()">
                                                        <label class="custom-control-label" for="{{ $subject->translateOrDefault()->subject_name }}">{{ $subject->translateOrDefault()->subject_name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" aria-expanded="true" href="#listItem-4">
                                            {{__('labels.general_knowledge')}}
                                        </a>
                                        <div class="collapse " id="listItem-4">
                                            <ul class="list-unstyled mb-0">
                                                @php $levels = getSubCategory($generalKnowledge->id); @endphp
                                                @forelse($levels as $key => $level)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="generalknowledge[]" value="{{ $level->id }}" class="custom-control-input" id="{{ $level->translateOrDefault()->name }}" onchange="tutorList()">
                                                        <label class="custom-control-label" for="{{ $level->translateOrDefault()->name }}">{{ $level->translateOrDefault()->name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" aria-expanded="true" href="#listItem-5">
                                            {{__('labels.language')}}
                                        </a>
                                        <div class="collapse " id="listItem-5">
                                            <ul class="list-unstyled mb-0">
                                                @php $languages = getSubCategory($language->id); @endphp
                                                @forelse($languages as $key => $language)
                                                <li>
                                                    <div class="custom-control custom-checkbox">
                                                        <input type="checkbox" name="language[]" value="{{ $language->id }}" class="custom-control-input" id="{{ $language->name }}" onchange="tutorList()">
                                                        <label class="custom-control-label" for="{{ $language->name }}">{{ $language->name }}</label>
                                                    </div>
                                                </li>
                                                @empty

                                                @endforelse
                                            </ul>
                                        </div>
                                    </div>
                                    <div class="listItem">
                                        <a class="font-eb" data-toggle="collapse" aria-expanded="true" href="#listItem-6">
                                            {{ __('labels.experience') }}
                                        </a>
                                        <div class="collapse show" id="listItem-6">
                                            <ul class="list-unstyled mb-0">
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="experience" class="custom-control-input" value="" id="experiance-0" onchange="tutorList()">
                                                        <label class="custom-control-label" for="experiance-0">All</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="experience" class="custom-control-input" value="0,1" id="0-1" onchange="tutorList()">
                                                        <label class="custom-control-label" for="0-1">0-1</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="experience" class="custom-control-input" value="2,5" id="2-5" onchange="tutorList()">
                                                        <label class="custom-control-label" for="2-5">2-5</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="experience" class="custom-control-input" value="6,10" id="6-10" onchange="tutorList()">
                                                        <label class="custom-control-label" for="6-10">6-10</label>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="custom-control custom-radio">
                                                        <input type="radio" name="experience" class="custom-control-input" value="10" id="10" onchange="tutorList()">
                                                        <label class="custom-control-label" for="10">10+</label>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="column-2" id="tutorList">

                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor.js')}}"></script>
@endpush
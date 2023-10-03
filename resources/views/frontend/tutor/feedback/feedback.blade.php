@extends('layouts.tutor.app')
@section('title', __('labels.feedback'))
@section('content')
@push('css')
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.css">
@endpush
<main class="mainContent">
    <div class="feedBackPage commonPad bg-green">
        <section class="pageTitle">
            <div class="container">
                <div class="commonBreadcrumb">
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="{{route('home')}}">{{__('labels.home')}}</a></li>
                            <li class="breadcrumb-item">
                                @if($class->class_type =='class')
                                <a href="{{ route('tutor.classes.index') }}">{{__('labels.my_classes')}}</a>
                                @else
                                <a href="{{ route('tutor.webinars.index') }}">{{__('labels.my_webinars')}}</a>
                                @endif
                            </li>

                            <li class="breadcrumb-item active" aria-current="page">
                                @if($class->class_type=='class')
                                @php $url = route('tutor.classes.detail', ['slug' => $class->slug]) @endphp
                                <a href="{{$url}}">{{__('labels.class_detail')}}</a>
                                @else
                                @php $url = route('tutor.webinars.detail', ['slug' => $class->slug]) @endphp
                                <a href="{{$url}}">{{__('labels.webinar_detail')}}</a>
                                @endif
                            </li>
                        </ol>
                    </nav>
                </div>
                <h3 class="h-32 pageTitle__title">{{__('labels.feedback')}}</h3>
            </div>
        </section>
        <section class="feedBackPage__inner">
            <div class="container">
                <div class="row">
                    <div class="col-md-4">
                        <div class="leftSide commonBox">
                            <form>
                                <div class="form-group">
                                    <em class="icon-search searchIcon"></em>
                                    <input type="hidden" id="id" value="{{$class->id}}">
                                    <input type="text" class="form-control" id="search-name" dir="rtl" value="" placeholder="Search by student name">
                                </div>
                            </form>
                            <ul class="list-unstyled mb-0 leftSide-Box" id="search-data">

                            </ul>
                        </div>
                    </div>
                    <div class="col-md-8" id="student-data">
                        <div style="display:none" class="alert alert-danger font-rg add-class">{{ __('labels.record_not_found') }}</div>
                    </div>
                </div>
            </div>
        </section>
    </div>
</main>
<!-- <div class="modal fade" id="rasieDisputeModal" data-backdrop="static" tabindex="-1" role="dialog" aria-hidden="true">
    <div class="modal-dialog modal-dialog-centered commonModal commonModal--message">
        <div class="modal-content">
            <div class="modal-header align-items-center border-bottom-0">
                <h5 class="modal-title">Raise Dispute</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form action="">
                    <div class="form-group mb-0">
                        <label class="form-label">Write Your Dispute Reason</label>
                        <textarea class="form-control">Lorem ipsum dolor sit amet, consetetur sadipscing elitr, sed diam nonumy eirmod tempor invidunt ut labore et dolore magna aliquyam erat, sed diam dad voluptua.</textarea>
                    </div>
                </form>
            </div>
            <div class="modal-footer border-top-0">
                <button type="submit" class="btn btn-primary btn-lg w-100 ripple-effect">Submit</button>
            </div>
        </div>
    </div>
</div> -->
@endsection
@push('scripts')
<script src="https://cdnjs.cloudflare.com/ajax/libs/rateYo/2.3.2/jquery.rateyo.min.js"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/tutor/feedback/feedback.js')}}"></script>
<script>

</script>
@endpush

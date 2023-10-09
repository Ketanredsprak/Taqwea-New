@php
    
    if (Auth::check() && Auth::user()->isTutor()) {
        $layout = 'layouts.tutor.app';
    } elseif (Auth::check() && Auth::user()->isStudent()) {
        $layout = 'layouts.student.app';
    }
    
@endphp

@extends($layout)

@section('title', 'Class Request')

@push('css')
    <link rel="stylesheet"
        href="https://cdnjs.cloudflare.com/ajax/libs/tempusdominus-bootstrap-4/5.1.2/css/tempusdominus-bootstrap-4.min.css"
        type="text/css">
@endpush

@section('content')

    <main class="mainContent">

        <div class="walletPage commonPad bg-green">

            <section class="pageTitle">

                <div class="container">

                    <div class="commonBreadcrumb">

                        <nav aria-label="breadcrumb">

                            <ol class="breadcrumb">

                                <li class="breadcrumb-item"><a href="{{ route('home') }}">{{ __('labels.home') }}</a></li>

                                <li class="breadcrumb-item active" aria-current="page">
                                    {{ __('labels.tutor_class_request') }}</li>

                            </ol>

                        </nav>

                    </div>

                    <h3 class="h-32 pageTitle__title">{{ __('labels.tutor_class_request') }}</h3>



                </div>

            </section>

            <section class="walletPage__inner">

                <div class="container">

                    <div class="d-flex align-items-center mb-3">

                        <button class="btn btn-primary ripple-effect  d-inline-flex d-xl-none" id="sideMenuToggle"><span
                                class="icon-menu"></span></button>

                    </div>

                    <div class="flexRow d-xl-flex">

                        <div class="column-1">

                            @if (Auth::check() && Auth::user()->isTutor())
                                @include('layouts.tutor.side-bar')
                            @elseif(Auth::check() && Auth::user()->isStudent())
                                @include('layouts.student.side-bar')
                            @endif

                        </div>

                        <div class="column-2">

                            <div class="walletPage__content common-shadow bg-white p-30">

                               
                                <a href="#"  onclick="backPage()"  type="button" class="btn btn-primary btn-sm"
                                        title="Accept"><em class="icon-arrow-back"></em></a>


                                <div class="walletPage__table">

                                    <h3 class="h-24">{{ __('labels.tutor_class_request') }}</h3>

                                    <div class="searchList common-table" nice-scroll>

                                        <div class="table-responsive">

                                            <table class="table">

                                                <thead>

                                                    <tr>

                                                        <th>{{ __('labels.id') }}</th>

                                                        <th>{{ __('labels.tutor_name') }}</th>

                                                        <th>{{ __('labels.tutor_email') }}</th>

                                                        <th>{{ __('labels.price') }}</th>

                                                        <th>{{ __('labels.action') }}</th>

                                                        <th></th>

                                                    </tr>

                                                </thead>

                                                <tbody>

                                                    <?php $i = 1; ?>

                                                    @forelse($datas as $key=>$data)
                                                        <tr>

                                                            <td>{{ $key + 1 }}</td>

                                                            <td>{{ $data->tutor->name }}</td>

                                                            <td>{{ $data->tutor->email }}</td>

                                                            <td>{{ $data->price }}</td>

                                                            <td>

                                                                <a href="#"
                                                                    onclick="Approverequest('{{ $data->id }}','{{ $data->class_request_id }}')"
                                                                    type="button" class="btn btn-primary btn-sm"
                                                                    title="Accept"><em class="icon-right"></em></a>

                                                                <a href="#"
                                                                    onclick="RejectTutorRequest('{{ $data->id }}','{{ $data->class_request_id }}')"
                                                                    type="button" class="btn btn-primary btn-sm"
                                                                    title="Reject"><em class="icon-delete"></em></a>

                                                                <a href="{{ route('featured.tutors.show', ['tutor' => $data->tutor_id]) }}"
                                                                    type="button" class="btn btn-primary btn-sm"
                                                                    title="View Tutor Profile"><em
                                                                        class="icon-eye"></em></a>

                                                            </td>

                                                        </tr>

                                                        <?php $i++; ?>

                                                    @empty

                                                        <tr>

                                                            <td colspan="7" class="px-0">

                                                                <div class="alert alert-danger font-rg">
                                                                    {{ __('labels.record_not_found') }}</div>

                                                            </td>

                                                        </tr>
                                                    @endforelse

                                                </tbody>

                                            </table>

                                            <div class="d-flex align-items-center paginationBottom justify-content-end ">

                                                <nav aria-label="Page navigation example ">

                                                    <div id="pagination"> {{ $datas->links() }}</div>

                                                </nav>

                                            </div>

                                        </div>

                                    </div>

                                </div>

                            </div>

                        </div>

                    </div>

                </div>

            </section>

        </div>

    </main>

    {{-- @include('frontend.wallet.add-amount-modal')

@include('frontend.wallet.redeem-amount-modal') --}}

@endsection

@push('scripts')

    @if (Auth::check() && Auth::user()->isTutor())
        <script>
            var walletLitUrl = "{{ route('tutor.wallet.list') }}";
        </script>
    @elseif(Auth::check() && Auth::user()->isStudent())
        <script>
            var walletLitUrl = "{{ route('student.wallet.list') }}";
        </script>
    @endif





    <script type="text/javascript" src="{{ asset('assets/js/frontend/student/tutor-class-request.js') }}"></script>

@endpush

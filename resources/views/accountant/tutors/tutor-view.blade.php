@extends('layouts.accountant.app')
@section('title','Tutor')
@section('content')
<div class="nk-content viewPage">
    <div class="container-fluid ">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm pageHead">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{route('accountantDashboard')}}">Dashboard</a>
                                    </li>
                                    <li class="breadcrumb-item"><a href="{{URL::TO('accountant\tutors')}}">Tutor
                                            Management</a></li>
                                    <li class="breadcrumb-item active">Tutor Management Details</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Tutor Management Details</h3>
                        </div><!-- .nk-block-head-content -->
                        <div class="nk-block-head-content pageHead__right">
                            <div class="toggle-wrap nk-block-tools-toggle">
                                <a href="{{URL::TO('accountant\tutors')}}"
                                    class="btn btn-outline-light bg-white d-none d-sm-inline-flex"><em
                                        class="icon ni ni-arrow-left"></em><span>Back</span></a>
                            </div>
                        </div>
                    </div><!-- .nk-block-between -->
                </div>
                <div class="nk-block">
                    <div class="card">
                        <div class="card-aside-wrap">
                            <div class="card-content">
                                <input type="hidden" class="custom-control-input" id="id" value="{{$user->id}}">
                                <ul class="nav nav-tabs nav-tabs-mb-icon nav-tabs-card">
                                    <li class="nav-item">
                                        <a class="nav-link active" data-toggle="pill" href="#otherInfo" role="tab"
                                            aria-controls="otherInfo" aria-selected="false">
                                            <span>Earning History</span>
                                        </a>
                                    </li>
                                    <li class="nav-item">
                                        <a class="nav-link" data-toggle="pill" href="#paymentInfo" role="tab"
                                            aria-controls="paymentInfo" aria-selected="false">
                                            <span>Payout History</span>
                                        </a>
                                    </li>
                                    <li class="nav-item nav-item-trigger d-lg-none">
                                        <a href="#" class="toggle btn btn-icon btn-trigger" data-target="userAside"><em
                                                class="icon ni ni-user-list-fill"></em></a>
                                    </li>
                                </ul><!-- .nav-tabs -->
                                <div class="tab-content mt-0" id="pills-tabContent">
                                    <div class="tab-pane mt-0 fade active show" id="otherInfo" role="tabpanel"
                                        aria-labelledby="otherInfo">
                                        <div class="card-inner common-table p-0">
                                            <table class="datatable-init table" id="earning-history-datatable">
                                                <thead>
                                                    <tr>
                                                        <th class="w_70 nosort id">ID</th>
                                                        <th class="from">From</th>
                                                        <th class="title">Title</th>
                                                        <th class="no_of_bookings">No Of Bookings</th>
                                                        <th class="booking_amount">Booking Amount</th>
                                                        <th class="admin_commission">Admin Commission</th>
                                                        <th class="refunds">Refunds</th>
                                                        <th class="fine">Total Fine</th>
                                                        <th class="final_earning">Final Earning</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="2" style="text-align:right"></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>
                                        </div>
                                    </div>

                                    <div class="tab-pane mt-0 fade" id="paymentInfo" role="tabpanel"
                                        aria-labelledby="paymentInfo">
                                        <div class="card-inner common-table p-0">

                                            <table class="datatable-init table" id="payout-details-datatable">
                                                <thead>
                                                    <tr>
                                                        <th class="w_70 nosort id">ID</th>
                                                        <th class="transaction_id">Transaction ID</th>
                                                        <th class="Date_and_time">Date & Time</th>
                                                        <th class="payment_to">Payment To</th>
                                                        <th class="total_payout">Total Payout</th>
                                                        <th class="status">status</th>
                                                    </tr>
                                                </thead>
                                                <tbody>
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <th colspan="4" style="text-align:right">Total:</th>
                                                        <th></th>
                                                    </tr>
                                                </tfoot>
                                            </table>

                                        </div>
                                    </div>
                                </div>
                            </div><!-- .card-content -->
                            <div class="card-aside card-aside-left user-aside toggle-slide toggle-slide-right toggle-break-lg"
                                data-content="userAside" data-toggle-screen="xxl" data-toggle-overlay="true"
                                data-toggle-body="true">
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
                                                <span class="sub-text">Joining Date:</span>
                                                <span>{{convertDateToTz($user->created_at,'UTC','M d, Y')}}</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Status:</span>
                                                <span
                                                    class={{$user->status == 'active'?'text-success':'text-danger'}}>{{ucfirst($user->status)}}</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Mobile Number:</span>
                                                <span>{{$user->phone_number}}</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Subscription:</span>
                                                <span>{{($user->tutorSubscriptions) ? $user->tutorSubscription->subscription->subscription_name : '--'}}</span>
                                            </div>
                                            <div class="col-12">
                                                <span class="sub-text">Address:</span>
                                                <span>{{$user->address}}</span>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="card-inner">
                                        <h6 class="overline-title-alt mb-2">Bank Detail</h6>
                                        <div class="row g-3">
                                            <div class="col-12">
                                                <span class="sub-text">Beneficiary Name:</span>
                                                <span>{{$user->tutor? $user->tutor->beneficiary_name: '--'}}</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Bank Account:</span>
                                                <span>{{$user->tutor? $user->tutor->account_number: '--'}}</span>
                                            </div>
                                            <div class="col-6">
                                                <span class="sub-text">Bank Code:</span>
                                                <span>{{$user->tutor? $user->tutor->bank_code: '--'}}</span>
                                            </div>
                                            <div class="col-12">
                                                <span class="sub-text">Address:</span>
                                                <span>{{$user->address}}</span>
                                            </div>
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

<!-- content @e -->
<div class="modal fade" tabindex="-1" id="readMoreModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-0">Class Detail</h5>
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            </div>
            <div class="modal-body">
                <p></p>
            </div><!-- .modal-body -->
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>

<div class="modal fade" tabindex="-1" id="degreeView">
    <div class="modal-dialog" role="degreeView">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title mb-0">Document View</h5>
                <a href="#" class="close" data-dismiss="modal"><em class="icon ni ni-cross-sm"></em></a>
            </div>
            @foreach($user->educations as $data)
            <div class="modal-body text-center">
                <img src="{{asset(getImageUrl($data->certificate))}}" class="img-fluid" alt="Certificate">
            </div><!-- .modal-body -->
            @endforeach
        </div><!-- .modal-content -->
    </div><!-- .modal-dialog -->
</div>
@endsection
@push('scripts')
<script>
let config = "{{ config('app.currency.default')}}";
</script>
<script src="{{asset('assets/js/accountant/tutors/tutor-view.js')}}"></script>
@endpush
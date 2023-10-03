@extends('layouts.admin.app')
@section('title','Category Management')
@section('content')
<div class="nk-content nk-content-fluid categoryPage">
    <div class="container-fluid">
        <div class="nk-content-inner">
            <div class="nk-content-body">
                <div class="nk-block-head nk-block-head-sm pageHead">
                    <div class="nk-block-between">
                        <div class="nk-block-head-content">
                            <!-- breadcrumb @s -->
                            <nav>
                                <ul class="breadcrumb breadcrumb-pipe">
                                    <li class="breadcrumb-item"><a href="{{ route('adminDashboard') }}">Dashboard</a></li>
                                    <li class="breadcrumb-item active">Category Management</li>
                                </ul>
                            </nav>
                            <!-- breadcrumb @e -->
                            <h3 class="nk-block-title page-title">Category Management</h3>
                        </div>
                    </div><!-- .nk-block-between -->
                </div>

                <!--tab-start-->
                
                <ul class="nav nav-tabs bg-white nav-tabs-card mt-0">
                    @forelse ($parent as $category)
                    <li class="nav-item">
                        <a class="nav-link {{$loop->index ==0 ? 'active' : ''}}" data-handle="{{$category->handle}}" data-id="{{$category->id}}" data-toggle="pill" href="#{{$category->handle}}" role="tab" aria-controls="Education" aria-selected="{{$loop->index ==0 ? 'true' : 'false'}}">
                            <span>{{$category->name}}</span>
                        </a>
                    </li>
                    @empty
                    
                    @endforelse
                </ul>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade active show" id="{{App\Models\Category::HANDLE_EDUCATION}}" role="tabpanel" aria-labelledby="Education">
                        <div class="text-right add-btn">
                            <a onclick="addEducation()" href="#" class="btn btn-primary">Assign Subject</a>
                        </div>
                        <div class="card-inner p-0 common-table bg-white">
                            <table id="subject-datatable" class="datatable-init table">
                                <thead>
                                    <tr>
                                        <th class="id w_70 nosort border-0">ID</th>
                                        <th class="category_name border-0">Category (English)</th>
                                        <th class="category_name_ar border-0">Category (Arabic)</th>
                                        <th class="grade border-0">Grade</th>
                                        <th class="subjects border-0">Subjects</th>
                                        <th class="actions nosort text-center w_100 border-0">Action</th>
                                    </tr>
                                </thead> 
                                <tbody>
                                    
                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="{{App\Models\Category::HANDLE_GK}}" role="tabpanel" aria-labelledby="knowledge">
                        <div class="text-right add-btn">
                            <a onclick="addKnowledge()" href="#" class="btn btn-primary">Add Category</a>
                        </div>
                        <div class="card-inner p-0 common-table bg-white">
                            <table id="category-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th class="id w_70 nosort border-0">ID</th>
                                        <th class="category_name border-0">Category (English)</th>
                                        <th class="category_name_ar border-0">Category (Arabic)</th>
                                        <th class="actions nosort text-center w_100 border-0">Action</th>
                                    </tr>
                                </thead> 
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>

                    <div class="tab-pane fade" id="{{App\Models\Category::HANDLE_LANGUAGE}}" role="tabpanel" aria-labelledby="languages">
                        <div class="text-right add-btn">
                            <a onclick="addLanguage()" href="#" class="btn btn-primary">Add Language</a>
                        </div>
                        <div class="card-inner p-0 common-table bg-white">
                            <table id="language-datatable" class="table">
                                <thead>
                                    <tr>
                                        <th class="id w_70 nosort border-0">ID</th>
                                        <th class="category_name border-0">Language (English)</th>
                                        <th class="category_name_ar border-0">Language (Arabic)</th>
                                        <th class="actions nosort text-center w_100 border-0">Action</th>
                                    </tr>
                                </thead> 
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <!--tab-end-->

            </div>
        </div>
    </div>
</div>

<div class="modal fade" tabindex="-1" id="addEducation">
   
</div>

<div class="modal fade" tabindex="-1"  id="addKnowledge">
    
</div>

<div class="modal fade" tabindex="-1" id="addLanguage">
    
</div>

 <!-- .modal -->
 @include('frontend.image-cropper-modal')

@endsection
@push('scripts')
<script type="text/javascript" src="{{asset('assets/js/admin/categories/index.js')}}"></script>
<script type="text/javascript" src="{{asset('assets/js/frontend/image-cropper.js')}}"></script>
@endpush
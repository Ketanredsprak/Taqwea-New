<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Edit Subject</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
        </div>
        <div class="modal-body">
            <form method="POST" id="education-frm" action="{{ route('category-subjects.update', $id) }}" class="form-validate is-alter">
                {{csrf_field()}}
                <input type="hidden" id='category-id' name="category_id" value="{{$categorySubject->category_id}}"  placeholder="" class="form-control rounded-0 shadow-none">   
                <input type="hidden" name="grade_id" value="{{$categorySubject->grade_id}}"  placeholder="" class="form-control rounded-0 shadow-none">   
                <div class="row gy-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <input type="text" name="" value="{{$categorySubject->category_name}}"  placeholder="" class="form-control rounded-0 shadow-none" disabled>   
                        </div>
                    </div><!-- .col -->
                <div class="col-md-12 {{$categorySubject->grade_id ? '': 'grades'}} ">
                        <div class="form-group">
                            <label class="form-label">Grade</label>
                            <input type="text" name="" value="{{$categorySubject->grade_name}}"  placeholder="" class="form-control rounded-0 shadow-none" disabled="">   

                        </div>
                    </div><!-- .col -->
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <select id="editSubjects" multiple="multiple" name="subject_id[]" class="form-select form-select-sm"  data-placeholder="Subjects" >
                                <option></option>
                                @foreach ($subjects as $subject)
                                    <option value="{{$subject->id}}"
                                    @if(in_array($subject->id, explode(",", $categorySubject->subjects_id)))
                                        selected
                                    @endif
                                    >{{$subject->subject_name}}</option>
                                @endforeach
                            </select>
                        </div>
                    </div><!-- .col -->
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" id='education-btn' class="btn btn-lg btn-primary" >Update</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateSubjectRequest','#education-frm') !!}

        </div>
    </div>
</div>

<div class="modal-dialog" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h5 class="modal-title">Assign Subject</h5>
            <a href="#" class="close" data-dismiss="modal" aria-label="Close">
                <em class="icon ni ni-cross"></em>
            </a>
        </div>
        <div class="modal-body">
            <form method="POST" id="education-frm" action="{{ route('category-subjects.store') }}" class="form-validate is-alter">
                {{csrf_field()}}
                <div class="row gy-4">
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Category</label>
                            <select id="category" name="category_id" class="form-select form-select-sm"  data-placeholder="Category" aria-describedby="category-error">
                                <option></option>
                                @foreach ($parent->childrens as $child)
                                    <option value="{{$child->id}}">{{$child->name}}</option>
                                @endforeach
                            </select>
                            <span id="category-error" class="invalid-feedback" style="display: inline;"></span>
                        </div>
                    </div><!-- .col -->
                    <div class="col-md-12 grades">
                        <div class="form-group">
                            <label class="form-label">Grade</label>
                            <select id="grades" name="grade_id" class="form-select form-select-sm"  data-placeholder="Grade" >
                                <option></option>
                                
                            </select>
                        </div>
                    </div>
                    <div class="col-md-12">
                        <div class="form-group">
                            <label class="form-label">Subject</label>
                            <select id="subjects" multiple="multiple" name="subject_id[]" class="form-select form-select-sm"  data-placeholder="Subjects" aria-describedby="subjects-error">
                                <option></option>
                                @foreach ($subjects as $subject)
                                    <option value="{{$subject->id}}">{{$subject->subject_name}}</option>
                                @endforeach
                            </select>
                            <span id="subjects-error" class="invalid-feedback" style="display: inline;"></span>
                        </div>
                    </div><!-- .col -->
                </div>
                <div class="mt-4 text-center">
                    <button type="submit" id="education-btn" class="btn btn-lg btn-primary">Add Subject</button>
                </div>
            </form>
            {!! JsValidator::formRequest('App\Http\Requests\Admin\UpdateSubjectRequest','#education-frm') !!}
        </div>
    </div>
</div>
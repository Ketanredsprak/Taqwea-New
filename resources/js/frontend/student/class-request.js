window.classRequestList = function classRequestList(url = '') {
    if (url == '') {
        url = process.env.MIX_APP_URL + '/student/classrequest/list';
    }
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            $("#classRequestList").html(response.data);
        },
        error: function (data) {
            handleError(data);
        },
    });
};
classRequestList();



$(document).ready(function() {
    var i =1;
    var j =2;

    $(document).on('click', '.click_multiple', function() {
        $("#multiple_date").addClass('required');

    });

    $("#add_class_field").click(function(e) {
                $("#add_new_field").append(`<div class="row" id="jquery_remove">
                <div class="col-md-4">
                    <label class="form-label">Number Of Class</label>
                    <input type="text" name="number_of_class" id="number_of_class"
                        class="form-control" value="` + j + `"
                        placeholder="Number Of Class" readonly="" />
                </div>
                <div class="col-sm-6">
                    <div class="form-group">
                        <label class="form-label">Class Date ` + i + `</label>
                        <input name="class[` + i +`][date]" id="multiple_date" type="date"
                            class="form-control" placeholder="" value="">
                    </div>
                </div>
                    <div class="col-sm-2">
                        <button type="button"
                            class="btn btn-danger btn-sm btn-lg remove-class" style="margin-top:35px;">Delete  </button>
                    </div>
            </div>`);
            i++;
            j++;
    })

    $(document).on('click', '.remove-class', function() {
        $(this).closest('div#jquery_remove').remove();
    });

    $(document).on('click', '#click_multiple', function() {
        $("#hide_on_click_multiple").hide();
        $("#multiple_class").removeClass("d-none");
        $("#multiple_date").removeAttr("required");

    });

    $(document).on('click', '#click_single', function() {
        $("#multiple_class").addClass("d-none");
        $("#hide_on_click_multiple").show();
    });



    //add
    $("#addClassRequestForm").on('submit', function(event) {
        event.preventDefault();
        var frm = $('#addClassRequestForm');
        var submitButton = $('#classRequestBtn');
        var method = "POST";
        var buttonLabel = "Add";
        var btnName = submitButton.html();
        var url = frm.attr('action');
        if (frm.valid()) {
            var formData = new FormData($("#addClassRequestForm")[0]);
            showButtonLoader(submitButton, btnName, 'disabled');
            // showButtonLoader(submitButton, btnName, 'disabled');
            $.ajax({
                url: url,
                type: method,
                data: formData,
                processData: false,
                contentType: false,
                success: function(response) {
                    if(response.success){ 
                        successToaster(response.message);
                        window.location.href = process.env.MIX_APP_URL + '/student/classrequest/';
                    }else { 
                        showButtonLoader(submitButton, btnName, 'enable');
                        errorToaster(response.message);
                    }
                       
                       
                },
                error: function(data) {
                    console.log(data);
                    showButtonLoader(submitButton, buttonLabel + 'Class Request');
                    handleError(data);
                }
            });
        }
    });



});

$("#categorySelect1").on("change", (function() {
    var handle = $(this).find(':selected').data('handle')
    var label = Lang.get("labels.category");
    if (handle == 'education') {
        label = Lang.get("labels.select_levels");
    } else if (handle == 'general-knowledge') {
        label = Lang.get("labels.domain");
    } else if (handle == 'language') {
        label = Lang.get("labels.language");
    }
    $(".subCategoryLavel").html(label);
    setTimeout(() => {
        $(".class_level .select2-selection__placeholder").html(label);
    }, 700);

    $('.grade-div').css('display', 'none');
    var gradeSelect = $('#gradeSelect');
    gradeSelect.html('').select2();

    $('.subject-div').css('display', 'none');
    var subjectSelect = $('#subjectSelect');
    subjectSelect.html('').select2();
}));

window.getLavels = function getLavels(parentId, lavelId = '') {
    var url = process.env.MIX_APP_URL + '/categories/' + parentId + '/childrens';
    var lavelSelect = $('#lavelSelect');
    lavelSelect.html('').select2();

    var subjectSelect = $('#subjectSelect');
    subjectSelect.html('').select2();

    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            if (response.data.length > 0) {
                var option = new Option('', '', false, false);
                lavelSelect.append(option);
                $.each(response.data, function(i) {
                    if (lavelId == response.data[i].id) {
                        var option = new Option(response.data[i].name, response.data[i].id, true, true);
                    } else {
                        var option = new Option(response.data[i].name, response.data[i].id, false, false);
                    }
                    lavelSelect.append(option);
                });
            }
            $('.grade-div').css('display', 'none');
            var gradeSelect = $('#gradeSelect');
            gradeSelect.html('').select2();

            $('.subject-div').css('display', 'none');
            var subjectSelect = $('#subjectSelect');
            subjectSelect.html('').select2();
        },
        error: function(data) {
            handleError(data);
        },
    });
};

window.getGrates = function getGrates(id, gradeId = '') {
    var url = process.env.MIX_APP_URL + '/categories/' + id + '/grades';
    var gradeSelect = $('#gradeSelect');
    gradeSelect.html('').select2();

    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            if (response.data.length > 0) {
                $('.grade-div').css('display', 'block');
                var option = new Option('Select Grade', '', false, false);
                gradeSelect.append(option);
                $.each(response.data, function(i) {
                    if (gradeId == response.data[i].id) {
                        var option = new Option(response.data[i].text, response.data[i].id, true, true);
                    } else {
                        var option = new Option(response.data[i].text, response.data[i].id, false, false);
                    }
                    gradeSelect.append(option);
                });

                $('.subject-div').css('display', 'none');
                var subjectSelect = $('#subjectSelect');
                subjectSelect.html('').select2();

            } else {
                $('.grade-div').css('display', 'none');
                getSubjects(id);
            }
        },
        error: function(data) {
            handleError(data);
        },
    });
};

$("#gradeSelect").on("change", (function() {
    var grade_id = $(this).val();
    var category_id = $("#lavelSelect").val();
    if (grade_id) {
        getSubjects(category_id, grade_id);
    }
}));

window.getSubjects = function getSubjects(category_id, grade_id = '', subject_id = '') {
    var subjectSelect = $('#subjectSelect');
    subjectSelect.html('').select2();
    var url = process.env.MIX_APP_URL + '/subjects?grade_id=' + grade_id + '&category_id=' + category_id;
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            if (response.data.length > 0) {
                $('.subject-div').css('display', 'block');
                var option = new Option('Select Subject', '', false, false);
                subjectSelect.append(option);
                $.each(response.data, function(i) {
                    if (subject_id == response.data[i].id) {
                        var option = new Option(response.data[i].subjects, response.data[i].id, true, true);
                    } else {
                        var option = new Option(response.data[i].subjects, response.data[i].id, false, false);
                    }
                    subjectSelect.append(option);
                });
            } else {
                $('.subject-div').css('display', 'none');
            }
        },
        error: function(data) {
            handleError(data);
        },
    });
};

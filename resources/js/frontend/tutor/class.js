$("#addClassForm").on('submit', (function(e) {
    e.preventDefault();
    var frm = $('#addClassForm');
    var btn = $('#addClassBtn');
    var obj = $(this);
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var description = CKEDITOR.instances.description1.getData();
        var description_ar = CKEDITOR.instances.description_ar.getData();
        var formData = new FormData(frm[0]);
        formData.set('class_id', $('#classId').val());
        formData.append('en[class_description]', description);
        formData.append('ar[class_description]', description_ar);
        $.ajax({
            url: $(this).attr('action'),
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                showButtonLoader(btn, btnName, 'enable');
                getTopicList(response.data.id);
                $("#classId").val(response.data.id);
                nextBtn(obj);
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },

        });
    }
}));

$("#addClassDetailForm").on('submit', (function(e) {
    e.preventDefault();
    var frm = $('#addClassDetailForm');
    var btn = $('#addClassDetailBtn');
    var btnName = btn.html();
    var obj = $(this);
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        var url = process.env.MIX_APP_URL + '/tutor/class-details/' + $("#classId").val();
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                console.log(response.data.slug);
                showButtonLoader(btn, btnName, 'enable');
                if (response.data.class_type == 'class') {
                    window.location.href = process.env.MIX_APP_URL + '/tutor/classes/' + response.data.slug;
                } else {
                    window.location.href = process.env.MIX_APP_URL + '/tutor/webinars/' + response.data.slug;
                }
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
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

window.changeLanguage = function changeLanguage(lang) {
    $('.language-div').css('display', 'none');
    $('.lang-' + lang).css('display', 'block');
};

$(function() {

    var current_fs, next_fs, previous_fs;
    var opacity;
    var current = 1;

    //$(".next").click(function () {
    window.nextBtn = function nextBtn(obj) {
            current_fs = obj.parents("fieldset");
            next_fs = obj.parents("fieldset").next();

            //Add Class Active
            $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");

            setTimeout(() => {
                $(".select2-selection__placeholder").html(Lang.get("labels.select_duration"));
            }, 700);
            //show the next fieldset
            next_fs.show();
            //hide the current fieldset with style
            current_fs.animate({ opacity: 0 }, {
                step: function(now) {
                    // for making fielset appear animation
                    opacity = 1 - now;

                    current_fs.css({
                        'display': 'none',
                        'position': 'relative'
                    });
                    next_fs.css({ 'opacity': opacity });
                },
                duration: 500
            });
        }
        //});
    $(".previous").click(function() {

        current_fs = $(this).parents("fieldset");
        previous_fs = $(this).parents("fieldset").prev();

        //Remove class active
        $("#progressbar li").eq($("fieldset").index(current_fs)).removeClass("active");

        //show the previous fieldset
        previous_fs.show();

        //hide the current fieldset with style
        current_fs.animate({ opacity: 0 }, {
            step: function(now) {
                // for making fielset appear animation
                opacity = 1 - now;

                current_fs.css({
                    'display': 'none',
                    'position': 'relative'
                });
                previous_fs.css({ 'opacity': opacity });
            },
            duration: 500
        });

    });

    $('#timepicker').datetimepicker({
        ignoreReadonly: true,
        format: 'LT',
        autoclose: true,
    });

    $('#timepicker1').datetimepicker({
        ignoreReadonly: true,
        format: 'LT',
        autoclose: true,
    });

    $(".customdatepicker").datetimepicker({
        format: 'DD-MM-YYYY',
        autoclose: true,
        minDate: truncateDate(new Date()),
        showTimezone: true,
        ignoreReadonly: true
    });


    $("#datepicker1").datetimepicker({
        format: 'DD-MM-YYYY',
        autoclose: true,
        minDate: truncateDate(new Date()),
        showTimezone: true,
        ignoreReadonly: true
    });

    $("#datepicker2").datetimepicker({
        format: 'DD-MM-YYYY',
        autoclose: true,
        minDate: truncateDate(new Date()),
        showTimezone: true,
        ignoreReadonly: true
    });

    $("#datepicker3").datetimepicker({
        format: 'DD-MM-YYYY',
        autoclose: true,
        minDate: truncateDate(new Date()),
        showTimezone: true,
        ignoreReadonly: true
    });

    $(".customdatepicker").datetimepicker({
        format: 'DD-MM-YYYY',
        autoclose: true,
        minDate: truncateDate(new Date()),
        showTimezone: true,
        ignoreReadonly: true
    });

    function truncateDate(date) {
        return new Date(date.getFullYear(), date.getMonth(), date.getDate());
    }

});

$(".form-select").select2({
    minimumResultsForSearch: -1
});

$("#categorySelect").change(function() {
    if ($(this).val()) {
        $("#categorySelect-error").html('');
    }
});

$("#lavelSelect").change(function() {
    if ($(this).val()) {
        $("#lavelSelect-error").html('');
    }
});

$("#durationOfClass").change(function() {
    if ($(this).val()) {
        $("#durationOfClass-error").html('');
    }
});

$('input[type=radio][name=class_fees_type]').change(function() {
    var type = $(this).val();
    if (type == 'hourly_fees') {
        $('input[type=number][name=total_fees]').attr('disabled', 'true');
        $('input[type=number][name=hourly_fees]').removeAttr('disabled');
        $('input[type=number][name=total_fees]').val('');
    } else {
        $('input[type=number][name=hourly_fees]').attr('disabled', 'true');
        $('input[type=number][name=total_fees]').removeAttr('disabled');
        $('input[type=number][name=hourly_fees]').val('');
    }
});

$(".deleteClassImage").click(function() {
    $(this).parent().parent().css('display', 'none');
    $("#classAddImageDiv").css('display', 'block');
    $(".uploadStuff").css('display', 'block');
    $("#uploadId").val('');
});

$("#categorySelect").on("change", (function() {
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
        $(".select2-selection__placeholder").html(label);
    }, 700);

    $('.grade-div').css('display', 'none');
    var gradeSelect = $('#gradeSelect');
    gradeSelect.html('').select2();

    $('.subject-div').css('display', 'none');
    var subjectSelect = $('#subjectSelect');
    subjectSelect.html('').select2();
}));

jQuery(function() {
    // console.log('sds');
    CKEDITOR.replace('description1', {
        contentsLangDirection: 'rtl',toolbar: []
    });
    CKEDITOR.replace('description_ar', {contentsLangDirection: 'rtl', toolbar: []});

    var description1_en = CKEDITOR.instances["description1"];
    description1_en.on('change', function() {
        CKEDITOR.instances["description_ar"].setData(description1_en.getData())
    });
    
});

//26-09-2023

// $("#description1").keyup(function () {
//     var val = $(this).val();
//     $("#description_ar").val(val);
// });

// function setinputvalue(destination_id,value)
// {
//     $("#"+destination_id).val(value);
// }

$("#class_name_en").keyup(function () {
    var val = $(this).val();
    $("#class_name_ar").val(val);
});









const { lang } = require("moment");

window.blogList = function blogList(url = '') {
    showPageLoader("blogList");
    if (url == '') {
        url = process.env.MIX_APP_URL + '/tutor/blogs/list';
    }

    $.ajax({
        method: "GET",
        url: url,
        //data: 
        success: function (response) {
            $("#blogList").html(response.data);
        },
        error: function (response) {
            handleError(response);
        },
    });
};

$("#addBlogForm").on('submit', (function (e) {
    e.preventDefault();
    var frm = $('#addBlogForm');
    var btn = $('#addBlogBtn');
    var btnName = btn.html();
    var url = $(this).attr('action');
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var description_en = CKEDITOR.instances.description_en.getData();
        var description_ar = CKEDITOR.instances.description_ar.getData();
        var formData = new FormData(frm[0]);
        formData.append('en[blog_description]', description_en);
        formData.append('ar[blog_description]', description_ar);
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                showButtonLoader(btn, btnName, 'disabled');
                successToaster(response.message);
                frm[0].reset();
                $('.showFileName').html($('.showFileName').attr('title'));
                setTimeout(() => {
                    window.location.href = process.env.MIX_APP_URL + '/tutor/blogs/' + response.data.slug;
                }, 2000);
            },
            error: function (data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

$("#updateBlogForm").on('submit', (function (e) {
    e.preventDefault();
    var frm = $('#updateBlogForm');
    var btn = $('#updateBlogBtn');
    var url = $(this).attr('action');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);

        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                showButtonLoader(btn, btnName, 'disabled');
                successToaster(response.message);
                setTimeout(() => {
                    window.location.href = process.env.MIX_APP_URL + '/tutor/blogs/' + response.data.id;
                }, 2000);
            },
            error: function (data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

window.deleteBlog = function deleteBlog(id, redirect = false) {
    const swalWithBootstrapButtons = Swal.mixin({
        customClass: {
            confirmButton: 'btn btn-primary mr-2',
            cancelButton: 'btn btn-light ripple-effect-dark'
        },
        buttonsStyling: false
    });
    swalWithBootstrapButtons.fire({
        title: Lang.get('labels.are_you_sure'),
        text: Lang.get("labels.you_want_to_delete_this_blog"),
        showCancelButton: true,
        confirmButtonText: Lang.get('labels.yes_delete_it'),
        cancelButtonText: Lang.get('labels.cancel'),
    }).then((result) => {
        if (result.value) {
            $.ajax({
                method: "DELETE",
                url: process.env.MIX_APP_URL + '/tutor/blogs/' + id,
                //data: { },
                success: function (response) {
                    successToaster(response.message);
                    if (redirect) {
                        setTimeout(() => {
                            window.location.href = redirect;
                        }, 2000);
                    } else {
                        $("#blog-" + id).remove();
                    }
                },
                error: function (response) {
                    handleError(response);
                },
            });
        }
    });
};

window.getLavels = function getLavels(parentId, lavelId = '') {
    var url = process.env.MIX_APP_URL + '/categories/' + parentId + '/childrens';
    var lavelSelect = $('#lavelSelect');
    lavelSelect.html('').select2();

    var subjectSelect = $('#subjectSelect');
    subjectSelect.html('').select2();

    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            if (response.data.length > 0) {
                var option = new Option('Select lavel', '', false, false);
                lavelSelect.append(option);
                $.each(response.data, function (i) {
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
        error: function (data) {
            handleError(data);
        },
    });
};

window.getGrates = function getGrates(id, gradeId = '') {
    var url = process.env.MIX_APP_URL + '/categories/' + id + '/grades';
    var gradeSelect = $('#gradeSelect');
    gradeSelect.html('').select2();

    $('.subject-div').css('display', 'none');
    var subjectSelect = $('#subjectSelect');
    subjectSelect.html('').select2();

    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            if (response.data.length > 0) {
                $('.grade-div').css('display', 'block');
                var option = new Option('Select Grade', '', false, false);
                gradeSelect.append(option);
                $.each(response.data, function (i) {
                    if (gradeId == response.data[i].id) {
                        var option = new Option(response.data[i].text, response.data[i].id, true, true);
                    } else {
                        var option = new Option(response.data[i].text, response.data[i].id, false, false);
                    }
                    gradeSelect.append(option);
                });
            } else {
                $('.grade-div').css('display', 'none');

                $('.subject-div').css('display', 'none');
                var subjectSelect = $('#subjectSelect');
                subjectSelect.html('').select2();
            }
        },
        error: function (data) {
            handleError(data);
        },
    });
};
$(".deleteBlogImage").click(function () {
    $(this).parent().parent().css('display', 'none');
    $(".uploadStuff").css('display', 'block');
    $("#uploadDegree").val('');
    $("#uploadDegree").parent().find('.showFileName').html($("#uploadDegree").parent().find('.showFileName').attr('title'));
});

$("#gradeSelect").on("change", (function () {
    var grades = $(this).val();
    var levels = $("#lavelSelect").val();
    getSubjects(levels, grades);
}));



window.getSubjects = function getSubjects(category_id, grade_id, subject_id = '') {
    var url = process.env.MIX_APP_URL + '/subjects?grade_id=' + grade_id + '&category_id=' + category_id;
    var subjectSelect = $('#subjectSelect');
    subjectSelect.html('').select2();

    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            if (response.data.length > 0) {
                $('.subject-div').css('display', 'block');
                var option = new Option('Select subject', '', false, false);
                subjectSelect.append(option);
                $.each(response.data, function (i) {
                    if (subject_id == response.data[i].id) {
                        var option = new Option(response.data[i].subjects, response.data[i].id, true, true);
                        subjectSelect.append(option);
                    } else {
                        var option = new Option(response.data[i].subjects, response.data[i].id, false, false);
                        subjectSelect.append(option);
                    }
                });
            } else {
                $('.subject-div').css('display', 'none');
            }
        },
        error: function (data) {
            handleError(data);
        },
    });
};

window.changeLanguage = function changeLanguage(lang) {
    $('.language-div').css('display', 'none');
    $('.lang-' + lang).css('display', 'block');
};

$('select').on('change', function () {
    if (this.value) {
        $("#" + $(this).attr('id') + "-error").html('');
    }
});

$("#categorySelect").on("change", (function () {
    var handle = $(this).find(':selected').data('handle')
    var label = Lang.get('labels.category');
    if (handle == 'education') {
        label = Lang.get('labels.class_level');
    } else if (handle == 'general-knowledge') {
        label = Lang.get('labels.domain');
    } else if (handle == 'language') {
        label = Lang.get('labels.language');
    }
    $(".subCategoryLavel").html(label);
    setTimeout(() => {
        $(".select2-selection__placeholder").html(Lang.get('labels.select') + ' ' + label);
    }, 700);
}));

jQuery(function() {
    if ($("#description_en").length) {
        CKEDITOR.replace('description_en', { contentsLangDirection: 'rtl',toolbar: []});
        CKEDITOR.replace('description_ar', {contentsLangDirection: 'rtl', toolbar: []});
       
        var description_en = CKEDITOR.instances["description_en"];
        description_en.on('change', function() {
            CKEDITOR.instances["description_ar"].setData(description_en.getData())
        });

    }
});

$('#copy').tooltip({
    trigger: 'click',
    placement: 'bottom',
    animation: false
});

function setTooltip(message) {
    $('#copy').tooltip('hide')
        .attr('data-original-title', message)
        .tooltip('show');
}

function hideTooltip() {
    setTimeout(function() {
        $('#copy').tooltip('hide');
    }, 1000);
}
if ($("#copy").length) {
    var clipboard = new ClipboardJS('#copy', {
        container: document.getElementById('copy')
    });
    clipboard.on('success', function(e) {
        setTooltip(Lang.get("labels.copied"));
        hideTooltip();
});
}




$("#title_en").keyup(function () {
    var val = $(this).val();
    $("#title_ar").val(val);
});

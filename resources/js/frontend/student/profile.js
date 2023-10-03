
window.getUserDetail = function getUserDetail(lang) {
    $.ajax({
        method: "GET",
        url: process.env.MIX_APP_URL + '/student/profile?language=' + lang,
        success: function (response) {
            if (response.data) {
                var userData = response.data;
                if (userData.user_levels) {
                    var levels = [];
                    $.each(userData.user_levels, function (i) {
                        levels.push(userData.user_levels[i].id);

                    });
                    $("#educationLavel").val(levels).trigger('change');
                }
                if (userData.user_grades) {
                    setTimeout(() => {
                        var grades = [];
                        $.each(userData.user_grades, function (i) {
                            grades.push(userData.user_grades[i].id);
                        });
                        $("#educationGrade").val(grades).trigger('change');
                    }, 800);
                }

                if (userData.user_subjects) {
                    setTimeout(() => {
                        var subjects = [];
                        $.each(userData.user_subjects, function (i) {
                            subjects.push(userData.user_subjects[i].id);
                        });
                        $("#educationSubject").val(subjects).trigger('change');
                    }, 1600);
                }

                if (userData.user_general_knowledge) {
                    var generalKnowledge = [];
                    $.each(userData.user_general_knowledge, function (i) {
                        generalKnowledge.push(userData.user_general_knowledge[i].id);
                    });
                    $("#generalKnowledge").val(generalKnowledge).trigger('change');
                }

                if (userData.user_languages) {
                    var languages = [];
                    $.each(userData.user_languages, function (i) {
                        languages.push(userData.user_languages[i].id);
                    });
                    $("#language").val(languages).trigger('change');
                }

            }
        },
        error: function (response) {
            handleError(response);
        },
    });
};
getUserDetail('en');


$("#educationLavel").on("change", (function () {
    var levels = $(this).val();

    var educationGradeSelect = $('#educationGrade');
    educationGradeSelect.html('').select2();

    if (levels.length > 0) {
        var id = levels.join();
        var url = process.env.MIX_APP_URL + '/categories/' + id + '/grades';
        $.ajax({
            url: url,
            type: "GET",
            success: function (response) {
                if (response.data.length > 0) {
                    $('.education-grade-div').css('display', 'block');
                    $.each(response.data, function (i) {
                        var option = new Option(response.data[i].text, response.data[i].id, false, false);
                        educationGradeSelect.append(option);
                    });
                    educationGradeSelect.trigger('change');

                    var educationSubjectSelect = $('#educationSubject');
                    educationSubjectSelect.html('').select2();
                } else {
                    $('.education-grade-div').css('display', 'none');
                    getSubjects(id, '');
                }
            },
            error: function (data) {
                handleError(data);
            },
        });
    }
}));

$("#educationGrade").on("change", (function () {
    var grades = $(this).val();
    var levels = $("#educationLavel").val();
    if (grades.length > 0) {
        var grade_id = grades.join();
        var category_id = levels.join();
        getSubjects(category_id, grade_id);
    }
}));

window.getSubjects = function getSubjects(category_id, grade_id) {
    var educationSubjectSelect = $('#educationSubject');
    educationSubjectSelect.html('').select2();
    var url = process.env.MIX_APP_URL + '/subjects?grade_id=' + grade_id + '&category_id=' + category_id;
    $.ajax({
        url: url,
        type: "GET",
        success: function (response) {
            if (response.data.length > 0) {
                $.each(response.data, function (i) {
                    var option = new Option(response.data[i].subjects, response.data[i].id, false, false);
                    educationSubjectSelect.append(option);
                });
                educationSubjectSelect.trigger('change');
            }
        },
        error: function (data) {
            handleError(data);
        },
    });
};

$("#updateProfileBtn").on('click', (function (e) {
    e.preventDefault();
    var frm = $('#updateProfileForm');
    var btn = $('#updateProfileBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        if (formData.get('profile_image')) {

            var file = imageBase64toFile(formData.get('profile_image'), 'user_image');
            formData.delete('profile_image');
            formData.append("profile_image", file); // remove base64 image content
        }

        $.ajax({
            url: frm.attr('action'),
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function (response) {
                showButtonLoader(btn, btnName, 'enable');
                successToaster(response.message);
                setTimeout(() => {
                    location.reload();
                }, 200);
            },
            error: function (data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
}));

$("#personalDetailsBtn").on('click', (function(e) {

    e.preventDefault();

    var frm = $('#personalDetailsForm');

    var btn = $('#personalDetailsBtn');

    var btnName = btn.html();

    var obj = $(this);

    if (frm.valid()) {

        var showLoader = 'Processing...';

        showButtonLoader(btn, showLoader, 'disabled');

        var formData = new FormData(frm[0]);

        // Get base64 image and convert to image object

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

            success: function(response) {

                showButtonLoader(btn, btnName, 'enable');

                successToaster(response.message);

                if (response.data && response.data.redirectUrl) {

                    window.location.href = response.data.redirectUrl;

                } else {

                    if ($("#pageType").val() == 'completeProfile') {

                        nextBtn(obj);

                    } else {

                        setTimeout(() => {

                            location.reload();

                        }, 300);

                    }

                }

            },

            error: function(data) {

                handleError(data);

                showButtonLoader(btn, btnName, 'enable');

            },

        });

    }

}));

window.getUserDetail = function getUserDetail(lang) {

    $.ajax({

        method: "GET",

        url: process.env.MIX_APP_URL + '/tutor/profile?language=' + lang,

        success: function(response) {

            if (response.data) {

                var userData = response.data;

                if (!$('.userimage').attr('src')) $('.userimage').attr('src', userData.profile_image_url);

                if (!$('.name_' + lang).val()) $('.name_' + lang).val(userData.name);

                if (!$('.email_' + lang).val()) $('.email_' + lang).val(userData.email);

                if (!$('.phone_number_' + lang).val()) $('.phone_number_' + lang).val(userData.phone_number);

                if (!$('.bio_' + lang).val()) $('.bio_' + lang).val(userData.bio);

                if (!$('.address_' + lang).val()) $('.address_' + lang).val(userData.address);



                var tutor_educations = userData.tutor_educations;

                var tutor_certificates = userData.tutor_certificates;

                if (tutor_educations.length > 0) {

                    $('#educationList-' + lang).html('');

                    $.each(tutor_educations, function(i) {

                        addEducationHtml(tutor_educations[i], lang);

                    });

                }



                if (tutor_certificates.length > 0) {

                    $('#certificateList-' + lang).html('');

                    $.each(tutor_certificates, function(i) {

                        addCertificateHtml(tutor_certificates[i], lang);

                    });

                }



                if (userData.tutor_detail && userData.tutor_detail.experience > 0) {

                    $("#experience").val(userData.tutor_detail.experience);

                }



                if (userData.user_levels) {

                    var levels = [];

                    $.each(userData.user_levels, function(i) {

                        levels.push(userData.user_levels[i].id);

                    });

                    $("#educationLavel").val(levels).trigger('change');

                }



                if (userData.user_grades) {

                    setTimeout(() => {

                        var grades = [];

                        $.each(userData.user_grades, function(i) {

                            grades.push(userData.user_grades[i].id);

                        });

                        $("#educationGrade").val(grades).trigger('change');

                    }, 800);

                }



                if (userData.user_subjects) {

                    setTimeout(() => {

                        var subjects = [];

                        $.each(userData.user_subjects, function(i) {

                            subjects.push(userData.user_subjects[i].id);

                        });

                        $("#educationSubject").val(subjects).trigger('change');

                    }, 1600);

                }



                if (userData.user_general_knowledge) {

                    var generalKnowledge = [];

                    $.each(userData.user_general_knowledge, function(i) {

                        generalKnowledge.push(userData.user_general_knowledge[i].id);

                    });

                    $("#generalKnowledge").val(generalKnowledge).trigger('change');

                }



                if (userData.user_languages) {

                    var languages = [];

                    $.each(userData.user_languages, function(i) {

                        languages.push(userData.user_languages[i].id);

                    });

                    $("#language").val(languages).trigger('change');

                }

                if (userData.tutor_detail) {

                    var filename = userData.tutor_detail.introduction_video_url.replace(/^.*[\\\/]/, '');

                    if (filename != 'default-user.jpg') {

                        $("#introductionVideoId").parent().find('.showFileName').html(filename);

                    }

                }

            }

        },

        error: function(response) {

            handleError(response);

        },

    });

};

getUserDetail('en');



$("#grade").css("display", "none");

$(document).ready(function() {

    var current_fs, next_fs, previous_fs;

    var opacity;

    var current = 1;

    window.nextBtn = function nextBtn(obj) {

        current_fs = obj.parents("fieldset");

        next_fs = obj.parents("fieldset").next();



        //Add Class Active

        $("#progressbar li").eq($("fieldset").index(next_fs)).addClass("active");





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



});



$("#educationLavel").on("change", (function() {

    var levels = $(this).val();



    var educationGradeSelect = $('#educationGrade');

    educationGradeSelect.html('').select2();



    if (levels.length > 0) {

        var id = levels.join();

        var url = process.env.MIX_APP_URL + '/categories/' + id + '/grades';

        $.ajax({

            url: url,

            type: "GET",

            success: function(response) {

                // console.log(response);

                if (!response.data.length) {

                    $("#grade").css("display", "none");

                }

                if (response.data.length > 0) {

                    $("#grade").css("display", "block");

                    $('.education-grade-div').css('display', 'block');

                    $.each(response.data, function(i) {

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

            error: function(data) {

                handleError(data);

            },

        });

    }

}));



$("#educationGrade").on("change", (function() {

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

        success: function(response) {

            if (response.data.length > 0) {

                $.each(response.data, function(i) {

                    var option = new Option(response.data[i].subjects, response.data[i].id, false, false);

                    educationSubjectSelect.append(option);

                });

                educationSubjectSelect.trigger('change');

            }

        },

        error: function(data) {

            handleError(data);

        },

    });

};

$("#professionalDetailForm").on('submit', (function(e) {

    e.preventDefault();

    var frm = $('#professionalDetailForm');

    var btn = $('#professionalDetailBtn');

    var btnName = btn.html();

    if (frm.valid()) {

        var showLoader = 'Processing...';

        showButtonLoader(btn, showLoader, 'disabled');

        var formData = new FormData(frm[0]);



        $.ajax({

            url: $(this).attr('action'),

            type: "POST",

            data: formData,

            contentType: false,

            cache: false,

            processData: false,

            success: function(response) {

                showButtonLoader(btn, btnName, 'enable');

                successToaster(response.message);

                if ($("#profileType").val() == 'complete-profile') {

                    window.location.href = process.env.MIX_APP_URL + '/tutor/dashboard';

                }

            },

            error: function(data) {

                handleError(data);

                showButtonLoader(btn, btnName, 'enable');

            },

        });

    }

}));

$(document).ready(function() {

    $(".form-select").select2({

        minimumResultsForSearch: -1

    });

});

window.changeLanguage = function changeLanguage(lang) {

    $('.profile-language').css('display', 'none');

    $('.profile-' + lang).css('display', 'block');

    getUserDetail(lang);

};



$(".deleteIdCard").on('click', (function() {

    $(this).parent().parent().css('display', 'none');

    $(".updateIdCard").css('display', 'block');

    $("#uploadId").val('');

}));



$(".deleteIntroductionVideo").on('click', (function() {

    $("#introductionVideoId").val('');

    $("#introductionOldVideoId").val('');

    $(this).parent().parent().css('display', 'none');

    $(".uploadIntroductionVideo").css('display', 'block');

}));



$(".deleteIdCertificate").on('click', (function() {

    $("#uploadCertificate").val('');

    $(this).parent().parent().css('display', 'none');

    $(".uploadCertificate").css('display', 'block');

}));



$(".deleteEducationCertificate").on('click', (function() {

    $("#uploadDegree").val('');

    $(this).parent().parent().css('display', 'none');

    $(".uploadEducationCertificate").css('display', 'block');

}));



window.submitEducationDetail = function submitEducationDetail(obj) {

    var educationCount = 0;

    $('.education-items').each(function() {

        educationCount++;

    });

    var certificateCount = 0;

    $('.certificate-items').each(function() {

        certificateCount++;

    });

    if (educationCount == 0) {

        $("#education-certificate-error").html(Lang.get("error.error_education_certification"));

    // } else if (certificateCount == 0) {

    //     $("#education-certificate-error").html(Lang.get("error.error_education_certification"));

    } else {

        nextBtn(obj);

    }

};



$(document).ready(function () {

    $("#name_en").on('keyup',function () {
       

        var val = $(this).val();

        $("#name_ar").val(val);

    });

    $("#bio_en").keyup(function () {

        var val = $(this).val();

        $("#bio_ar").val(val);

    });

});


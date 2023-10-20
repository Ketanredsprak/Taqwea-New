$(document).on('submit', '#addTopicForm', function(e) {
    e.preventDefault();
    var frm = $('#addTopicForm');
    var btn = $('#addTopicBtn');
    var btnName = btn.html();
    if (frm.valid()) {
        var showLoader = 'Processing...';
        showButtonLoader(btn, showLoader, 'disabled');
        var formData = new FormData(frm[0]);
        var id = $("#classId").val();
        var url = process.env.MIX_APP_URL + '/tutor/classes/' + id + '/topic';
        $.ajax({
            url: url,
            type: "POST",
            data: formData,
            contentType: false,
            cache: false,
            processData: false,
            success: function(response) {
                showButtonLoader(btn, btnName, 'enable');
                successToaster(response.message);
                getTopicList(response.data.class_id);
                $('#addNewTopicModal').modal('hide');
            },
            error: function(data) {
                handleError(data);
                showButtonLoader(btn, btnName, 'enable');
            },
        });
    }
});

window.getTopicList = function getTopicList(id) {
    var url = process.env.MIX_APP_URL + '/tutor/classes/' + id + '/topic';
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $("#topics").html(response.data);
        },
        error: function(data) {
            handleError(data);
        },
    });
}

window.showTopicList = function showTopicList(classId, topicId) {
    var url = process.env.MIX_APP_URL + '/tutor/classes/' + classId + '/topic/' + topicId;
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $("#addNewTopicModal").html(response.data);
            $('#addNewTopicModal').modal('show');
        },
        error: function(data) {
            handleError(data);
        },
    });
}

$(document).on('click', '.deleteSubTopic', function() {
    var id = $(this).data('id');
    var obj = $(this);
    if (id) {
        var url = process.env.MIX_APP_URL + '/tutor/sub-topic/' + id;
        $.ajax({
            type: "DELETE",
            url: url,
            success: function(data) {
                obj.parent().remove();
            },
            error: function(err) {
                handleError(err);
            }
        });
    } else {
        obj.parent().remove();
    }
});

// window.addMoreSubTopic = function addMoreSubTopic(lang) {
//     if (lang === "en") {
//         var html = `<div class="form-group form-group-icon mb-2 closeOption">
//                 <input type="text" name="sub_topics[]" dir="rtl" class="form-control" placeholder="`+ Lang.get('labels.enter_option') + `" value="">
//                 <a href="javascript:void(0);" class="icon remove-btn deleteSubTopic"><span class="icon-close"></span></a>
//             </div>`;
//     } 
//     $("#more-option-en").append(html);
// };

window.addMoreSubTopic = function addMoreSubTopic(lang) {
    if (lang === "en") {
        var html = `<div class="form-group form-group-icon mb-2 closeOption">
        <input type="text" name="sub_topics[]" dir="rtl" class="form-control" placeholder="`+ Lang.get('labels.enter_option') + `" value="">
        <a href="javascript:void(0);" class="icon remove-btn deleteSubTopic"><span class="icon-close"></span></a>
        </div>`;
    } else {
        var html = `<div class="form-group form-group-icon mb-2 closeOption">
                <input type="text" name="sub_topics_ar[]" dir="rtl" class="form-control" placeholder="`+ Lang.get('labels.enter_option') + `" value="">
                <a href="javascript:void(0);" class="icon remove-btn deleteSubTopic"><span class="icon-close"></span></a>
            </div>`;
    }
   $("#more-option-" + lang).append(html);
};


window.changeTopicLanguage = function changeTopicLanguage(lang) {
    $('.topic-language').css('display', 'none');
    $('.topic-lang-' + lang).css('display', 'block');
};

window.addNewTopic = function addNewTopic(lang) {
    var url = process.env.MIX_APP_URL + '/tutor/classes/' + classId + '/topic/create';
    $.ajax({
        url: url,
        type: "GET",
        success: function(response) {
            $("#addNewTopicModal").html(response.data);
            $('#addNewTopicModal').modal('show');
        },
        error: function(data) {
            handleError(data);
        },
    });
};


$("#topic_title_en").keyup(function () {
    var val = $(this).val();
    $("#topic_title_ar").val(val);
});

$("#topic_description_en").keyup(function () {
    var val = $(this).val();
    $("#topic_description_ar").val(val);
});






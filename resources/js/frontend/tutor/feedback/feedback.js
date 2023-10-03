function rasieDisputeModal() {
    $('#rasieDisputeModal').modal('show');
}

// rateStar
$(function() {
    $("#search-name").on("keyup", function() {
        var name = $("#search-name").val();
        var id = $('#id').val();
        $.ajax({
            url: process.env.MIX_APP_URL + '/tutor/feedback/search/' + id,
            type: "GET",
            data: {
                "name": name,
                "id": id
            },
            success: function(response) {
                $("#search-data").html(response.data);
            },
            error: function(data) {
                handleError(data);
            },
        });
    });
    window.getSearchList = function getSearchList() {
        var name = $("#search-name").val();
        var id = $('#id').val();
        $.ajax({
            url: process.env.MIX_APP_URL + '/tutor/feedback/search/' + id,
            type: "GET",
            data: {
                "name": name,
                "id": id
            },
            success: function(response) {
                $("#search-data").html(response.data);
                var student_id = $('.student_id0').text();
                var class_id = $('.class_id0').text();

                if (student_id === '') {
                    $('.add-class').css('display', 'block');
                }
                if (student_id && class_id) {
                    getFindStudent(student_id, class_id);
                }
            },
            error: function(data) {
                handleError(data);
            },
        });
    };
    getSearchList();

    window.getFindStudent = function(student_id, class_id) {
        var student_id = student_id;
        var id = class_id;
        $.ajax({
            url: process.env.MIX_APP_URL + '/tutor/feedback/student/' + id,
            type: "GET",
            data: {
                "student_id": student_id,
                "id": id
            },
            success: function(response) {
                $("#student-data").html(response.data);
            },
            error: function(data) {
                handleError(data);
            },
        });
    }
});
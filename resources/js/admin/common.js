$(document).on('click', '.select2-search__field, .select2-dropdown', function(e) {
    e.stopPropagation();
});


$(function() {

    // Function to open datepicker onclick of date icon
    $('.dateIcon').click(function() {
        $(this).parent().find(".date-picker").focus();
    });

    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $('input').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    });

});

window.convertMinutes = function(minutes) {
    var hours = Math.floor(minutes / 60);
    var minutes = minutes % 60;

    return hours + '.' + minutes + ' hours';
}

window.showButtonLoader = function(button, text, action) {
    if (action === 'disabled') {
        button.html(text + ' <div class="spinner-border spinner-border-sm" role="status"> <span class="sr-only"></span> </div>');
        button.prop('disabled', true);
    } else {
        button.html(text);
        button.prop('disabled', false);
    }
}

$(document).on('keypress', '.only-number', function(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.which) ? evt.which : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
});

window.successToaster = function(message, title) {
    NioApp.Toast(message, 'success');
}

window.errorToaster = function(message, title) {
    NioApp.Toast(message, 'error');
}

window.noDataMessage = function(container, message) {
    if (message) {
        container.html('<div class="alert alert-icon alert-danger" role="alert">' +
            '<em class="icon ni ni-alert-circle"></em>' +
            '<strong>' + message + '</strong></div>'
        );
    } else {
        container.html('');
    }
}

window.handleError = function(errorResponse) {
    if (errorResponse.responseText) {
        var errors = JSON.parse(errorResponse.responseText);
        if (errorResponse.status === 422) {
            if (errors.errors) {
                for (var field in errors.errors) {
                    errorToaster(errors.errors[field]);
                    return false;
                }
            } else if (errors.error && errors.error.message) {
                errorToaster(errors.error.message);
                return false;
            }
        } else {
            errorToaster(errors.message);
            return false;
        }
    }
    errorToaster(errorResponse.statusText);
}

$(".mark-all-as-read").on('click', (function(e) {
    $.ajax({
        url: process.env.MIX_APP_URL + "/admin/mark-all-as-read",
        type: "POST",
        data: { _token: $('meta[name="csrf-token"]').attr('content') },
        success: function(data) {
            $('.icon-status-info').removeClass('icon-status');
            noDataMessage(
                $('.notification-list'),
                'No unread notifications!'
            );
            $('a').remove('.mark-all-as-read');
            successToaster(data.message);
        },
        error: function(data) {
            if (data && data.responseText) {
                var obj = JSON.parse(data.responseText);
                errorToaster(obj.message);
            }
            errorToaster('Server Error');
        },
    });
}));

window.showImagePreview = function(obj) {
    var file = document.getElementById(obj.attr('id'));
    var fileName = file.files.item(0).name;
    var fileSize = (file.files.item(0).size) / 1048576; // In MB
    var fileMaxSize = obj.data('max-size');
    var acceptFileType = obj.attr('accept');
    acceptFileType = acceptFileType.split(",");
    var extension = '.' + fileName.split('.').pop().toLowerCase();
    // Check type
    if (acceptFileType.indexOf(extension) == -1) {
        errorToaster('File should be a ' + obj.attr('accept'));
        obj.val('');
        return false;
    }

    // Check file size
    if (fileSize > fileMaxSize) {
        errorToaster('File size should not exceed ' + fileMaxSize + ' MB');
        obj.val('');
        return false;
    }

    var imageFormate = ['.jpeg', '.jpg', '.png'];
    var videoFormate = ['.mp4', '.3gp', '.mov'];
    console.log(imageFormate);
    console.log(extension, imageFormate.indexOf(extension));
    if (imageFormate.indexOf(extension) != -1) {
        // Show file preview
        if (file.files && file.files[0]) {
            var reader = new FileReader();
            reader.onload = function(e) {
                $('#' + obj.attr('name') + 'imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file.files[0]);
            $('#' + obj.attr('name') + 'imagePreview').css('display', 'block');
            $('#' + obj.attr('name') + 'videoPreview').css('display', 'none');
            $('#' + obj.attr('name') + 'videoPreview').parent().css('display', 'none');
            obj.parent().css('display', 'none')
            $("#" + obj.attr('name') + "imagePreviewDiv").css('display', 'block');
        }
    } else if (videoFormate.indexOf(extension) != -1) {
        $('#' + obj.attr('name') + 'imagePreview').css('display', 'none');
        $('#' + obj.attr('name') + 'videoPreview').css('display', 'block');
        $('#' + obj.attr('name') + 'videoPreview').parent().css('display', 'block');
        var $source = $('#' + obj.attr('name') + 'videoPreview');
        $source[0].src = URL.createObjectURL(file.files[0]);
        $source.parent()[0].load();
        obj.parent().css('display', 'none')
        $("#" + obj.attr('name') + "imagePreviewDiv").css('display', 'block');
    } else {
        // Show file name
        obj.parent().find('.showFileName').html(fileName);
    }
}

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
        'language': 'en'
    }
});

$(function() {
    $('.date-picker-from').datepicker()
        .on('changeDate', function(ev) {
            var date = $('.date-picker-from').val();
            $('.date-picker-to').datepicker('setStartDate', date);
        });
    $('.date-picker-to').datepicker()
        .on('changeDate', function(ev) {
            var date = $('.date-picker-to').val();
            $('.date-picker-from').datepicker('setEndDate', date);
        });

    var $inputs = $(".otp-input");
    var intRegex = /^\d+$/;

    // Prevents user from manually entering non-digits.
    $inputs.on("input.fromManual", function() {
        if (!intRegex.test($(this).val())) {
            $(this).val("");
        }
    });

    // Prevents pasting non-digits and if value is 6 characters long will parse each character into an individual box.
    $inputs.on("paste", function() {
        var $this = $(this);
        var originalValue = $this.val();
        $this.val("");

        $this.one("input.fromPaste", function() {
            $currentInputBox = $(this);

            var pastedValue = $currentInputBox.val();

            if (pastedValue.length == 4 && intRegex.test(pastedValue)) {
                pasteValues(pastedValue);
            } else {
                $this.val(originalValue);
            }

            $inputs.attr("maxlength", 1);
        });

        $inputs.attr("maxlength", 4);
    });


    // Parses the individual digits into the individual boxes.
    function pasteValues(element) {
        var values = element.split("");

        $(values).each(function(index) {
            var $inputBox = $('.otp-input[name="otp[' + (index + 1) + ']"]');
            $inputBox.val(values[index])
        });
    };

    window.clearDatepicker = function clearDatepicker() {
        $('.date-picker-from').datepicker('destroy');
        $('.date-picker-to').datepicker('destroy');
        $('.date-picker-from').datepicker({
            todayHighlight: true
        });
        $('.date-picker-to').datepicker({
            todayHighlight: true
        });
    }

});
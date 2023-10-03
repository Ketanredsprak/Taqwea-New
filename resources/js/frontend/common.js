$(document).on('click', '.select2-search__field, .select2-dropdown', function (e) {
    e.stopPropagation();
});


$(function () {

    // Function to open datepicker onclick of date icon
    $('.dateIcon').click(function () {
        $(this).parent().find(".date-picker").focus();
    });

    $('.modal').on('hidden.bs.modal', function() {
        $(this).find('form').trigger('reset');
        $('input').removeClass('is-invalid');
        $('.invalid-feedback').text('');
    });

  

});

$.ajaxSetup({
    headers: {
        'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
    }
});

window.showButtonLoader = function (button, text, action) {
    if (text == 'Processing...') {
        text = Lang.get('labels.process');
    }
    if (action === 'disabled') {
        button.html('<div class="d-flex align-items-center justify-content-center">' + text + ' <span class="spinner-border spinner-border-sm" role="status"> <span class="sr-only"></span> </span> </div>');
        button.prop('disabled', true);
    } else {
        button.html(text);
        button.prop('disabled', false);
    }
}

window.showPageLoader = function (id) {
    $('#' + id).html('<div class="col-12"> <div class="pageLoader text-center"><div class="spinner-border" role="status"></div></div></div>');
}


window.successToaster = function (message, title) {
    toastr.remove();
    toastr.options.closeButton = true;
    toastr.success(message, '', { timeOut: 5000 });
}

window.errorToaster = function (message, title) {
    toastr.remove();
    toastr.options.closeButton = true;
    toastr.error(message, '', { timeOut: 5000 });
}

window.warningToaster = function (message, title) {
    toastr.remove();
    toastr.options.closeButton = true;
    toastr.warning(message, '', { timeOut: 5000 });
}

window.noDataMessage = function (container, message) {
    if (message) {
        container.html('<div class="alert alert-icon alert-danger" role="alert">'
            + '<em class="icon ni ni-alert-circle"></em>'
            + '<strong>' + message + '</strong></div>'
        );
    } else {
        container.html('');
    }
}

window.handleError = function (errorResponse) {
    if (errorResponse.responseText) {
        var errors = JSON.parse(errorResponse.responseText);
        if (errorResponse.status === 422 || errorResponse.status === 429) {
            if (errors.errors){
                for (var field in errors.errors) {
                    errorToaster(errors.errors[field]);
                    return false;
                }
            }else{
                errorToaster(errors.error.message);
            }
        } else {
            if (errors.message) {
                errorToaster(errors.message);
            } else {
                errorToaster(errors.error.message);
            }
            return false;
        }
    } else if (errorResponse.status === 0) {
        errorToaster(Lang.get("error.internet_connection"));
    } else {
       errorToaster(errorResponse.statusText);
    }
}

window.readMore = function (
    characterLimit = 763,
    moreText = "Show more",
    lessText = "Show less"
) {
    var showChar = characterLimit;  // How many characters are shown by default
    var ellipsestext = "...";
    var moretext = moreText;
    var lesstext = lessText;
    $('.more').each(function () {
        var content = $(this).html();
        if (content.length > showChar) {

            var c = content.substr(0, showChar);
            var h = content.substr(showChar, content.length - showChar);

            var html = c + '<span class="moreellipses">' + ellipsestext + '&nbsp;</span><span class="morecontent"><span style="display:none;">' + h + '</span>&nbsp;&nbsp;<a href="" class="morelink show-more text-uppercase h-16">' + moretext + '</a></span>';

            $(this).html(html);
        }

    });

    $(".morelink").on('click', function () {
        if ($(this).hasClass("less")) {
            $(this).removeClass("less");
            $(this).html(moretext);
        } else {
            $(this).addClass("less");
            $(this).html(lesstext);
        }
        $(this).parent().prev().toggle();
        $(this).prev().toggle();
        return false;
    });
}

$(document).on('keypress', '.only-number', function(evt) {
    evt = (evt) ? evt : window.event;
    var charCode = (evt.type) ? evt.type : evt.keyCode;
    if (charCode > 31 && (charCode < 48 || charCode > 57)) {
        return false;
    }
    return true;
});

$(document).on('change', '#changeLanguage', function () {
    var languageCode = $(this).val();
    if (languageCode) {
        $.ajax({
            url: setLanguageUrl,
            type: 'POST',
            data: { 'languageCode': languageCode },
            success: function (response) {
                location.reload();
            },
            error: function (data) {
                handleError(data);
            }
        });
    }
});

window.showFileName = function (obj) {
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
        message = Lang.get("error.image_max_size", {'max_size':fileMaxSize});
        errorToaster(message);
        obj.val('');
        return false;
    }
    // Show file name
    obj.parent().find('.showFileName').html(fileName);
}

window.showImagePreview = function (obj) {
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
        message = Lang.get("error.image_max_size", {'max_size':fileMaxSize})
        errorToaster(message);
        obj.val('');
        return false;
    }
    
    var imageFormate = ['.jpeg', '.jpg', '.png'];
    var videoFormate = ['.mp4', '.3gp', '.mov'];
    if (imageFormate.indexOf(extension) != -1) {
        // Show file preview
        if (file.files && file.files[0]) {
            var reader = new FileReader();
            reader.onload = function (e) {
                $('#'+obj.attr('name')+'imagePreview').attr('src', e.target.result);
            }
            reader.readAsDataURL(file.files[0]);
            $('#' + obj.attr('name') +'imagePreview').css('display', 'block');
            $('#' + obj.attr('name') +'videoPreview').css('display', 'none');
            $('#' + obj.attr('name') + 'videoPreview').parent().css('display', 'none');
            obj.parent().css('display', 'none')
            $("#" + obj.attr('name')+"imagePreviewDiv").css('display', 'block');
        }
    } else if (videoFormate.indexOf(extension) != -1) {
        $('#' + obj.attr('name') +'imagePreview').css('display', 'none');
        $('#' + obj.attr('name') + 'videoPreview').css('display', 'block');
        $('#' + obj.attr('name') + 'videoPreview').parent().css('display', 'block');
        var $source = $('#' + obj.attr('name')+'videoPreview');
        $source[0].src = URL.createObjectURL(file.files[0]);
        $source.parent()[0].load();
        obj.parent().css('display', 'none')
        $("#" + obj.attr('name')+"imagePreviewDiv").css('display', 'block');
    } else {
        // Show file name
        obj.parent().find('.showFileName').html(fileName);
    }
}

if ($("html").attr('dir') == 'ltr') {
    $(window).on('load resize', function() {
        $('.authSlider').slick({ 
            dots: true,
            arrows: false,
            speed: 300,
            slidesToShow: 1,
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2500
        });
    });
} else { 
    $(window).on('load resize', function() {
        $('.authSlider').slick({
            dots: true,
            arrows: false,
            speed: 300,
            slidesToShow: 1, 
            slidesToScroll: 1,
            autoplay: true,
            autoplaySpeed: 2500,
            rtl: true
        });
    });
} 

    var expiryMask = function() {
        var inputChar = String.fromCharCode(event.keyCode);
        var code = event.keyCode;
        var allowedKeys = [8];
        if (allowedKeys.indexOf(code) !== -1) {
            return;
        }

        event.target.value = event.target.value.replace(
            /^([1-9]\/|[2-9])$/g, '0$1/'
        ).replace(
            /^(0[1-9]|1[0-2])$/g, '$1/'
        ).replace(
            /^([0-1])([3-9])$/g, '0$1/$2'
        ).replace(
            /^(0?[1-9]|1[0-2])([0-9]{2})$/g, '$1/$2'
        ).replace(
            /^([0]+)\/|[0]+$/g, '0'
        ).replace(
            /[^\d\/]|^[\/]*$/g, ''
        ).replace(
            /\/\//g, '/'
        );
    }

    $('#expired_date').on('keyup', function() {
        expiryMask();
    });

    var $inputs = $(".otp-input");
    var intRegex = /^\d+$/;
    
    // Prevents user from manually entering non-digits.
    $inputs.on("input.fromManual", function(){
        if(!intRegex.test($(this).val())){
            $(this).val("");
        }
    });
    
    
    // Prevents pasting non-digits and if value is 6 characters long will parse each character into an individual box.
    $inputs.on("paste", function() {
        var $this = $(this);
        var originalValue = $this.val();
        
        $this.val("");
    
        $this.one("input.fromPaste", function(){
            $currentInputBox = $(this);
            
            var pastedValue = $currentInputBox.val();
            
            if (pastedValue.length == 4 && intRegex.test(pastedValue)) {
                pasteValues(pastedValue);
            }
            else {
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
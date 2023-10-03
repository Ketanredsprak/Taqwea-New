!(function (NioApp, $) {
    "use strict";

    // Tinymce Init @v1.0
    NioApp.Tinymce = function () {
        var _tinymce_basic = '.tinymce-basic';
        if ($(_tinymce_basic).exists()) {
            tinymce.init({
                selector: _tinymce_basic,
                content_css: true,
                skin: false,
                branding: false
            });
        }

        var _tinymce_menubar = '.tinymce-menubar';
        if ($(_tinymce_menubar).exists()) {
            tinymce.init({
                selector: _tinymce_menubar,
                content_css: true,
                skin: false,
                branding: false,
                toolbar: false
            });
        }

        var _tinymce_toolbar = '.tinymce-toolbar';
        if ($(_tinymce_toolbar).exists()) {
            tinymce.init({
                selector: _tinymce_toolbar,
                content_css: true,
                skin: false,
                branding: false,
                menubar: false
            });
        }

        var _tinymce_inline = '.tinymce-inline';
        if ($(_tinymce_inline).exists()) {
            tinymce.init({
                selector: _tinymce_inline,
                content_css: false,
                skin: false,
                branding: false,
                menubar: false,
                inline: true,
                toolbar: [
                    'undo redo | bold italic underline | fontselect fontsizeselect',
                    'forecolor backcolor | alignleft aligncenter alignright alignfull | numlist bullist outdent indent'
                ]
            });
        }
    }


    // Editor Init @v1
    NioApp.EditorInit = function() {
        NioApp.Tinymce();
    };

    NioApp.coms.docReady.push(NioApp.EditorInit);

})(NioApp, jQuery);
$(function() {
    $('.nav-tabs a').on('show.bs.tab', function(e) {
        var tab = e.target;
        var categoryType = $(tab).data('handle');
        var categoryId = $(tab).data('id');

        if (categoryType == 'education') {
            educationList();
        } else if (categoryType == 'language') {
            languageList(categoryId);
        } else {
            categoryList(categoryId);
        }
    });

    var activeTab = $('.nav-tabs a.active');
    educationList($(activeTab).data('id'));

    window.addEducation = function() {
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/category-subjects/create',
            type: "GET",
            data: { handle: "education" },
            success: function(response) {
                $('#addEducation').html(response);
                $('.grades').hide();
                $('#subjects').select2({
                    tags: true,
                    createTag: function (params) {
                        return null;
                    },
                });
                $('#category').select2()
                    .change(function(e) {
                        var category = $(e.currentTarget).val();
                        loadCategoryGrades(category);
                    });
                $('#addEducation').modal('show');
            },
            error: function(data) {
                handleError(data);
            }
        });
    }

    window.editEducation = function(id) {
        $.ajax({
            url: process.env.MIX_APP_URL + '/admin/category-subjects/'+id+'/edit',
            type: "GET",
            data: { handle: "education" },
            success: function(response) {
                $('#addEducation').html(response);
                $('.grades').hide();
                $('#editSubjects').select2({
                    tags: true
                });
                $('#grades').select2({
                    tags: true
                });
                $('#editCategory').select2()
                    .change(function(e) {
                        var category = $(e.currentTarget).val();
                        loadCategoryGrades(category);
                    });
                $('#addEducation').modal('show');
            },
            error: function(data) {
                handleError(data);
            }
        });
    }

    window.loadCategoryGrades = function(categoryId) {
        $.ajax({
            url: process.env.MIX_APP_URL + '/api/v1/categories/grades/?category_id=' + categoryId,
            type: "GET",
            success: function(response) {
                if (response.data && response.data.length) {
                    $('.grades').show();
                    $('#grades').select2({ data: response.data });
                } else {
                    $('.grades').hide();
                    $('#grades').empty().trigger("change");
                }
            },
            error: function(data) {
                handleError(data);
            }
        });
    }

    window.addKnowledge = function(id) {
        var url = process.env.MIX_APP_URL + '/admin/categories/create';
        if (id) {
            url = process.env.MIX_APP_URL + '/admin/categories/' + id + '/edit';
        }
        $.ajax({
            url: url,
            type: "GET",
            data: { handle: "general-knowledge" },
            success: function(response) {
                $('#addKnowledge').html(response);
                $('#addKnowledge').modal('show');
            },
            error: function(data) {
                handleError(data);
            }
        });
    }

    window.addLanguage = function(id) {
        var url = process.env.MIX_APP_URL + '/admin/categories/create';
        if (id) {
            url = process.env.MIX_APP_URL + '/admin/categories/' + id + '/edit';
        }
        $.ajax({
            url: url,
            type: "GET",
            data: { handle: "language" },
            success: function(response) {
                $('#addLanguage').html(response);
                $('#addLanguage').modal('show');
            },
            error: function(data) {
                handleError(data);
            }
        });
    }

    $("#addEducation").on('submit', '#education-frm', function(event) {
        event.preventDefault();
        var submitButton = $('#education-btn');
        var method = "POST";
        if ($('#category-id').val()) {
            method = "PUT";
        }
        showButtonLoader(submitButton, 'Processing...', 'disabled');
        $.ajax({
            url: $(this).attr('action'),
            type: method,
            data: $(this).serialize(),
            success: function(response) {
                $('#addEducation').modal('hide');
                successToaster(response.message, { timeOut: 2000 });

                educationList();
            },
            error: function(data) {
                showButtonLoader(submitButton, 'Add Subject');
                handleError(data);
            }
        });
    });

    $("#addKnowledge").on('submit', '#category-frm', function(event) {
        event.preventDefault();
        var frm = $('#category-frm');
        var submitButton = $('#category-btn');
        var method = "POST";
        var buttonLabel = "Add";
        var successMessage = "Category added sucessfully.";
        var url = frm.attr('action');
        var formData = new FormData(frm[0]);
        if ($('#category-id').val()) {
            method = "POST";
            formData.append("_method", 'PUT');
            buttonLabel = "Update";
            successMessage = "Category updated sucessfully.";
        }

        if (formData.get('icon')) {
            var file = imageBase64toFile(formData.get('icon'), 'icon');
            formData.delete('icon');
            formData.append("icon", file); // remove base64 image content
        }

        showButtonLoader(submitButton, 'Processing...', 'disabled');
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            cache: false,
            contentType: false,
            success: function(response) {
                successToaster(successMessage, { timeOut: 2000 });
                $('#addKnowledge').modal('hide');
                categoryList(response.data.parent_id);
            },
            error: function(data) {
                showButtonLoader(submitButton, buttonLabel + ' Category');
                handleError(data);
            }
        });
    });

    $("#addLanguage").on('submit', '#language-frm', function(event) {
        event.preventDefault();
        var frm = $('#language-frm');
        var submitButton = $('#language-btn');
        var method = "POST";
        var buttonLabel = "Add";
        var successMessage = "Language added sucessfully.";
        var url = frm.attr('action');
        var formData = new FormData(frm[0]);

        if (formData.get('icon')) {
            var file = imageBase64toFile(formData.get('icon'), 'icon');
            formData.delete('icon');
            formData.append("icon", file); // remove base64 image content
        }

        if ($('#category-id').val()) {
            method = "POST";
            formData.append("_method", 'PUT');
            buttonLabel = "Update";
            successMessage = "Language updated sucessfully.";
        }
        console.log(formData);
        showButtonLoader(submitButton, 'Processing...', 'disabled');
        $.ajax({
            url: url,
            type: method,
            data: formData,
            processData: false,
            cache: false,
            contentType: false,
            success: function(response) {
                successToaster(successMessage, { timeOut: 2000 });
                $('#addLanguage').modal('hide');
                languageList(response.data.parent_id);
            },
            error: function(data) {
                showButtonLoader(submitButton, buttonLabel + ' Language');
                handleError(data);
            }
        });
    });
});

window.educationList = function() {
    var subjectTable = $('#subject-datatable');
    if (subjectTable.DataTable()) {
        subjectTable.DataTable().clear();
        subjectTable.DataTable().destroy();
    }
    NioApp.DataTable('#subject-datatable', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + '/admin/category-subjects',
            type: 'GET',
            data: function(d) {
                d.size = d.length;
                d.page = parseInt(subjectTable.DataTable().page.info().page) + 1;
                d.search = subjectTable.DataTable().search();
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
            
        'createdRow': function(row, data) {
            $('.edit', row).on('click', function() {
                editEducation(data.id);
            });
            $('.delete', row).on('click', function() {
                var url = process.env.MIX_APP_URL + '/admin/category-subjects/' + data.id;
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-primary mr-2',
                      cancelButton: 'btn btn-light ripple-effect-dark' 
                    },
                    buttonsStyling: false
                  });
                  swalWithBootstrapButtons.fire({  
                    title: 'Are you sure?',
                    text: "You want to delete this category!",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            data: { _token: $('meta[name="csrf-token"]').attr('content') },
                            url: url,
                            success: function(data) {
                                subjectTable.DataTable().ajax.reload();
                            },
                            error: function(err) {
                                handleError(err);
                            }
                        });
                    }
                });
            });

        },
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                "targets": 'id'
            },
            {
                "data": 'category_name',
                "targets": 'category_name'
            },
            {
                "data": 'translations.ar',
                "targets": 'category_name_ar',
                'orderable': false,
            },
            {
                "data": 'grade_name',
                "targets": 'grade',
                "defaultContent": "-"
            },
            {
                "data": 'subjects',
                "targets": 'subjects',
                "defaultContent": "-"
            },
            {
                "data": 'id',
                "targets": 'actions',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    var n = '<ul class="nk-tb-actions d-flex justify-content-center">\n' +
                        '<li>\n' +
                        '<div class="drodown">\n' +
                        '<a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '<div class="dropdown-menu dropdown-menu-right">\n' +
                        '<ul class="link-list-opt no-bdr">\n' +
                        '<li><a class="edit" href="javascript:void(0)"><em class="icon ni ni-pen"></em><span>Edit</span></a></li>\n' +
                        '<li><a href="#" class="eg-swal-av3 delete"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>\n' +
                        '</ul>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</li>\n' +
                        '</ul>';

                    return n;
                }
            }
        ]
    });
}

window.categoryList = function(categoryId) {
    var categoryTable = $('#category-datatable');
    if (categoryTable.DataTable()) {
        categoryTable.DataTable().clear();
        categoryTable.DataTable().destroy();
    }
    NioApp.DataTable('#category-datatable', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + '/admin/categories/' + categoryId + '/childrens',
            type: 'GET',
            data: function(d) {
                d.size = d.length;
                d.page = parseInt(categoryTable.DataTable().page.info().page) + 1;
                d.search = categoryTable.DataTable().search();
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {
            $('.edit', row).on('click', function() {
                addKnowledge(data.id);
            });

            $('.delete', row).on('click', function() {
                var url = process.env.MIX_APP_URL + '/admin/categories/' + data.id;
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-primary mr-2',
                      cancelButton: 'btn btn-light ripple-effect-dark' 
                    },
                    buttonsStyling: false
                  });
                  swalWithBootstrapButtons.fire({  
                    title: 'Are you sure?',
                    text: "You want to delete this category!",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            data: { _token: $('meta[name="csrf-token"]').attr('content') },
                            url: url,
                            success: function(data) {
                                categoryTable.DataTable().ajax.reload();
                            },
                            error: function(err) {
                                handleError(err);
                            }
                        });
                    }
                });
            });

        },
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                "targets": 'id'
            },
            {
                "data": 'name',
                "targets": 'category_name'
            },
            {
                "data": 'translations.ar',
                "targets": 'category_name_ar'
            },
            {
                "data": 'id',
                "targets": 'actions',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    var n = '<ul class="nk-tb-actions d-flex justify-content-center">\n' +
                        '<li>\n' +
                        '<div class="drodown">\n' +
                        '<a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '<div class="dropdown-menu dropdown-menu-right">\n' +
                        '<ul class="link-list-opt no-bdr">\n' +
                        '<li><a class="edit" href="#"><em class="icon ni ni-pen"></em><span>Edit</span></a></li>\n' +
                        '<li><a href="#" class="eg-swal-av3 delete"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>\n' +
                        '</ul>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</li>\n' +
                        '</ul>';

                    return n;
                }
            }
        ]
    });
}

window.languageList = function(categoryId) {
    var languageTable = $('#language-datatable');
    if (languageTable.DataTable()) {
        languageTable.DataTable().clear();
        languageTable.DataTable().destroy();
    }
    NioApp.DataTable('#language-datatable', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + '/admin/categories/' + categoryId + '/childrens',
            type: 'GET',
            data: function(d) {
                d.size = d.length;
                d.page = parseInt(languageTable.DataTable().page.info().page) + 1;
                d.search = languageTable.DataTable().search();
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {
            $('.edit', row).on('click', function() {
                addLanguage(data.id);
            });

            $('.delete', row).on('click', function() {
                var url = process.env.MIX_APP_URL + '/admin/categories/' + data.id;
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                      confirmButton: 'btn btn-primary mr-2',
                      cancelButton: 'btn btn-light ripple-effect-dark' 
                    },
                    buttonsStyling: false
                  });
                  swalWithBootstrapButtons.fire({  
                    title: 'Are you sure?',
                    text: "You want to delete this language!",
                    showCancelButton: true,
                    confirmButtonText: 'Yes, delete it!',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            type: "DELETE",
                            data: { _token: $('meta[name="csrf-token"]').attr('content') },
                            url: url,
                            success: function(data) {
                                languageTable.DataTable().ajax.reload();
                            },
                            error: function(err) {
                                handleError(err);
                            }
                        });
                    }
                });
            });

        },
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                "targets": 'id'
            },
            {
                "data": 'name',
                "targets": 'category_name'
            },
            {
                "data": 'translations.ar',
                "targets": 'category_name_ar'
            },
            {
                "data": 'id',
                "targets": 'actions',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    var n = '<ul class="nk-tb-actions d-flex justify-content-center">\n' +
                        '<li>\n' +
                        '<div class="drodown">\n' +
                        '<a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '<div class="dropdown-menu dropdown-menu-right">\n' +
                        '<ul class="link-list-opt no-bdr">\n' +
                        '<li><a href="#" class="edit"><em class="icon ni ni-pen"></em><span>Edit</span></a></li>\n' +
                        '<li><a href="#" class="eg-swal-av3 delete"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>\n' +
                        '</ul>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</li>\n' +
                        '</ul>';

                    return n;
                }
            }
        ]
    });
}
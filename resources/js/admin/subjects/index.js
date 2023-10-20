$(function () {

    window.addSubject = function (id) {

        var url = process.env.MIX_APP_URL + '/admin/subjects/create';

        if (id) {

            url = process.env.MIX_APP_URL + '/admin/subjects/' + id + '/edit';

        }

        $.ajax({

            url: url,

            type: "GET",

            success: function (response) {

                $('#addSubject').html(response);

                $('#addSubject').modal('show');

            },

            error: function (data) {

                handleError(data);

            }

        });

    }





    $("#addSubject").on('submit', '#subject-frm', function (event) {

        event.preventDefault();

        var frm = $('#subject-frm');

        var submitButton = $('#subject-btn');

        var method = "POST";

        var buttonLabel = "Add";

        var btnName = submitButton.html();

        var url = frm.attr('action');

        console.log(url, $('#subject-id').val());

        var formData = new FormData(frm[0]);

        if ($('#subject-id').val()) {

            method = "POST";

            formData.append("_method", 'PUT');

            buttonLabel = "Update";

        }



        if (formData.get('subject_icon')) {

            var file = imageBase64toFile(formData.get('subject_icon'), 'subject_icon');

            formData.delete('subject_icon');

            formData.append("subject_icon", file); // remove base64 image content

        }



        console.log(formData);

        showButtonLoader(submitButton, btnName, 'disabled ');

        $.ajax({

            url: url,

            type: method,

            data: formData,

            contentType: false,

            cache: false,

            processData: false,

            success: function (response) {

                $('#addSubject').modal('hide');

                successToaster(response.message, { timeOut: 2000 });

                setTimeout(function () {

                    $('#subject-datatable').DataTable().draw(true);

                }, 2000);

            },

            error: function (data) {

                showButtonLoader(submitButton, buttonLabel + ' Subject');

                handleError(data);

            }

        });

    });

});



$(function () {

    var subjectTable = $('#subject-datatable');

    NioApp.DataTable('#subject-datatable', {

        "processing": true,

        "serverSide": true,

        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/subjects/list",

            type: 'GET',

            data: function (d) {

                d.sortColumn = d.columns[d.order[0]['column']]['name'];

                d.sortDirection = d.order[0]['dir'];

                d.size = d.length;

                d.page = parseInt(subjectTable.DataTable().page.info().page) + 1;

                d.search = subjectTable.DataTable().search();

            },

            dataSrc: function (d) {

                d.recordsTotal = d.meta.total;

                d.recordsFiltered = d.meta.total;



                return d.data;

            }

        },

        'createdRow': function (row, data) {

            $('.edit', row).on('click', function () {

                addSubject(data.id);

            });



            $('.delete', row).on('click', function () {

                var url = process.env.MIX_APP_URL + '/admin/subjects/' + data.id;

                const swalWithBootstrapButtons = Swal.mixin({

                    customClass: {

                        confirmButton: 'btn btn-primary mr-2',

                        cancelButton: 'btn btn-light ripple-effect-dark'

                    },

                    buttonsStyling: false

                });

                swalWithBootstrapButtons.fire({

                    title: 'Are you sure?',

                    text: "You want to delete this subject!",

                    showCancelButton: true,

                    confirmButtonText: 'Yes, delete it!',

                }).then((result) => {

                    if (result.value) {

                        $.ajax({

                            type: "DELETE",

                            data: { _token: $('meta[name="csrf-token"]').attr('content') },

                            url: url,

                            success: function (data) {

                                successToaster(data.message, { timeOut: 2000 });

                                subjectTable.DataTable().ajax.reload();

                            },

                            error: function (err) {

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

            'name': 'id',

            "targets": 'id'

        },

        {

            "data": 'image',

            'name': 'image',

            "targets": 'image',

            "defaultContent": '--',

            "render": function(data, type, full, meta) {

                return '<div class="user-card">\n' +

                    '<div class="user-avatar user-avatar-sm bg-warning">\n' +

                    '<img src="' + full.subject_icon_url + '" alt="avatar">\n' +

                    ' </div>\n' +

                    ' </div>';

            }

        },

        {

            "data": 'subjects',

            "name": "subject_name",

            "targets": 'subject_name_en'

        },

        {

            "data": 'translations.ar',

            "name": "subject_name",

            "targets": 'subject_name_ar',



        },

        {

            "data": 'id',

            "targets": 'actions',

            'orderable': false,

            "render": function (data, type, full, meta) {

                var n = '<ul class="nk-tb-actions gx-1 justify-content-center">\n' +

                    '<li>\n' +

                    '<div class="drodown">\n' +

                    '<a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +

                    '<div class="dropdown-menu dropdown-menu-right">\n' +

                    '<ul class="link-list-opt no-bdr">\n' +

                    '<li><a class="edit" href="javascript:void(0)"><em class="icon ni ni-pen"></em><span>Edit</span></a></li>\n' +

                    '<li><a href="javascript:void(0)" class="eg-swal-av3 delete"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>\n' +

                    '</ul>\n' +

                    '</div>\n' +

                    '</div>\n' +

                    '</li>\n' +

                    '</ul>';



                return n;

            }

        }

        ]

    })

});
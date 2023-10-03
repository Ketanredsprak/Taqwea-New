$(function () {
    var bank = $('#bank-datatable');
    NioApp.DataTable('#bank-datatable', {
        "processing": true,
        "serverSide": true,
        "ajax": {
            url: process.env.MIX_APP_URL + "/admin/banks",
            type: 'Get',
            data: function (d) {
                d.size = d.length;
                d.page = parseInt(bank.DataTable().page.info().page) + 1;
                d.search = bank.DataTable().search();
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
            },
            dataSrc: function (d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function (row, data) {
            $('.delete', row).on('click', function () {
                var url = process.env.MIX_APP_URL + '/admin/banks/' + data.id;
                const swalWithBootstrapButtons = Swal.mixin({
                    customClass: {
                        confirmButton: 'btn btn-primary mr-2',
                        cancelButton: 'btn btn-light ripple-effect-dark'
                    },
                    buttonsStyling: false
                });
                swalWithBootstrapButtons.fire({
                    title: 'Are you sure?',
                    text: "You want to delete this Bank Record!",
                    icon: 'warning',
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
                                bank.DataTable().ajax.reload();
                            },
                            error: function (err) {
                                handleError(err);
                            }
                        });
                    }
                });
            });

            $('.update-checkbox', row).on('change', function() {
                var url = process.env.MIX_APP_URL + '/admin/status'
                var status = (data.status == 'active') ? 'inactive' : 'active';
                Swal.fire({
                    title: 'Are you sure',
                    text: "you want to change status?",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonText: 'Confirm',
                    cancelButtonText: 'Cancel',
                }).then((result) => {
                    if (result.value) {
                        $.ajax({
                            method: "put",
                            url: url,
                            data: { _token: $('meta[name="csrf-token"]').attr('content'), id: data.id, 'status': status },
                            success: function(data) {
                                if (data.success) {
                                    successToaster(data.message, { timeOut: 2000 });
                                    bank.DataTable().ajax.reload();
                                }
                            },
                            error: function(err) {
                                handleError(err);
                            }
                        });
                    } 
                })
            });

        },
        'order': [0, 'desc'],
        "columnDefs": [{
            "data": 'id',
            'name': 'id',
            "targets": 'id',
        },
        {
            "data": 'bank_name',
            'name': 'name',
            "targets": 'name',
            'orderable': false,
            'defaultContent': '--',
        },
        {
            "data": 'translations.ar',
            "name": "name",
            "targets": 'bank_name_ar',
            'orderable': false,

        },
        {
            'name': 'code',
            'data': 'bank_code',
            'targets': 'code',
            'orderable': false,
            'defaultContent': '--',
        },
        {
            "data": 'tutor_count',
            "name": "name",
            "targets": 'tutor_count',
            'defaultContent': '--',
            'orderable': false,

        },
        {
            'name': 'status',
            'data': 'status',
            'targets': 'status',
            'orderable': false,
            'defaultContent': '--',
            "render": function (data, type, full, meta){
                var checked = '';
                if (data == 'active') {
                    checked = 'checked = checked';
                }
                return '<div class="custom-control custom-switch">' +
                    '<input type="checkbox" class="custom-control-input update-checkbox" id="customSwitch' + full.id + '" value=' + full.id + ' ' + checked + '>' +
                    '<label class="custom-control-label" for="customSwitch' + full.id + '"></label>' +
                    '</div>';
            }
        },
        {
            "data": 'id',
            "targets": 'actions',
            'orderable': false,
            "render": function (data, type, full, meta) {
                var deleteBank = '';
                if(full.tutor_count == 0)
                {
                    deleteBank = '<li><a href="javascript:void(0)" class="eg-swal-av3 delete"><em class="icon ni ni-trash"></em><span>Delete</span></a></li>\n'
                }

                var n = '<ul class="nk-tb-actions gx-1 justify-content-center">\n' +
                    '<li>\n' +
                    '<div class="drodown">\n' +
                    '<a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                    '<div class="dropdown-menu dropdown-menu-right">\n' +
                    '<ul class="link-list-opt no-bdr">\n' +
                    '<li><a class="edit" onclick="addBank('+full.id+')" href="javascript:void(0)"><em class="icon ni ni-pen"></em><span>Edit</span></a></li>\n'+
                    deleteBank +
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

    window.addBank = function (id) {
        console.log(id);
        var url = process.env.MIX_APP_URL + '/admin/banks/create';
        if (id) {
            url = process.env.MIX_APP_URL + '/admin/banks/' + id + '/edit';
        }
        $.ajax({
            url: url,
            type: "GET",
            data: {},
            success: function (response) {
                $('#addNewBankName').html(response);
                $('#addNewBankName').modal('show');
            },
            error: function (data) {
                handleError(data);
            }
        });
    }
  
    window.submitBankDetails = function () {
        var frm = $('#bank-form');
        var btn = $('#submit-btn');
        var method = "POST";
        if ($('#id').val()) {
            method = "PUT";
        }

        if (frm.valid()) {
            btn.prop('disabled', true);
            var showLoader = btn.html();
            showButtonLoader(btn, showLoader, 'disabled');
            $.ajax({
                url: $('#bank-form').attr('action'),
                type: method,
                data: frm.serialize(),
                success: function (response) {
                    if (response.success) {
                        showButtonLoader(btn, showLoader, 'enable');
                        successToaster(response.message, 'bank', { timeOut: 2000 });
                        $('#addNewBankName').modal('hide'); 
                        bank.DataTable().ajax.reload(); 
                    } else {
                        btn.prop('disabled', false);
                        errorToaster(response.message, 'bank', { timeOut: 2000 });
                    }
                },
                error: function (data) {
                    handleError(data);

                },
            });
        }
    };
});
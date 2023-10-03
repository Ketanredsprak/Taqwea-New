$(function() {

    function changeStatus(id, status) {
        var url = process.env.MIX_APP_URL + '/admin/subscriptions/' + id;
        $.ajax({
            type: "PUT",
            data: { _token: $('meta[name="csrf-token"]').attr('content'), status: status },
            url: url,
            success: function(data) {
                successToaster('Status updated successfully!');
            },
            error: function(err) {
                handleError(err);
            }
        });
    }

    var subscription = $('#subscription-datatable');

    NioApp.DataTable('#subscription-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/subscription/list",
            type: "get",

            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(subscription.DataTable().page.info().page) + 1;
                d.search = subscription.DataTable().search();
                d.status = $('#status').val();
                d.type_of_subscription = $('#type_of_subscription').val();
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {
            $('.edit', row).on('click', function() {
                $.ajax({
                    method: "GET",
                    url: process.env.MIX_APP_URL + '/admin/subscriptions/' + data.id + '/edit',
                    success: function(response) {
                        $('#edit-subscription').html(response);
                        $('#editSubscription').modal('show');
                        $("#featured").select2();
                    },
                    error: function(response) {
                        handleError(response);
                    },
                });
            });

            $('.change-status', row).on('click', function() {
                var isChecked = $(this).prop("checked");
                var status = isChecked ? 'active' : 'inactive';
                if (!isChecked) {
                    const swalWithBootstrapButtons = Swal.mixin({
                        customClass: {
                            confirmButton: 'btn btn-primary mr-2',
                            cancelButton: 'btn btn-light ripple-effect-dark'
                        },
                        buttonsStyling: false
                    });
                    swalWithBootstrapButtons.fire({
                        title: 'Are you sure?',
                        text: "You want to inactive this subscription!",
                        showCancelButton: true,
                        confirmButtonText: 'Yes, Inactive it!',
                    }).then((result) => {
                        if (result.value) {
                            changeStatus(data.id, status);
                        } else {
                            $('.change-status', row).prop("checked", true);
                        }
                    });
                } else {
                    changeStatus(data.id, status);
                }
            });
        },
        'order': [0, 'desc'],
        "columnDefs": [{
                "data": 'id',
                "targets": 'no',
                'orderable': false,
                "render": function(data, type, row, meta) {
                    return type == 'export' ? meta.row + 1 : data;
                }
            },
            {
                "name": 'subscription_name',
                "data": 'name',
                "targets": 'name',
            },

            {
                "name": 'allow_booking',
                "data": 'allow_booking',
                "targets": 'allow_booking',
            },
            {
                "name": 'class_hours',
                "data": 'class_hours',
                "targets": 'class_hours',
                'render': function(data, type, full, meta) {
                    return ' <span > ' + data + ' Hours</span>';
                }
            }, {
                "name": 'webinar_hours',
                "data": 'webinar_hours',
                "targets": 'webinar_hours',
                'render': function(data, type, full, meta) {
                    return ' <span > ' + data + ' Hours</span>';
                }
            },
            {
                "name": 'featured',
                "data": 'featured',
                "targets": 'featured',
            },
            {
                "name": 'commission',
                "data": 'commission',
                "targets": 'commission',
            },
            {
                "name": 'blog_commission',
                "data": 'blog_commission',
                "targets": 'blog_commission',
            },
            {
                "name": 'blog',
                "data": 'blog',
                "targets": 'blog',
            },
            {
                "name": 'status',
                "data": 'status',
                'targets': 'status',
                'render': function(data, type, full, meta) {
                    var checked = '';
                    if (data == 'active') {
                        checked = 'checked = checked';
                    }
                    return '<div class="custom-control custom-switch">' +
                        '<input type="checkbox" class="custom-control-input change-status" id="customSwitch' + full.id + '" value=' + full.id + ' ' + checked + '>' +
                        '<label class="custom-control-label" for="customSwitch' + full.id + '"></label>' +
                        '</div>';
                }
            },
            {
                "data": "id",
                "width": "80px",
                "targets": 'actions',
                "class": 'text-right',
                'orderable': false,
                "render": function(data, type, full, meta) {
                    var n = '<ul class="nk-tb-actions gx-1 justify-content-center"\n' +
                        ' <li>\n' +
                        '  <div class="dropdown">\n' +
                        '  <a href="javascript:void(0)" class="dropdown-toggle btn btn-icon btn-trigger" data-toggle="dropdown"><em class="icon ni ni-more-h"></em></a>\n' +
                        '  <div class="dropdown-menu dropdown-menu-right ">\n' +
                        '  <ul class="link-list-opt no-bdr">\n' +
                        ' <li><a href="javascript:void(0)" class="edit"><em class="icon ni ni-pen"></em><span>Edit</span></a></li>\n' +

                        '</ul>\n' +
                        '</div>\n' +
                        '</div>\n' +
                        '</li>\n' +
                        '</ul> ';

                    return n;
                }
            }
        ]
    });
    $("#subscription-btn").on('click', (function(e) {
        var frm = $('#subscription-frm');
        var btn = $('#subscription-btn');
        var btnName = btn.html();
        var url = $('#subscription-frm').attr('action');
        console.log(url);
        if (frm.valid()) {
            showButtonLoader(btn, btnName, 'disabled');
            $.ajax({
                url: url,
                type: "PUT",
                data: frm.serialize(),
                success: function(response) {
                    if (response.success) {
                        successToaster(response.message, 'Subscription Update');
                        setTimeout(function() {
                            window.location.href = process.env.MIX_APP_URL + '/admin/subscriptions';
                        }, 2000);
                    }
                },
                error: function(data) {
                    var obj = JSON.parse(data.responseText);
                    errorToaster(obj.message, 'Subscription Update');
                },
                complete: function() {
                    showButtonLoader(btn, btnName, 'enable');
                }
            });
        }
    }));
});
window.addSubscriptionPrice = function addSubscriptionPrice() {
    var html = `<div class="closeOption"> 
    <div class="d-flex align-items-center justify-content-end"> 
    <a href="javascript:void(0);" id="closeInput" class="icon remove-btn deleteSubscription"><span class="icon-close"><em class=" ni ni-minus"></em> Remove</span></a> 
    </div>
    <div class="form-group "> 
    <label class="form-label">Duration</label> 
    <input type="text" class="form-control mb-2" name="updateField[0][duration]" placeholder="Duration" value=""/>
    </div>
    <div class="form-group">
     <label class="form-label">Amount</label>
      <input type="text" class="form-control mb-2" name="updateField[0][amount]" placeholder="Amount" value=""/>
      </div>
      </div>`;
    $("#add").append(html);
};
$(document).on("click", ".deleteSubscription", function() {
    $(this).closest(".closeOption").remove();

});
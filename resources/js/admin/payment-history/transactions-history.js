$(function() {
    var userDatatable = $('#transaction-history-datatable');
    NioApp.DataTable('#transaction-history-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/transaction-history/list",
            type: "get",

            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(userDatatable.DataTable().page.info().page) + 1;
                d.search = userDatatable.DataTable().search();
                d.status = $('#status').val();
                d.from_date = $('#from_date').val() ? moment($('#from_date').val()).format('YYYY-MM-DD') : '';
                d.to_date = $('#to_date').val() ? moment($('#to_date').val()).format('YYYY-MM-DD') : '';
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {},
        "order": [0, "desc"],
        'columnDefs': [{
                'data': 'id',
                'name': 'id',
                'targets': 'id'
            },
            {
                'data': 'transaction_id',
                'name': 'transaction_id',
                'targets': 'transaction_id',
                "render": function(data, type, full, meta) {
                    return '#' + data;
                }
            },
            {
                'data': 'user.name',
                'name': 'name',
                'targets': 'name',
                'defaultContent': '--',
            },
            {
                'data': 'amount',
                'name': 'total_amount',
                'targets': 'total_amount',
                'defaultContent': '--',
                "render": function(data, type, full, meta) {
                    return config + ' ' + data;
                }
            },
            {
                'data': 'admin_commission',
                'name': 'admin_commission',
                'targets': 'admin_commission',
                "render": function(data, type, full, meta) {
                    if (full.status == 'refunded') {
                        return config + ' ' + '0';
                    } else {
                        return config + ' ' + (data.commission == 0 ? full.amount_t : data.commission);
                    }
                }
            },
            {
                'data': 'transaction_date',
                'name': 'transaction_date',
                'targets': 'date',
                'defaultContent': '--',
                "render": function(data, type, full, meta) {
                    return moment.utc(data).local().format('MM/DD/YYYY LT')
                }
            },
            {
                'data': 'status',
                'name': 'status',
                'targets': 'status',
                'render': function(data, type, full, meta) {
                    if (data == "success") {
                        return '<span class="text-success">' + data + '</span>'
                    } else if (data == 'pending') {
                        return '<span class="text-warning">' + data + '</span>'
                    } else {
                        return '<span class="text-danger">' + data + '</span>'
                    }
                }
            },
            {
                'data': 'payment_mode',
                'name': 'payment_mode',
                'targets': 'payment_type',
                'render': function(data, type, full, meta) {
                    if (data == "direct_payment") {
                        return '<span >Direct Payment</span>'
                    } else {
                        return '<span >Wallet</span>'
                    }
                }
            }
        ]
    });
    $('#transactions-history-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        userDatatable.DataTable().draw(true);
    });
    window.reset = function() {
        $('.dot').removeClass('dot-success');
        $('.form-select').val('').trigger('change');
        $('#status').val('');
        $('#to_date').val('');
        $('#from_date').val('');
        clearDatepicker();
        userDatatable.DataTable().draw(true);
    }
});
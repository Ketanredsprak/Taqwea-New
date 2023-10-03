$(function() {
    var running_subscription = $('#running-subscription-datatable');

    NioApp.DataTable('#running-subscription-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "ajax": {

            url: process.env.MIX_APP_URL + "/admin/running-subscription/list",
            type: "get",

            data: function(d) {
                d.size = d.length;
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.page = parseInt(running_subscription.DataTable().page.info().page) + 1;
                d.search = running_subscription.DataTable().search();
                d.status = 'active';
                d.from_date = $('#from_date').val() ? moment.utc($('#from_date').val()).format('YYYY-MM-DD') : '';
                d.to_date = $('#to_date').val() ? moment.utc($('#to_date').val()).format('YYYY-MM-DD') : '';
                // d.type_of_subscription = $('#type_of_subscription').val();
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            }
        },
        'createdRow': function(row, data) {},
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "name": 'id',
                "data": 'id',
                "targets": 'id',

                "render": function(data, type, row, meta) {
                    return type == 'export' ? meta.row + 1 : data;
                }
            },
            {
                "name": 'subscription_name',
                "data": 'subscription_name',
                "targets": 'subscription_name',
                'render': function(data, type, full, meta) {
                    return ' <span > ' + full.subscription.subscription_name + '</span>';
                }
            },

            {
                "name": 'created_at',
                "data": 'date',
                "targets": 'date',
                'render': function(data, type, full, meta) {
                    return moment.utc(data).local().format('MM/DD/YYYY LT');
                }

            },
            {
                "name": 'subscription_detail',
                "data": 'subscription_details',
                "targets": 'subscription_details',
                'render': function(data, type, full, meta) {
                    return ' <span > ' + full.subscription.subscription_description + ' Hours</span>';
                }
            }, {
                "name": 'tutor_name',
                "data": 'tutor_name',
                "targets": 'tutor_name',
                'render': function(data, type, full, meta) {

                    var n = '<div class="user-card">\n' +
                        ' <div class = "user-info"  >\n' +
                        ' <span class = "tb-lead"> ' + full.tutor.name + ' </span>\n' +
                        ' <span class = "d-block"> ' + full.tutor.email + '</span>\n' +
                        ' </div>\n' +
                        '</div>';
                    return n;
                }
            },
            {
                "name": 'transaction',
                "data": 'amount',
                "targets": 'amount',
                'render': function(data, type, full, meta) {
                    return ' <span > ' + full.transaction.amount + '</span>';
                }

            },
            {
                "name": 'expiry_days',
                "data": 'expiry_days',
                "targets": 'expiry_days',
            },
            {
                "name": 'end_date',
                "data": 'end_date',
                "targets": 'end_date',
                'orderable': false,
            },
        ]
    });
    $('#subscription-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        running_subscription.DataTable().ajax.reload();
    });
    $('.reset-filter').on('click', function(e) {
        $('.dot').removeClass('dot-success');
        $('.form-select').val('').trigger('change');
        $('#from_date').val('');
        $('#to_date').val('');
        clearDatepicker();
        // $('#type_of_subscription').val('');
        running_subscription.DataTable().ajax.reload();
    });
})
$(function() {
    var payDetailTable = $('#payout-details-datatable');
    var id = $('#id').val();
    NioApp.DataTable('#payout-details-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        'searching': false,
        "info":     false,
        "lengthChange": false,
        "ajax": {
            url: process.env.MIX_APP_URL + "/accountant/pay-detail-list/" + id,
            type: "get",

            data: function(d) {
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.search = payDetailTable.DataTable().search();
                d.size = d.length;
                d.page = parseInt(payDetailTable.DataTable().page.info().page) + 1;
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            },
        },
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                "name": "id",
                "targets": 'id'
            },
            {
                "data": 'transaction_id',
                "name": 'transaction_id',
                "targets": 'transaction_id',
                'defaultContent': '--',
                'render': function(data, type, full, meta){
                    return "#"+data;
                }
            },
            {
                "data": 'created_at',
                "name": 'created_at',
                "targets": 'Date_and_time',
                "render": function(data, type, full, meta) {
                    return moment.utc(data).local().format('MM/DD/YYYY LT')
                }
            },
            {
                "data": 'account_number',
                "name": 'account_number',
                'targets': 'payment_to',
                'defaultContent': '--'
            },
            {
                "data": 'amount',
                "name": 'amount',
                'targets': 'total_payout',
                'defaultContent': '--',
                'render': function(data, type, full, meta){
                    return config+ " "+data;
                }
            },
            {
                "data": "status",
                "name": "status",
                "targets": 'status',
                'defaultContent': '--',
                'render': function(data, type, full, meta){
                    if(data == "Success") {
                        return "<span class='text-success'>"+data+"</span>";
                    }
                    return "<span class='text-danger'>"+data+"</span>";
                    
                }
            }
        ],
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api();   
            // converting to interger to find total
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            // computing column Total of the complete result 
            var Total = api
                .column(4)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(3).footer()).html('Total Payout');
            $(api.column(4).footer()).html( config +" "+ (data[0]) ? data[0].total_amount : 0 );

        }
    });
});

$(function() {
    var earningHistoryTable = $('#earning-history-datatable');
    var id = $('#id').val();
    NioApp.DataTable('#earning-history-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        'searching': false,
        "info":     false,
        "lengthChange": false,
        "ajax": {
            url: process.env.MIX_APP_URL + "/accountant/earning-history-list/" + id,
            type: "get",

            data: function(d) {
                d.sortColumn = d.columns[d.order[0]['column']]['name'];
                d.sortDirection = d.order[0]['dir'];
                d.search = earningHistoryTable.DataTable().search();
                d.size = d.length;
                d.page = parseInt(earningHistoryTable.DataTable().page.info().page) + 1;
            },
            dataSrc: function(d) {
                d.recordsTotal = d.meta.total;
                d.recordsFiltered = d.meta.total;

                return d.data;
            },
        },
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                "name": "id",
                "targets": 'id'
            },
            {
                "data": 'from',
                "name": 'from',
                "targets": 'from',
                'defaultContent': '--',
                'orderable' : false,
                'render': function(data, type, full, meta){
                    return data;
                }
            },
            {
                "data": 'title',
                "name": 'title',
                "targets": 'title',
                'defaultContent': '--',
                'orderable' : false,
                "render": function(data, type, full, meta) {
                    return data;
                }
            },
            {
                "data": 'booking_count',
                "name": 'booking_count',
                'targets': 'no_of_bookings',
                'defaultContent': '--'
            },
            {
                "data": 'booking_amount',
                "name": 'booking_amount',
                'targets': 'booking_amount',
                'defaultContent': '--',
                'render': function(data, type, full, meta){
                    return config+ " "+data;
                }
            },
            {
                "data": "admin_commission",
                "name": "admin_commission",
                "targets": 'admin_commission',
                'defaultContent': '--',
                'render': function(data, type, full, meta){
                    return config+ " "+data;
                }
            } ,{
                "data": 'total_refund',
                "name": 'total_refund',
                'targets': 'refunds',
                'defaultContent': '--',
                'render': function(data, type, full, meta){
                    return config+ " "+data;
                }
            },
            {
                "data": 'fine',
                "name": 'fine',
                'targets': 'fine',
                'defaultContent': '--',
                'render': function(data, type, full, meta){
                   
                    return config+ " "+data;
                }
            },
            {
                "data": 'final_earning',
                "name": 'final_earning',
                'targets': 'final_earning',
                'defaultContent': '--',
                'render': function(data, type, full, meta){
                    return config+ " "+data;
                }
            },
           
        ],
        "footerCallback": function(row, data, start, end, display) {
            var api = this.api();   
            // converting to interger to find total
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            // computing column Total of the complete result 
            var Total = api
                .column(4)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            var final_earning = (data[0].total_earning.booking_amount - data[0].total_earning.admin_commission).toFixed(2);
            final_earning = (final_earning - data[0].tutor_fine).toFixed(2);
           
            $(api.column(2).footer()).html('Total');
            $(api.column(3).footer()).html( data[0].total_earning.booking_count );
            $(api.column(4).footer()).html( config +" "+ data[0].total_earning.booking_amount.toFixed(2) );
            $(api.column(5).footer()).html( config +" "+ data[0].total_earning.admin_commission.toFixed(2) );
            $(api.column(6).footer()).html( config +" "+ data[0].total_earning.total_refund.toFixed(2) );
            $(api.column(7).footer()).html( config +" "+ data[0].tutor_fine);
            $(api.column(8).footer()).html( config +" "+  final_earning);

        }
    });
});
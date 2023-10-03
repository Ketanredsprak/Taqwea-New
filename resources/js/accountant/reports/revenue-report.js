$(function() {
    var revenueReportTable = $('#revenue-report-datatable');
    NioApp.DataTable('#revenue-report-datatable', {
        "processing": true,
        "serverSide": true,
        "bDestroy": true,
        "paging": false,
        "bInfo": false,
        "ajax": {

            url: process.env.MIX_APP_URL + "/accountant/revenue-report/list",
            type: "get",

            data: function(d) {
                d.year = $('#year').val();
            },
            dataSrc: function(d) {
                return d.data;
            }
        },
        'createdRow': function(row, data) {},
        "stateSave": true,
        "order": [0, "desc"],
        "columnDefs": [{
                "data": 'id',
                "targets": 'no',
                'render': function(data, type, full, meta) {
                    return data;
                }
            },
            {
                "data": 'date',
                "targets": 'month',
            },
            {
                "data": 'subscription',
                "targets": 'subscription',

            },
            {
                'data': 'class',
                'targets': 'classes',
            },
            {
                'data': 'webinar',
                'targets': 'webinars',
            },
            {
                'data': 'blog',
                'targets': 'blogs',
            },
            {
                'data': 'fine',
                'name': 'fine',
                'targets': 'fine',
                'orderable': false,
                
            },
            
            {
                'data': 'points',
                'name': 'points',
                'targets': 'points',
                'orderable': false,
                render: function (data, type, row, meta) { 
                    let pointsInSAR = row.pointsInSAR;
                    let points = row.points;
                    
                    // convert positive value to negative value
                    if(points > 0 )  { 
                        return `<div >
                            ${pointsInSAR.toFixed(2)} 
                            <em data-toggle="tooltip" data-placement="top" title="${points} points = ${pointsInSAR} SAR" class="icon icon-info"></em>
                        </div> `
                    } 

                   return '0.00';
                }
            },
            {
                'data': 'total',
                'name': 'total',
                'targets': 'total',
                'orderable': false,
            }

        ],

        "footerCallback": function(row, data, start, end, display) {
            var api = this.api(),
                data;

            // converting to interger to find total
            var intVal = function(i) {
                return typeof i === 'string' ?
                    i.replace(/[\$,]/g, '') * 1 :
                    typeof i === 'number' ?
                    i : 0;
            };

            // computing column Total of the complete result 
            var Total = api
                .column(8)
                .data()
                .reduce(function(a, b) {
                    return intVal(a) + intVal(b);
                }, 0);
            $(api.column(7).footer()).html('Total');
            $(api.column(8).footer()).html(Total);

        }
    });
    $('#revenue-report-filter').on('click', function(e) {
        $('.dot').addClass('dot-success');
        revenueReportTable.DataTable().draw(true);
    });
    window.reset = function() {
        $('.dot').removeClass('dot-success')
        $('#year').val('');
        revenueReportTable.DataTable().draw(true);
    }
});
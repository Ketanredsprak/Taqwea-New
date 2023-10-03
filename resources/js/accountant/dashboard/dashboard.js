$(function() {
    $(function() {
        var data = new Date().getFullYear();
        getDashboardCount(data);
    });
    window.getDashboardCount = function getDashboardCount(data) {
        $('.filter').removeClass('active');
        var id = data;
        data = {
            data: data
        };
        $.ajax({
            method: "GET",
            url: process.env.MIX_APP_URL + "/accountant/dashboard-chart",
            data: data,
            dataType: "JSON",
            success: function(response) {
                $('#' + id).addClass('active');
                console.log(response.class);
                countDashBoard(response);
            },
            error: function(data) {},
        });
    }
    window.countDashBoard = function(response) {
        //revenue
        var charts = document.querySelector("#bar");
        var options = {
            series: [{
                name: 'Blogs',
                data: response.blog
            }, {
                name: 'Classes',
                data: response.class
            }, {
                name: 'Webinars',
                data: response.webinar
            }],
            chart: {
                type: 'bar',
                height: 400,
                toolbar: {
                    show: false,
                },
                fontFamily: 'Nunito, sans-serif',
                fontSize: '18',
            },
            colors: ['#f93a5a', '#029666', '#f7a556'],
            plotOptions: {
                bar: {
                    horizontal: false,
                    columnWidth: '55%',
                    endingShape: 'rounded'
                },
            },
            dataLabels: {
                enabled: false
            },
            stroke: {
                show: true,
                width: 1,
                colors: ['transparent']
            },
            xaxis: {
                categories: ['Jan', ' Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'],
            },
            yaxis: {
                title: {
                    text: 'SAR 1000'
                }
            },
            fill: {
                opacity: 1
            },
            tooltip: {
                shared: true,
                followCursor: true,
                y: {
                    formatter: function(val) {
                        return "SAR " + val;
                    }
                },
            }
        };

        if (window.totalChart != undefined)
            window.totalChart.destroy();
        window.totalChart = new ApexCharts(charts, options);
        // var chart = new ApexCharts(charts, options);
        window.totalChart.render();
    }
})
$(document).ready(function() {
    var sideBarNavHide = function() {
        if ($('.navbar-side').length == 0) {
            $('.page-content .content').css('margin-left', '0');
        }
    };
    
    sideBarNavHide();
    
    if ($('.navbar-side').length > 0) {
        var stickyNavTop = $('.navbar-side').offset().top;
        var stickyNav = function() {
            var scrollTop = $(window).scrollTop();

            if (scrollTop > stickyNavTop) {
                $('.navbar-side').addClass('navbar-side-fixed');
            }
            else {
                $('.navbar-side').removeClass('navbar-side-fixed');
            }
        };


        stickyNav();

        $(window).scroll(function() {
            stickyNav();
        });
    }
        
    $('.panel a.toggle').click(function() {
        if ($(this).parent().parent().parent().parent().children('.panel-body').css('display') == 'none') {
            //$(this).children('span.fa').removeClass('fa-angle-down').addClass('fa-angle-up');
            $(this).parent().parent().parent().parent().children('.panel-body').show();
        }
        else {
            //$(this).children('span.fa').removeClass('fa-angle-up').addClass('fa-angle-down');
            $(this).parent().parent().parent().parent().children('.panel-body').hide();
        }
    });
    
    $('#toggle-navbar-side').click(function() {
        if ($('.navbar-side').css('display') == 'none') {
            $('.navbar-side').show();
            $('.page-content .content').css('margin-left', '192px');
        }
        else {
            $('.navbar-side').hide();
            $('.page-content .content').css('margin-left', '0');
        }
    });

    //Chart.js
//    var randomScalingFactor = function(){ return Math.round(Math.random() * 100)};
//    var barChartData = {
//        labels : ["January","February","March","April","May","June","July"],
//        datasets : [
//            {
//                fillColor : "rgba(220,220,220,0.5)",
//                strokeColor : "rgba(220,220,220,0.8)",
//                highlightFill: "rgba(220,220,220,0.75)",
//                highlightStroke: "rgba(220,220,220,1)",
//                data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
//            },
//            {
//                fillColor : "rgba(151,187,205,0.5)",
//                strokeColor : "rgba(151,187,205,0.8)",
//                highlightFill : "rgba(151,187,205,0.75)",
//                highlightStroke : "rgba(151,187,205,1)",
//                data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
//            }
//        ]
//    };
//    var lineChartData = {
//        labels : ["January","February","March","April","May","June","July"],
//        datasets : [
//            {
//                label: "My First dataset",
//                fillColor : "rgba(220,220,220,0.2)",
//                strokeColor : "rgba(220,220,220,1)",
//                pointColor : "rgba(220,220,220,1)",
//                pointStrokeColor : "#fff",
//                pointHighlightFill : "#fff",
//                pointHighlightStroke : "rgba(220,220,220,1)",
//                data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
//            },
//            {
//                label: "My Second dataset",
//                fillColor : "rgba(151,187,205,0.2)",
//                strokeColor : "rgba(151,187,205,1)",
//                pointColor : "rgba(151,187,205,1)",
//                pointStrokeColor : "#fff",
//                pointHighlightFill : "#fff",
//                pointHighlightStroke : "rgba(151,187,205,1)",
//                data : [randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor(),randomScalingFactor()]
//            }
//        ]
//    };
//    
//    var chart1 = document.getElementById('chart1').getContext('2d');
//    var newChart1 = new Chart(chart1).Bar(barChartData, { responsive : true });
//    
//    var chart2 = document.getElementById('chart2').getContext('2d');
//    var newChart2 = new Chart(chart2).Line(lineChartData, { responsive: true });

    //flot.js
    var sin = [],
        cos = [];

    for (var i = 0; i < 14; i += 0.5) {
        sin.push([i, Math.sin(i)]);
        cos.push([i, Math.cos(i)]);
    }

    var plot = $.plot('#chart1', [
        { data: sin, label: "sin(x)"},
        { data: cos, label: "cos(x)"}
    ], {
        series: {
            lines: {
                show: true
            },
            points: {
                show: true
            }
        },
        grid: {
            hoverable: true,
            clickable: true
        },
        yaxis: {
            min: -1.2,
            max: 1.2
        }
    });

    //flot.js
    var barData = [ ["January", 10], ["February", 8], ["March", 4], ["April", 13], ["May", 17], ["June", 9] ];
    $.plot('#chart2', [ barData ], {
        series: {
            bars: {
                show: true,
                barWidth: 0.6,
                align: 'center'
            }
        },
        xaxis: {
            mode: 'categories',
            tickLength: 0
        }
    });
});

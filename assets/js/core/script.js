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
        },
        width: '100%',
        height: '100%'
    });
});

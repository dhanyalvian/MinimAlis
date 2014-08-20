$(document).ready(function() {
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
    
    $('#toggle-navbar-side').click(function() {
        if ($('.navbar-side').css('display') == 'none') {
            $('.navbar-side').show();
            $('.page-content .content').css('margin-left', '192px');
        }
        else {
            $('.navbar-side').hide();
            $('.page-content .content').css('margin-left', '0');
        }
//        $('.navbar-side').toggle('fast', function() {
//            $(this).hide();
//        });
    });
    
//    $('#toggle-navbar-side').toggle(
//        function() {
//            $('.navbar-side').hide();
//        },
//        function() {
//            $('.navbar-side').show();
//        }
//    );
});
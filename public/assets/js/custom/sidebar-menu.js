$(function () {
    $(".menu-item:not(.menu-accordion) > a").each(function () {
        var href = window.location.href.replace(/\?.*/g, "");
        if ($(this).attr('href') == href || href.indexOf($(this).attr('href') + '/') > -1) {
        // if ($(this).attr('href') == href) {
            // $(this).attr('href', '#');
            $(this).closest('.menu-item').addClass('here');
            $(this).closest('.menu-accordion').addClass('here show');
        }
    })
});

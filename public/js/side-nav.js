$(function() {
    $('.btn-expand-collapse').click(function(e) {
        $('.navbar-primary').toggleClass('collapsed');
        $('#nav-expand-icon').toggleClass('fa-angle-left');
        $('#nav-expand-icon').toggleClass('fa-angle-right');
    });
});
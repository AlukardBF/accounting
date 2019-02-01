$(document).ready(function($) {
    $("tr.clickable").dblclick(function() {
        window.location = $(this).data("href");
    });
});
$(document).ready(function() {
    $('.spinnerA').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>');
    });

    $('.spinnerB').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>');
    });

    $('.spinnerC').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>');
    });
});
$(document).ready(function() {
    $('.spinner-primary').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-primary" role="status" aria-hidden="true"></span>');
    });

    $('.spinner-secondary').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-secondary" role="status" aria-hidden="true"></span>');
    });

    $('.spinner-light').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span>');
    });

    $('.spinner-info').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-info" role="status" aria-hidden="true"></span>');
    });

    $('.spinner-danger').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-danger" role="status" aria-hidden="true"></span>');
    });

    $('.spinner-success').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-success" role="status" aria-hidden="true"></span>');
    });

    $('.spinner-light-cv').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-light" role="status" aria-hidden="true"></span> Aguarde...');
    });

    $('.spinner-warning-cv').click(function(event) {
        $(this).html('<span class="spinner-border spinner-border-sm text-dark" role="status" aria-hidden="true"></span> Aguarde...');
    });
});
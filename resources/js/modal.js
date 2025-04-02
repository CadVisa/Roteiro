$(document).ready(function () {
    $('div[id^="deleteModal-"]').on('show.bs.modal', function () {
        $(this).find('#closeModal').each(function () {
            $(this).html(
                $(this).data('original-html') ||
                '<i class="fa-solid fa-xmark"></i> Cancelar'
            );
            $(this).prop('disabled', false);
        });
    });
});
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

$(document).ready(function () {
    $('#deleteLogsModal').on('show.bs.modal', function () {
        // Resetar botão cancelar
        $(this).find('#closeModal').each(function () {
            $(this).html(
                $(this).data('original-html') ||
                '<i class="fa-solid fa-xmark"></i> Cancelar'
            );
            $(this).prop('disabled', false);
        });

        // Resetar o select do período
        $(this).find('#periodoSelect').val('').change();
    });
});

$(document).ready(function () {
    $('#deleteLogsModal form').on('submit', function (e) {
        let selected = $('#periodoSelect').val();

        if (!selected) {
            e.preventDefault(); // impede o submit

            // Remove alertas antigos, se existirem
            $('#logModalError').remove();

            // Restaura botão "Excluir" se tiver sido modificado
            let excluirBtn = $(this).find('#submitDeleteLogs');
            excluirBtn.html('<i class="fa-regular fa-trash-can"></i> Excluir');
            excluirBtn.prop('disabled', false);

            // Adiciona alerta
            $(this).prepend(`
                <div id="logModalError" class="alert alert-danger alert-dismissible  mt-2 m-auto fade show" role="alert" style="max-width: 400px;">
                    <i class="fa-solid fa-triangle-exclamation me-2 fs-5"></i>
                    <small>Selecione um período para exclusão dos logs.</small>
                </div>
            `);
        }
    });

    // Limpa o select e erro ao fechar a modal
    $('#deleteLogsModal').on('hidden.bs.modal', function () {
        $('#periodoSelect').val('');
        $('#logModalError').remove();
    });
});





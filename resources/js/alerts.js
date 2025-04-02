$(document).ready(function () {
    $('#alert-success, #alert-error').each(function () {
        const alert = $(this);
        let timer;

        const closeAlert = function () {
            alert.animate({
                opacity: 0,
                paddingTop: 0,
                paddingBottom: 0,
                marginBottom: 0
            }, {
                duration: 700,
                easing: 'swing', // Easing padrão do jQuery (já disponível)
                complete: function () {
                    $(this).slideUp({
                        duration: 200,
                        easing: 'swing',
                        complete: function () {
                            $(this).remove();
                        }
                    });
                }
            });
            alert.off('mouseenter mouseleave');
        };

        timer = setTimeout(closeAlert, 5000);

        alert.hover(
            function () {
                clearTimeout(timer);
            },
            function () {
                timer = setTimeout(closeAlert, 5000);
            }
        );
    });
});
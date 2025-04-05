document.addEventListener('DOMContentLoaded', function () {
    const alertDiv = document.getElementById('alert-info');
    const fecharBtn = document.getElementById('fecharInfo');
    const cookieName = 'CadVisaOfferDismissed';

    if (alertDiv) {
        function setCookie(name, value, days) {
            const d = new Date();
            d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
            document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
        }

        function getCookie(name) {
            const cookies = document.cookie.split(';');
            for (let i = 0; i < cookies.length; i++) {
                const cookie = cookies[i].trim();
                if (cookie.startsWith(name + '=')) {
                    return cookie.substring((name + '=').length);
                }
            }
            return null;
        }

        // Exibe o alerta apenas se o cookie ainda não existe
        if (!getCookie(cookieName)) {
            alertDiv.style.display = 'block';
        }

        // Ao clicar em "Fechar", define o cookie por 15 dias e esconde o alerta
        fecharBtn.addEventListener('click', function () {
            setCookie(cookieName, '1', 15);
            alertDiv.style.display = 'none';
        });
    }

});
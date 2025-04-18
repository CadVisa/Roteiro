document.addEventListener('DOMContentLoaded', function () {
    const cookieName = 'cadvisa_consent';
    const cookieVersionName = 'cadvisa_versao_termo';
    const versaoAtual = document.querySelector('meta[name="versao-termo"]').getAttribute('content');

    function setCookie(name, value, days) {
        const d = new Date();
        d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
        document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
    }

    function getCookie(name) {
        const cookies = document.cookie.split(';');
        for (let i = 0; i < cookies.length; i++) {
            const cookie = cookies[i].trim();
            if (cookie.indexOf(name + '=') === 0) {
                return cookie.substring((name + '=').length, cookie.length);
            }
        }
        return null;
    }

    const existingConsent = getCookie(cookieName);
    const existingVersion = getCookie(cookieVersionName);

    if (!existingConsent || existingVersion !== versaoAtual) {
        document.getElementById('cookie-consent').style.display = 'block';
    } else {
        // Renova ambos os cookies
        setCookie(cookieName, existingConsent, 90);
        setCookie(cookieVersionName, existingVersion, 90);
    }

    document.getElementById('acceptCookies').addEventListener('click', function () {
        const token = crypto.randomUUID();
        setCookie(cookieName, token, 90);
        setCookie(cookieVersionName, versaoAtual, 90);
        sendConsent(token, true);
        document.getElementById('cookie-consent').style.display = 'none';
    });

    document.getElementById('declineCookies').addEventListener('click', function () {
        setCookie(cookieName, 'recusado', 90);
        setCookie(cookieVersionName, versaoAtual, 90);
        sendConsent('recusado', false);
        document.getElementById('cookie-consent').style.display = 'none';
    });

    function sendConsent(token, accepted = true) {
        fetch('/consent', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
            },
            body: JSON.stringify({
                token: token,
                accepted: accepted
            })
        });
    }
});




// document.addEventListener('DOMContentLoaded', function () {
//     const cookieName = 'cadvisa_consent';

//     function setCookie(name, value, days) {
//         const d = new Date();
//         d.setTime(d.getTime() + (days * 24 * 60 * 60 * 1000));
//         document.cookie = `${name}=${value};expires=${d.toUTCString()};path=/`;
//     }

//     function getCookie(name) {
//         const cookies = document.cookie.split(';');
//         for (let i = 0; i < cookies.length; i++) {
//             const cookie = cookies[i].trim();
//             if (cookie.indexOf(name + '=') === 0) {
//                 return cookie.substring((name + '=').length, cookie.length);
//             }
//         }
//         return null;
//     }

//     function sendConsent(token, accepted = true) {
//         fetch('/consent', {
//             method: 'POST',
//             headers: {
//                 'Content-Type': 'application/json',
//                 'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').getAttribute('content')
//             },
//             body: JSON.stringify({
//                 token: token,
//                 accepted: accepted
//             })
//         });
//     }

//     const existingConsent = getCookie(cookieName);

//     if (!existingConsent) {
//         document.getElementById('cookie-consent').style.display = 'block';
//     } else {
//         // Renova o cookie automaticamente a cada visita
//         setCookie(cookieName, existingConsent, 90);
//     }

//     document.getElementById('acceptCookies').addEventListener('click', function () {
//         const token = crypto.randomUUID();
//         setCookie(cookieName, token, 90);
//         sendConsent(token, true);
//         document.getElementById('cookie-consent').style.display = 'none';
//     });

//     document.getElementById('declineCookies').addEventListener('click', function () {
//         setCookie(cookieName, 'recusado', 90);
//         sendConsent('recusado', false);
//         document.getElementById('cookie-consent').style.display = 'none';
//     });
// });

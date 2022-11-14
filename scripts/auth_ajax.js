let exitButton = document.getElementById('exit_button');
let form = document.getElementById('ajax_form');
let greeting = document.getElementById('greeting');

$(document).ready(() => {
    $(document).on('click', '#btn', () => {
        ajaxRegisterQuery('ajax_form');
    });

    if (getCookie('username') !== undefined) {
        exitButton.classList.add('show');
        form.classList.add('hide');
        greeting.classList.remove('hide');
        let greetPhrase = 'Hello, ' + getCookie('username') + '!';
        $('#greeting').text(greetPhrase);
    }
});


exitButton.addEventListener('click', () => {
    exitButton.classList.remove('show');
    form.classList.remove('hide');
    greeting.classList.remove('show');

    deleteCookie('username');

    $('#login_error').text('');
    $('#password_error').text('');
    $('#greeting').text('');
});


function ajaxRegisterQuery(ajax_form) {
    $.ajax({
        url: 'src/handlers/auth_handler.php',
        type: 'POST',
        dataType: 'html',
        data: $('#' + ajax_form).serialize(),

        success: function (response) {
            console.log(response);
            let result = $.parseJSON(response);

            console.log(response);

            if (result.success) {
                setCookie('username', result['success']);

                exitButton.classList.add('show');
                form.classList.add('hide');
                greeting.classList.remove('hide');

                let greetPhrase = 'Hello, ' + getCookie('username') + '!';
                $('#greeting').text(greetPhrase);
            } else if (result.error) {
                $('#error').text(result.error);
            }
        },
        error: function (response) {
            $('#error').text('SOMETHING WENT WRONG');
        }
    });
}

function getCookie(name) {
    let matches = document.cookie.match(new RegExp(
        "(?:^|; )" + name.replace(/([\.$?*|{}\(\)\[\]\\\/\+^])/g, '\\$1') + "=([^;]*)"
    ));
    return matches ? decodeURIComponent(matches[1]) : undefined;
}

function deleteCookie(name) {
    setCookie(name, "", {
        'max-age': -1
    })
}

function setCookie(name, value, options = {}) {
    let now = new Date();
    let time = now.getTime();
    let expireTime = time + 1000 * 36000;

    options = {
        path: '/',
        // при необходимости добавьте другие значения по умолчанию
        ...options
    };

    if (options.expires instanceof Date) {
        options.expires = options.expires.toUTCString();
    }

    let updatedCookie = encodeURIComponent(name) + '=' + encodeURIComponent(value);

    for (let optionKey in options) {
        updatedCookie += '; ' + optionKey;
        let optionValue = options[optionKey];
        if (optionValue !== true) {
            updatedCookie += '=' + optionValue;
        }
    }

    document.cookie = updatedCookie;
}
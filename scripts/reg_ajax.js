$(document).ready(() => {
    $('#result').text('');
    $(document).on('click', '#btn', () => {
        ajaxRegisterQuery('ajax_form');
        $('#name_error').text('');
        $('#email_error').text('');
        $('#login_error').text('');
        $('#password_error').text('');
        $('#confirm_password_error').text('');
    });
});

function ajaxRegisterQuery(ajax_form) {

    $.ajax({
        url: '../src/handlers/reg_handler.php',
        type: 'POST',
        dataType: 'html',
        data: $('#' + ajax_form).serialize(),

        success: function (response) {
            let result = $.parseJSON(response);
            console.log(response);

            if (result === 'success') {
                let res = document.getElementById('result');
                res.innerHTML = 'SUCCESSFULLY REGISTERED <a href="../auth.php"> CLICK TO AUTHORIZE </a>';
            } else {
                $('#name_error').text(result.name);
                $('#email_error').text(result.email);
                $('#login_error').text(result.login);
                $('#password_error').text(result.password);
                $('#confirm_password_error').text(result.confirm_password);
                $('#result').text('');

            }
        },
        error: function (response) {
            $('#result').text('SOMETHING WENT WRONG');
        }
    });
}
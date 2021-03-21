$(document).ready(function() {
    let email = '';
    let password = '';

    $('#email').on('change', function () {
        email = $('#email').val();
    });

    $('#password').on('change', function () {
        password = $('#password').val();
    });

    $('#btn_sign_in').on('click', function () {
        $.ajax({
            url: "/api/login",
            method: 'POST',
            data: {
                'email': email,
                'password': password,
            },
            success: function(response) {
                localStorage.setItem('api_token', JSON.stringify(response));
            },
            error: function (msg) {
                localStorage.setItem('error', JSON.stringify(msg));
            }
        })
    });

    $('#btn_sign_in_admin').on('click', function () {
        $.ajax({
            url: "/api/admin/login",
            method: 'POST',
            data: {
                'email': email,
                'password': password,
            },
            success: function(response) {
                localStorage.setItem('api_token', JSON.stringify(response));
            },
            error: function (msg) {
                localStorage.setItem('error', JSON.stringify(msg));
            }
        })
    });
})

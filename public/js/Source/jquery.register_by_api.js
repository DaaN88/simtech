$(document).ready(function() {
    let name = '';
    let email = '';
    let password = '';

    $('#name').on('change', function() {
        name = $('#name').val();
    });

    $('#email').on('change', function() {
        email = $('#email').val();
    });

    $('#password').on('change', function() {
        password = $('#password').val();
    });

    $('#btn_register').on('click', function() {
        $.ajax({
            url: "/api/register",
            method: 'POST',
            data: {
                'name': name,
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

    $('#btn_register_admin').on('click', function () {
        $.ajax({
            url: "/api/admin/register",
            method: 'POST',
            data: {
                'name': name,
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

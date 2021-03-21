$(document).ready(function() {
    let api_token = JSON.parse(localStorage.getItem('api_token'));

    let dns_type = '';
    let dns_domain = '';

    $('#dns_type').on('change', function () {
        dns_type = $('#dns_type').val();
        console.log(dns_type);
    });

    $('#dns_domain').on('change', function () {
        dns_domain = $('#dns_domain').val();
        console.log(dns_domain)
    });

    $('#get_dns').on('click', function () {
        $.ajax({
            url: "/api/dns",
            headers: {
                'Authorization':'Bearer ' + api_token.token,
            },
            method: 'POST',
            data: {
                type: dns_type,
                domain: dns_domain
            },
            success: function(jqXHR) {
                let response = jqXHR
                console.log(response);

                if (response.error) {
                    alert(response.error);
                    return;
                }

                $('#dns_result').val(response.result);
            },
            error: function (jqXHR) {
                alert(jqXHR.responseText);
            }
        })
    });
})

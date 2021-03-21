$(document).ready(function() {
    let api_token = JSON.parse(localStorage.getItem('api_token'));

    // === GET ALL LOGS ================================================================================================
    $('#get_logs').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: "api/admin/log",
            headers: {
                'Authorization':'Bearer ' + api_token.token,
            },
            method: 'GET',
            data: {

            },
            success: function(jqXHR) {
                let response = jqXHR

                let ret = response.result.map(function (element) {
                    return 'API_URL: ' + element.api_url + ': ; REQUEST: ' + element.request + '; RESPONSE: ' + element.response + '\n';
                })

                if (response.error) {
                    alert(response.error);
                    return;
                }

                $('#logs').val((ret.length === 0) ? 'Data doesn\'t exists' : ret.join('\n'));
            },
            error: function (jqXHR) {
                alert(jqXHR.responseText);
            }
        })
    });
    // =================================================================================================================

    // === CLEAR ALL LOGS ==============================================================================================
    $('#clear_logs').on('click', function(event) {
        event.preventDefault();

        $('#logs').val('');

        $.ajax({
            url: "api/admin/log/clear",
            headers: {
                'Authorization':'Bearer ' + api_token.token,
            },
            method: 'DELETE',
            data: {

            },
            success: function(jqXHR) {
                alert(jqXHR.result);
            },
            error: function (jqXHR) {
                alert(jqXHR.responseText);
            }
        })
    });
    // =================================================================================================================
})

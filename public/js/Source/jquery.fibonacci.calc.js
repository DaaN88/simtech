/*
* Получение введеного пользователем числа;
* Передача этого числа ajax-запросом в контроллер Entry_point;
* Результат возвращаемый контроллером заносится в поле "Результат" (id = fibonacci_result)
* */
$(document).ready(function() {
    let api_token = JSON.parse(localStorage.getItem('api_token'));

    let fibonacci_number = '';
    $('#fibonacci_number').on('change', function() {
        // cleaning the field for fibonacci number
        $('#fibonacci_result').val()

        fibonacci_number = $('#fibonacci_number').val();
        console.log(fibonacci_number);
    });

    $('#fibonacci_calc').on('click', function(event) {
        event.preventDefault();

        $.ajax({
            url: "/api/fibonacci",
            headers: {
                'Authorization':'Bearer ' + api_token.token,
            },
            method: 'POST',
            data: {
                number: fibonacci_number
            },
            success: function(jqXHR) {
                let response = jqXHR

                if (response.error) {
                    alert(response.error);
                    return;
                }

                $('#fibonacci_result').val(response.result);
            },
            error: function (jqXHR) {
                alert(jqXHR.responseText);
            }
        });
    });
});

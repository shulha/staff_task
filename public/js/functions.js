/**
 * search employee
 */
$('.btn-outline-success').click(function () {
    event.stopPropagation();
    event.preventDefault();

    var input = $('#search').val();
    if( input == '' ) {
        alert('Введите строку поиска');
        return;
    }
    $.ajax({
        method: 'GET',
        url:'api/search',
        data: {input: input},
        dataType: 'json',
        headers: {
            'X-CSRF-Token': $('meta[name="csrf-token"]').attr('content')
        },
        success: function (respond, status, jqXHR) {
            if (respond.success == true && respond.result.length != 0) {
                console.log(respond);
                $("table").css('visibility', 'visible');
                $("table tr:not(:first-child)").remove();
                for (var i = 0; i < respond.result.length; i++) {
                    var num = i + 1;
                    var table_row = '<tr><td>' +
                        num + '</td><td>' +
                        // image + '</td><td>' +
                        respond.result[i].surname + '</td><td>' +
                        respond.result[i].name + '</td><td>' +
                        respond.result[i].patronymic + '</td></tr>';
                    $('table').append(table_row);
                }
            } else {
                setTimeout(function() { alert('Not found !') }, 100);
                $("table tr:not(:first-child)").remove();
                $("table").css('visibility', 'hidden');
            }
        },
        error: function( jqXHR, status, errorThrown ){
            console.log( 'ОШИБКА AJAX запроса: ' + status, jqXHR );
        }
    });
});

/**
 * add multiple attribute to select field 'assign project'
 */
$('.feat').blur(function () {
    var feat_val = $(this).val();
    var feat_name = $(this).siblings().text();
    if (feat_val == 10 && feat_name == "Тайм менеджмент: ") {
        console.log([feat_val, feat_name]);
        $('#project').attr("multiple", "multiple");
    }
});
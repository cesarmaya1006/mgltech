$(document).ready(function() {
    // ===========================================================================
    $('#pais_residencia').on('change', function(event) {
        const id = $(this).val();

        if (id == 'COLOMBIA') {
            $('#departamento_residencia').prop('disabled', false);
            $('#municipio_residencia').prop('disabled', false);
        } else {
            $("#departamento_residencia").val($("#target option:first").val());
            $("#municipio_residencia").val($("#target option:first").val());
            $('#departamento_residencia').prop('disabled', 'disabled');
            $('#municipio_residencia').prop('disabled', 'disabled');
        }
    });
    //==========================================================================
    $('.departamentos').on('change', function(event) {
        const url_t = $(this).attr('data_url');
        const id = $(this).val();

        var data = {
            "id": id,
        };
        $.ajax({
            url: url_t,
            type: 'GET',
            data: data,
            success: function(respuesta) {
                console.log(respuesta);
                respuesta_html = '';
                $.each(respuesta, function(index, item) {
                    respuesta_html += '<option value="' + item['id'] + '">' + item['municipio'] + '</option>';
                });
                $('#municipio_id').html(respuesta_html);
            },
            error: function() {

            }
        });

    });
    //==========================================================================
});
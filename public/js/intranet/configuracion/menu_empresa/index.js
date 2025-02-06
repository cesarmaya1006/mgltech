$('.menu_empresa').on('change', function() {
    var data = {
        menu_id: $(this).data('menuid'),
        empresa_id: $(this).val(),
        _token: $('input[name=_token]').val()
    };
    if ($(this).is(':checked')) {
        data.estado = 1
    } else {
        data.estado = 0
    }
    const data_url = $("#id_permisos_menus_empresas_store").attr("data_url");
    ajaxRequest(data_url, data);
});

function ajaxRequest(url, data) {
    $.ajax({
        url: url,
        type: 'POST',
        data: data,
        success: function(respuesta) {
            Sistema.notificaciones(respuesta.respuesta, 'Sistema', respuesta.tipo);
        }
    });
}

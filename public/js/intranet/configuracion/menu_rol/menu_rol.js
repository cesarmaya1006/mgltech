$('.menu_rol').on('change', function() {
    var data = {
        menu_id: $(this).data('menuid'),
        rol_id: $(this).val(),
        _token: $('input[name=_token]').val()
    };
    if ($(this).is(':checked')) {
        data.estado = 1
    } else {
        data.estado = 0
    }
    ajaxRequest('/dashboard/configuracion_sis/permisos_menus_rol/guardar', data);
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

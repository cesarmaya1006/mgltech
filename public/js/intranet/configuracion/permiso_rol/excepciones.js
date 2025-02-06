$(document).ready(function () {});
function guardar_permiso_usuario(permission_name, usuario_id, value) {
    const data_url = $("#id_guardar_permiso_usuario").attr("data_url");
    const value_c = value;
    const permission_name_c = permission_name;
    const usuario_id_c = usuario_id;

    var data = {
        permission_name: permission_name,
        usuario_id: usuario_id,
        value: value,
        _token: $("input[name=_token]").val(),
    };
    $.ajax({
        url: data_url,
        type: "POST",
        data: data,
        success: function (respuesta) {
            if (value_c == 0) {
                $('#info_box_'+usuario_id_c).removeClass().addClass('info-box text-bg-primary mini_sombra');
                $('#progress_description_'+usuario_id_c).html('Con permiso Asignado');
                $('#info_box_'+usuario_id_c).attr("onclick","guardar_permiso_usuario('"+permission_name_c+"',"+usuario_id_c+",1)");
            } else {
                $('#info_box_'+usuario_id_c).removeClass().addClass('info-box text-bg-secondary mini_sombra');
                $('#progress_description_'+usuario_id_c).html('Sin permiso Asignado');
                $('#info_box_'+usuario_id_c).attr("onclick","guardar_permiso_usuario('" + permission_name_c + "',"+usuario_id_c+",0)");
            }
            Sistema.notificaciones(respuesta.respuesta,"Sistema",respuesta.tipo);
        },
        error: function () {},
    });
}

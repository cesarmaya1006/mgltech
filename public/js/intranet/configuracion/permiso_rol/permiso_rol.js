$(document).ready(function () {});
function guardar_permiso_rol(permission_id, role_id, value) {
    const data_url = $("#id_guardar_permiso_rol").attr("data_url");
    const value_c = value;
    const permission_id_c = permission_id;
    const role_id_c = role_id;

    var data = {
        permission_id: permission_id,
        role_id: role_id,
        value: value,
        _token: $("input[name=_token]").val(),
    };
    $.ajax({
        url: data_url,
        type: "POST",
        data: data,
        success: function (respuesta) {
            if (value_c == 0) {
                $('#check_' + permission_id + "_" + role_id).attr("onclick","guardar_permiso_rol("+permission_id_c+","+role_id_c+",1)");
                $("#label_" + permission_id + "_" + role_id).html('Si');
            } else {
                $('#check_' + permission_id + "_" + role_id).attr("onclick","guardar_permiso_rol("+permission_id_c+","+role_id_c+",0)");
                $("#label_" + permission_id + "_" + role_id).html('No');
            }
            Sistema.notificaciones(
                respuesta.respuesta,
                "Sistema",
                respuesta.tipo
            );
        },
        error: function () {},
    });
}

$(document).ready(function () {
    //--------------------------------------------------------------------------
    $("#emp_grupo_id").on("change", function () {
        const data_url = $(this).attr("data_url");
        const id = $(this).val();
        var data = {
            id: id,
        };
        $.ajax({
            url: data_url,
            type: "GET",
            data: data,
            success: function (respuesta) {
                var respuesta_html = "";
                if (respuesta.empresas.length > 0) {
                    respuesta_html += '<option value="">Elija empresa</option>';
                    $.each(respuesta.empresas, function (index, item) {
                        respuesta_html +=
                            '<option value="' +
                            item.id +
                            '">' +
                            item.empresa +
                            "</option>";
                    });
                    $("#empresa_id").html(respuesta_html);
                } else {
                    $("#empresa_id").html(respuesta_html);
                }
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
    $("#empresa_id").on("change", function () {
        const data_url = $(this).attr("data_url");
        const id = $(this).val();
        const tipoSoporte = $("#datosUpLaod").attr("tipoSoporte");
        const titulo = $("#datosUpLaod").attr("titulo");
        const aviso = $("#datosUpLaod").attr("aviso");
        var data = {
            id: id,
        };
        $.ajax({
            url: data_url,
            type: "GET",
            data: data,
            success: function (respuesta) {
                cargarTabla(respuesta.empleados)
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
});

function cargarTabla(empleados){
    var respuesta_html = '';
    const tbody = $('#datosUpLaod').attr("tbody");
    const tabla = $('#datosUpLaod').attr("tabla");
    $("#" + tbody).html(respuesta_html);
    $("#" + tabla).DataTable().destroy();
    var respuesta_html = '';
    $.each(empleados, function (index,  empleado) {
        respuesta_html+='<tr>';
        respuesta_html+='    <td style="white-space:nowrap;">'+empleado.cargo.area.area+'</td>';
        respuesta_html+='    <td style="white-space:nowrap;">'+empleado.cargo.cargo+'</td>';
        respuesta_html+='    <td style="white-space:nowrap;">'+empleado.nombres + ' ' + empleado.apellidos +'</td>';
        respuesta_html+='    <td style="white-space:nowrap;" class="text-center">';
        respuesta_html+='    <button type="button" class="btn-accion-tabla bg-gradient-success tooltipsC pt-1 pb-1 pl-3 pr-3 rounded-1" onclick="getSoporte('+ empleado.id +')"><i class="fas fa-plus-circle" aria-hidden="true"></i></button>';
        respuesta_html+='    </td>';
        respuesta_html+='</tr>';
    });
    $("#" + tabla).DataTable().destroy();
    $("#" + tbody).html(respuesta_html);
    asignarDataTableAjax('#tablaSoportes',"listado de empleados / permisos");

}

function getSoporte(empleado_id){
    const data_url = $('#datosUpLaod').attr("data_url");
    var data = {
        id: empleado_id,
    };
    $.ajax({
        url: data_url,
        type: "GET",
        data: data,
        success: function (respuesta) {
            console.log(respuesta);
        },
        error: function () {},
    });

}

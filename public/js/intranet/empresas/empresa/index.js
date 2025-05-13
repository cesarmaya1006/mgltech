$(document).ready(function () {

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
                console.log(respuesta);
                llenar_tabla(respuesta.empresas);
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
});
function llenar_tabla(data) {
    var respuesta_thead_html = "";
    var respuesta_tabla_html = "";
    // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
    const permiso_empresa_edit = $("#permiso_empresa_edit").val();
    const permiso_empresa_activar = $("#permiso_empresa_activar").val();
    // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
    var empresa_edit_ini = $("#datos_tabla").attr("data_url_empresa_edit");
    empresa_edit_ini = empresa_edit_ini.substring(0,empresa_edit_ini.length - 1);
    const empresa_edit_fin = empresa_edit_ini;
    // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
    var empresa_activar_ini = $("#datos_tabla").attr("data_url_empresa_activar");
    empresa_activar_ini = empresa_activar_ini.substring(0,empresa_activar_ini.length - 1);
    const empresa_activar_fin = empresa_activar_ini;
    // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
    respuesta_tabla_html = "";
    $("#tbody_empresa").html(respuesta_tabla_html);
    //vaciarTabla('#tablaEmpresas','#tbody_empresa');
    // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
    $.each(data, function (index, empresa) {
        respuesta_tabla_html += "<tr>";
        respuesta_tabla_html += '<td class="text-center">' + empresa.id + "</td>";
        respuesta_tabla_html += "<td>" + empresa.identificacion +"</td>";
        respuesta_tabla_html += "<td>" + empresa.empresa + "</td>";
        respuesta_tabla_html += "<td>" + empresa.email + "</td>";
        respuesta_tabla_html += "<td>" + empresa.telefono + "</td>";
        respuesta_tabla_html += "<td>" + empresa.direccion + "</td>";
        respuesta_tabla_html += "<td>" + empresa.contacto + "</td>";
        respuesta_tabla_html += "<td>" + empresa.cargo + "</td>";
        if (empresa.estado == 1) {
            estado_bg = "success";
            estado = "Activo";
        } else {
            estado_bg = "gray";
            estado = "Inactivo";
        }
        respuesta_tabla_html += '<td class="text-center"><span class="btn-xs pl-3 pr-3 text-center bg-' +estado_bg +' rounded">' +estado +"</span></td>";
        respuesta_tabla_html += '<td class="d-flex justify-content-evenly align-cargos-center">';
        if (permiso_empresa_edit == 1) {
            respuesta_tabla_html += '<a href="' +empresa_edit_fin +empresa.id +'" class="btn-accion-tabla tooltipsC"';
            respuesta_tabla_html += 'title="Editar este registro">';
            respuesta_tabla_html += '<i class="fas fa-pen-square"></i>';
            respuesta_tabla_html += "</a>";
        } else {
            respuesta_tabla_html += '<span class="text-danger">---</span>';
        }
        respuesta_tabla_html += "</td>";
        respuesta_tabla_html += "</tr>";
    });
    // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
   $("#tbody_empresas").html(respuesta_tabla_html);
    asignarDataTableAjax();
}

$(document).ready(function () {
    // - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * -
    $("#empresa_id").on("change", function() {
        respuesta_html = '';
        $("#tbody_areas").html(respuesta_html);


        const data_url = $(this).attr("data_url");
        const id = $(this).val();
        var data = {
            id: id,
        };
        const data_url_data = data_url + '?id=' + id;

        if ($(this).val() != '') {

            var grupo_empresas_edit_ini = $('#areas_edit').attr("data_url");
            grupo_empresas_edit_ini = grupo_empresas_edit_ini.substring(0, grupo_empresas_edit_ini.length - 1);
            const areas_edit_fin = grupo_empresas_edit_ini;

            var grupo_empresas_destroy_ini = $('#areas_destroy').attr("data_url");
            grupo_empresas_destroy_ini = grupo_empresas_destroy_ini.substring(0,grupo_empresas_destroy_ini.length - 1);
            const areas_destroy_fin = grupo_empresas_destroy_ini;

            var id_areas_getDependencias_ini = $('#id_areas_getDependencias').attr("data_url");
            id_areas_getDependencias_ini = id_areas_getDependencias_ini.substring(0,id_areas_getDependencias_ini.length - 1);
            const id_areas_getDependencias_fin = id_areas_getDependencias_ini;

            $.ajax({
                url: data_url,
                type: "GET",
                data: data,
                success: function(respuesta) {

                    respuesta_html = '';
                    if (respuesta.areasPadre.length > 0) {
                        respuesta_html = '';
                        $.each(respuesta.areasPadre, function(index, item) {

                            respuesta_html += '<tr>';
                            respuesta_html += '<td class="text-center">' + item.id + '</td>';
                            respuesta_html += '<td class="text-center">' + item.area + '</td>';
                            respuesta_html += '<td class="text-center">';
                            if (item.area_id) {
                                respuesta_html += item.area_sup.area;
                            } else {
                                respuesta_html += '---';
                            }

                            respuesta_html += '</td>';
                            respuesta_html += '<td class="text-center">';

                            if (item.areas.length > 0) {
                                respuesta_html +='<button type="submit" class="btn-accion-tabla tooltipsC mostrar_dependencias text-info"';
                                respuesta_html += 'onClick="mostrarModal(\'' + id_areas_getDependencias_fin + item.id + '\')"';
                                respuesta_html += 'title="Mostrar Dependencias" data_id ="' + item.id + '"';
                                respuesta_html += 'data_url = "' + id_areas_getDependencias_fin + item.id + '">';
                                respuesta_html += item.areas.length;
                                respuesta_html += '</button>';
                            } else {
                                respuesta_html += '<h6 class="text-danger">---</h6>';
                            }

                            respuesta_html += '</td>';
                            respuesta_html += '<td class="d-flex justify-content-evenly align-items-center">';
                            respuesta_html += '<a href="' + areas_edit_fin + item.id + '" class="btn-accion-tabla tooltipsC"';
                            respuesta_html += 'title="Editar este registro">';
                            respuesta_html += '<i class="fas fa-pen-square"></i>';
                            respuesta_html += '</a>';
                            respuesta_html += '<form action="' + areas_destroy_fin + item.id + '" class="d-inline form-eliminar" method="POST">';
                            respuesta_html += '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" autocomplete="off">';
                            respuesta_html += '<input type="hidden" name="_method" value="delete">';
                            respuesta_html += '<button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro">';
                            respuesta_html += '<i class="fa fa-fw fa-trash text-danger"></i>';
                            respuesta_html += '</button>';
                            respuesta_html += '</form>';
                            respuesta_html += '</td>';
                            respuesta_html += '</tr>';
                        });

                        $("#tbody_areas").html(respuesta_html);
                        asignarDataTableAjax();
                    }
                },
                error: function() {},
            });

        }

    });
    // - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * -
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
                if (respuesta.empresas.length > 0) {
                    var respuesta_html = "";
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
                    $("#caja_empresas").removeClass("d-none");
                }
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------

});

function mostrarModal(data_url_) {
    const myModal = new bootstrap.Modal(
        document.getElementById("exampleModal")
    );
    const data_url = data_url_;
    $.ajax({
        url: data_url,
        type: "GET",
        success: function (respuesta) {
            var respuesta_html = "";
            respuesta_html += '<ol class="list-group list-group-numbered">';
            $.each(respuesta.dependencias, function (index, item) {
                respuesta_html +=
                    '<li class="list-group-item">' + item.area + "</li>";
            });
            respuesta_html += "</ol>";
            $(".modal-body").html(respuesta_html);
        },
        error: function () {},
    });
    myModal.show();
}

function cerrarModalF(){
    const myModal = new bootstrap.Modal(
        document.getElementById("exampleModal")
    );
    myModal.toggle();

}

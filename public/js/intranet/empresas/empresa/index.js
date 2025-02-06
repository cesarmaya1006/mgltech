$(document).ready(function() {
    // - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * -
    $("#emp_grupo_id").on("change", function() {
        vaciarTabla('tablaEmpresas','tbody_empresas');
        const data_url = $(this).attr("data_url");
        const id = $(this).val();
        const data_token = $(this).attr('data_token');
        var data = {
            id: id,
        };
        const data_url_data = data_url + '?id=' + id;

        if ($(this).val()) {

            var grupo_empresas_edit_ini = $('#grupo_empresas_edit').attr("data_url");
            grupo_empresas_edit_ini = grupo_empresas_edit_ini.substring(0, grupo_empresas_edit_ini .length - 1);
            const grupo_empresas_edit_fin = grupo_empresas_edit_ini;

            var grupo_empresas_destroy_ini = $('#grupo_empresas_destroy').attr("data_url");
            grupo_empresas_destroy_ini = grupo_empresas_destroy_ini.substring(0, grupo_empresas_destroy_ini.length - 1);
            const grupo_empresas_destroy_fin = grupo_empresas_destroy_ini;

            $.ajax({
                url: data_url,
                type: "GET",
                data: data,
                success: function(respuesta) {
                    respuesta_html = '';
                    if (respuesta.empresas.length > 0) {
                        vaciarTabla('tablaEmpresas','tbody_empresas');
                        respuesta_html = '';
                        $.each(respuesta.empresas, function(index, item) {
                            respuesta_html += '<tr>';
                            respuesta_html += '<td class="text-center">' + item.id + '</td>';
                            respuesta_html += '<td>' + item.identificacion + '</td>';
                            respuesta_html += '<td>' + item.empresa + '</td>';
                            respuesta_html += '<td>' + item.email + '</td>';
                            respuesta_html += '<td>' + item.telefono + '</td>';
                            respuesta_html += '<td>' + item.direccion + '</td>';
                            respuesta_html += '<td>' + item.contacto + '</td>';
                            respuesta_html += '<td>' + item.cargo + '</td>';
                            respuesta_html += '<td>';
                            respuesta_html += '<span class="btn-info btn-xs pl-3 pr-3 d-flex flex-row align-items-center bg-';
                            if (item.estado == 1) {
                                respuesta_html += 'success';
                            } else {
                                respuesta_html += 'gray';
                            }
                            respuesta_html += ' rounded">';
                            if (item.estado == 1) {
                                respuesta_html += 'Activo</span>';
                            } else {
                                respuesta_html += 'Inactivo</span>';
                            }
                            respuesta_html += '</td>';
                            respuesta_html += '<td class="d-flex justify-content-evenly align-items-center">';
                            respuesta_html += '<a href="' + grupo_empresas_edit_fin + item.id + '" class="btn-accion-tabla tooltipsC" title="Editar este registro">';
                            respuesta_html += '<i class="fas fa-pen-square"></i>';
                            respuesta_html += '</a>';
                            respuesta_html += '<form action="' + grupo_empresas_destroy_fin + item.id + '" class="d-inline form-eliminar" method="POST">';
                            respuesta_html += '<input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">';
                            respuesta_html += '<input type="hidden" name="_method" value="delete">';
                            respuesta_html += '<button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro">';
                            respuesta_html += '<i class="fa fa-fw fa-trash text-danger"></i>';
                            respuesta_html += '</button>';
                            respuesta_html += '</form>';
                            respuesta_html += '</td>';
                            respuesta_html += '</tr>';
                        });
                        $("#tbody_empresas").html(respuesta_html);
                        asignarDataTableAjax('tablaEmpresas','Tabla Empresas');
                    }
                },
                error: function() {},
            });

        }

    });
    // - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * -
});

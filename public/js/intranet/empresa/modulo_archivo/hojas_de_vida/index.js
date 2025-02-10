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
                        respuesta_html +='<option value="' +item.id +'">' +item.empresa +"</option>";
                    });
                    $("#empresa_id").html(respuesta_html);
                    $("#caja_empresas").removeClass("d-none");
                    $("#empresa_id").prop('required',true);
                    $('#label_empresa_id').addClass('requerido');

                }else{
                    $("#empresa_id").html(respuesta_html);
                    $("#caja_empresas").addClass("d-none");
                    $("#empresa_id").prop('required',false);
                    $('#label_empresa_id').removeClass('requerido');
                }
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
    $("#empresa_id").on("change", function () {
        const data_url = $(this).attr("data_url");
        const id = $(this).val();
        var data = {
            id: id,
        };
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var hojas_de_vida_editar_ini = $('#hojas_de_vida_editar').attr("data_url");
        hojas_de_vida_editar_ini = hojas_de_vida_editar_ini.substring(0,hojas_de_vida_editar_ini.length - 1);
        const hojas_de_vida_editar_fin = hojas_de_vida_editar_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var hojas_de_vida_detalles_ini = $('#hojas_de_vida_detalles').attr("data_url");
        hojas_de_vida_detalles_ini = hojas_de_vida_detalles_ini.substring(0,hojas_de_vida_detalles_ini.length - 1);
        const hojas_de_vida_detalles_fin = hojas_de_vida_detalles_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        $.ajax({
            url: data_url,
            type: "GET",
            data: data,
            success: function (respuesta) {
                var respuesta_html = "";
                console.log(respuesta.empleados);
                if (respuesta.empleados.length > 0) {
                    $.each(respuesta.empleados, function (index, empleado) {
                        respuesta_html += '';
                        respuesta_html += '<tr>';
                        respuesta_html += 'td>';
                        respuesta_html += '<div class="card card-widget widget-user shadow">';
                        respuesta_html += '<div class="widget-user-header bg-info">';
                        respuesta_html += '<h6 class="widget-user-username">';
                        respuesta_html +=  empleado.nombres + ' ' + empleado.apellidos;
                        respuesta_html += '</h6>';
                        respuesta_html += '<p class="widget-user-desc">' + empleado.cargo.cargo + '</p>';
                        respuesta_html += '</div>';
                        respuesta_html += '<div class="widget-user-image">';
                        respuesta_html += '<img class="img-circle elevation-4"';
                        respuesta_html += 'src="'+ $('#folderFotos').val() + empleado.foto +'"';
                        respuesta_html += 'alt="' + empleado.nombres + ' ' + empleado.apellidos +'">';
                        respuesta_html += '</div>';
                        respuesta_html += '<div class="card-footer">';
                        respuesta_html += '<div class="row d-flex justify-content-md-center">';
                        respuesta_html += '<div class="col-sm-2 border-right">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Identificación</h5>';
                        respuesta_html += '<span';
                        respuesta_html += 'class="description-text">' + empleado.identificacion + '</span>';
                        respuesta_html += '</div>';
                        respuesta_html += '</div>';
                        respuesta_html += '<div class="col-sm-2 border-right">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Teléfono</h5>';
                        respuesta_html += '<span';
                        respuesta_html += 'class="description-text">' + empleado.telefono + '</span>';
                        respuesta_html += '</div>';
                        respuesta_html += '</div>';
                        respuesta_html += '<div class="col-sm-3 border-right">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Email</h5>';
                        respuesta_html += '<span';
                        respuesta_html += 'class="description-text text-lowercase text-nowrap">' + empleado.usuario.email + '</span>';
                        respuesta_html += '</div>';
                        respuesta_html += '</div>';
                        respuesta_html += '<div class="col-sm-2 border-right">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Vinculación</h5>';
                        respuesta_html += '<span';
                        respuesta_html += 'class="description-text text-lowercase text-nowrap">'+ empleado.vinculacion + '</span>';
                        respuesta_html += '</div>';
                        respuesta_html += '</div>';
                        respuesta_html += '<div class="col-sm-3">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Opciones</h5>';
                        respuesta_html += '<span';
                        respuesta_html += 'class="description-text d-flex justify-content-md-between mt-2">';
                        respuesta_html += '<a href="' + hojas_de_vida_editar_fin + empleado.id + '"';
                        respuesta_html += 'class="btn btn-primary pl-1 pr-1 btn-xs btn-sombra"><i';
                        respuesta_html += 'class="fa fa-edit mr-1" aria-hidden="true"></i>';
                        respuesta_html += 'Editar</a>';
                        respuesta_html += '<a href="' + hojas_de_vida_detalles_fin + empleado.id + '"';
                        respuesta_html += 'class="btn btn-info pl-1 pr-1 btn-xs btn-sombra"><i';
                        respuesta_html += 'class="fa fa-eye mr-1" aria-hidden="true"></i>';
                        respuesta_html += 'Detalles</a>';
                        respuesta_html += '</span>';
                        respuesta_html += '</div>';
                        respuesta_html += '</div>';
                        respuesta_html += '</div>';
                        respuesta_html += '</div>';
                        respuesta_html += '</div>';
                        respuesta_html += '/td>';
                        respuesta_html += '</tr>';
                    });
                    $("#tbody_hojas_de_vida").html(respuesta_html);
                }
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
});

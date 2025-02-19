$(document).ready(function () {
    //--------------------------------------------------------------------------
    $("#buscartarjetas").on("keyup", function () {
        const data_url = $(this).attr("data_url");
        const busqueda = $(this).val();
        const empresa_id = $('#empresa_id').val();
        var data = {
            busqueda: busqueda,
            empresa_id: empresa_id,
        };
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var hojas_de_vida_editar_ini = $("#hojas_de_vida_editar").attr("data_url");
        hojas_de_vida_editar_ini = hojas_de_vida_editar_ini.substring(0,hojas_de_vida_editar_ini.length - 1);
        const hojas_de_vida_editar_fin = hojas_de_vida_editar_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var hojas_de_vida_detalles_ini = $("#hojas_de_vida_detalles").attr("data_url");
        hojas_de_vida_detalles_ini = hojas_de_vida_detalles_ini.substring(0,hojas_de_vida_detalles_ini.length - 1);
        const hojas_de_vida_detalles_fin = hojas_de_vida_detalles_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        $.ajax({
            url: data_url,
            type: "GET",
            data: data,
            success: function (respuesta) {
                var respuestaNew_html = "";
                if (respuesta.empleados.length > 0) {
                    $.each(respuesta.empleados, function (index, empleado) {
                        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        respuestaNew_html +='<div class="col-12 col-md-3 p-2">';
                            respuestaNew_html +='<div class="card card-widget widget-user">';
                                respuestaNew_html +='<div class="widget-user-header bg-primary">';
                                    respuestaNew_html +='<h3 class="widget-user-username">' + empleado.nombres + ' ' + empleado.apellidos + '</h3>';
                                    respuestaNew_html +='<h5 class="widget-user-desc">' + empleado.cargo.cargo +'</h5>';
                                respuestaNew_html +='</div>';
                                respuestaNew_html +='<div class="widget-user-image">';
                                    respuestaNew_html +='<img class="img-circle elevation-2" src="' + $("#folderFotos").val() + "/" + empleado.foto + '">';
                                respuestaNew_html +='</div>';
                                respuestaNew_html +='<div class="card-footer">';
                                    respuestaNew_html +='<div class="row">';
                                        respuestaNew_html +='<div class="col-12 border-right">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Identificación</h5>';
                                                respuestaNew_html +='<span class="description-text">' + empleado.identificacion + '</span>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                        respuestaNew_html +='<div class="col-12 border-right">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Teléfono</h5>';
                                                respuestaNew_html +='<span class="description-text">' + empleado.telefono + '</span>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                        respuestaNew_html +='<div class="col-12">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Correo Electrónico</h5>';
                                                respuestaNew_html +='<span class="description-text">' + empleado.usuario.email + '</span>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                        respuestaNew_html +='<div class="col-12">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Vinculación</h5>';
                                                respuestaNew_html +='<span class="description-text">' + empleado.vinculacion + '</span>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                        respuestaNew_html +='<div class="col-12">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Opciones</h5>';
                                                respuestaNew_html +='<div class="d-grid gap-2 mt-3">';
                                                    respuestaNew_html +='<a href="' + hojas_de_vida_editar_fin + empleado.id + '" class="btn btn-outline-primary pl-1 pr-1 btn-xs btn-sombra mb-2">';
                                                        respuestaNew_html +='<i class="fa fa-edit mr-1" aria-hidden="true"></i>Editar';
                                                    respuestaNew_html +='</a>';
                                                    respuestaNew_html +='<a href="' +  hojas_de_vida_detalles_fin + empleado.id + '" class="btn btn-outline-primary pl-1 pr-1 btn-xs btn-sombra">';
                                                        respuestaNew_html +='<i class="fa fa-eye mr-1" aria-hidden="true"></i>Detalles';
                                                    respuestaNew_html +='</a>';
                                                respuestaNew_html +='</div>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                    respuestaNew_html +='</div>';
                                respuestaNew_html +='</div>';
                            respuestaNew_html +='</div>';
                        respuestaNew_html +='</div>';
                        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                    });
                } else {

                }
                $("#newCajaHV").html(respuestaNew_html);
            },
            error: function () {},
        });
    });
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
                    $("#caja_empresas").removeClass("d-none");
                    $("#empresa_id").prop("required", true);
                    $("#label_empresa_id").addClass("requerido");
                } else {
                    $("#empresa_id").html(respuesta_html);
                    $("#caja_empresas").addClass("d-none");
                    $("#empresa_id").prop("required", false);
                    $("#label_empresa_id").removeClass("requerido");
                }
                $('#cajaBusqueda').addClass('d-none');
                $('#newCajaHV').addClass('d-none');
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
        var hojas_de_vida_editar_ini = $("#hojas_de_vida_editar").attr("data_url");
        hojas_de_vida_editar_ini = hojas_de_vida_editar_ini.substring(0,hojas_de_vida_editar_ini.length - 1);
        const hojas_de_vida_editar_fin = hojas_de_vida_editar_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var hojas_de_vida_detalles_ini = $("#hojas_de_vida_detalles").attr("data_url");
        hojas_de_vida_detalles_ini = hojas_de_vida_detalles_ini.substring(0,hojas_de_vida_detalles_ini.length - 1);
        const hojas_de_vida_detalles_fin = hojas_de_vida_detalles_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        $.ajax({
            url: data_url,
            type: "GET",
            data: data,
            success: function (respuesta) {
                var respuesta_html = "";
                var respuestaNew_html = "";
                $("#tbody_hojas_de_vida").html(respuesta_html);
                if (respuesta.empleados.length > 0) {
                    $.each(respuesta.empleados, function (index, empleado) {
                        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        respuestaNew_html +='<div class="col-12 col-md-3 p-2">';
                            respuestaNew_html +='<div class="card card-widget widget-user">';
                                respuestaNew_html +='<div class="widget-user-header bg-primary">';
                                    respuestaNew_html +='<h3 class="widget-user-username">' + empleado.nombres + ' ' + empleado.apellidos + '</h3>';
                                    respuestaNew_html +='<h5 class="widget-user-desc">' + empleado.cargo.cargo +'</h5>';
                                respuestaNew_html +='</div>';
                                respuestaNew_html +='<div class="widget-user-image">';
                                    respuestaNew_html +='<img class="img-circle elevation-2" src="' + $("#folderFotos").val() + "/" + empleado.foto + '">';
                                respuestaNew_html +='</div>';
                                respuestaNew_html +='<div class="card-footer">';
                                    respuestaNew_html +='<div class="row mt-3">';
                                        respuestaNew_html +='<div class="col-12">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Identificación</h5>';
                                                respuestaNew_html +='<span class="description-text">' + empleado.identificacion + '</span>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                        respuestaNew_html +='<div class="col-12">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Teléfono</h5>';
                                                respuestaNew_html +='<span class="description-text">' + empleado.telefono + '</span>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                        respuestaNew_html +='<div class="col-12">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Correo Electrónico</h5>';
                                                respuestaNew_html +='<span class="description-text">' + empleado.usuario.email + '</span>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                        respuestaNew_html +='<div class="col-12">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Vinculación</h5>';
                                                respuestaNew_html +='<span class="description-text">' + empleado.vinculacion + '</span>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                        respuestaNew_html +='<div class="col-12">';
                                            respuestaNew_html +='<div class="description-block">';
                                                respuestaNew_html +='<h5 class="description-header">Opciones</h5>';
                                                respuestaNew_html +='<div class="d-grid gap-2 mt-3">';
                                                    respuestaNew_html +='<a href="' + hojas_de_vida_editar_fin + empleado.id + '" class="btn btn-outline-primary pl-1 pr-1 btn-xs btn-sombra mb-2">';
                                                        respuestaNew_html +='<i class="fa fa-edit mr-1" aria-hidden="true"></i>Editar';
                                                    respuestaNew_html +='</a>';
                                                    respuestaNew_html +='<a href="' +  hojas_de_vida_detalles_fin + empleado.id + '" class="btn btn-outline-primary pl-1 pr-1 btn-xs btn-sombra">';
                                                        respuestaNew_html +='<i class="fa fa-eye mr-1" aria-hidden="true"></i>Detalles';
                                                    respuestaNew_html +='</a>';
                                                respuestaNew_html +='</div>';
                                            respuestaNew_html +='</div>';
                                        respuestaNew_html +='</div>';
                                    respuestaNew_html +='</div>';
                                respuestaNew_html +='</div>';
                            respuestaNew_html +='</div>';
                        respuestaNew_html +='</div>';
                        //++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++
                        /*respuesta_html += "";
                        respuesta_html += "<tr>";
                        respuesta_html += "<td>";
                        respuesta_html += '<div class="card card-widget widget-user shadow">';
                        respuesta_html += '<div class="widget-user-header bg-info">';
                        respuesta_html += '<h6 class="widget-user-username">';
                        respuesta_html += empleado.nombres + " " + empleado.apellidos;
                        respuesta_html += "</h6>";
                        respuesta_html += '<p class="widget-user-desc">' + empleado.cargo.cargo + "</p>";
                        respuesta_html += "</div>";
                        respuesta_html += '<div class="widget-user-image">';
                        respuesta_html += '<img class="img-circle elevation-4" src="' + $("#folderFotos").val() + "/" + empleado.foto + '" alt="' + empleado.nombres + " " + empleado.apellidos + '">';
                        respuesta_html += "</div>";
                        respuesta_html += '<div class="card-footer">';
                        respuesta_html += '<div class="row d-flex justify-content-md-center">';
                        respuesta_html += '<div class="col-sm-2 border-right">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Identificación</h5>';
                        respuesta_html += '<span class="description-text">' + empleado.identificacion + '</span>';
                        respuesta_html += "</div>";
                        respuesta_html += "</div>";
                        respuesta_html += '<div class="col-sm-2 border-right">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Teléfono</h5>';
                        respuesta_html += '<span class="description-text">' + empleado.telefono + '</span>';
                        respuesta_html += "</div>";
                        respuesta_html += "</div>";
                        respuesta_html += '<div class="col-sm-3 border-right">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Email</h5>';
                        respuesta_html += '<span class="description-text text-lowercase text-nowrap">' + empleado.usuario.email + '</span>';
                        respuesta_html += "</div>";
                        respuesta_html += "</div>";
                        respuesta_html += '<div class="col-sm-2 border-right">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Vinculación</h5>';
                        respuesta_html += '<span class="description-text text-lowercase text-nowrap">' + empleado.vinculacion + '</span>';
                        respuesta_html += "</div>";
                        respuesta_html += "</div>";
                        respuesta_html += '<div class="col-sm-3">';
                        respuesta_html += '<div class="description-block">';
                        respuesta_html += '<h5 class="description-header">Opciones</h5>';
                        respuesta_html += '<span class="description-text d-flex justify-content-md-between mt-2">';
                        respuesta_html += '<a href="' + hojas_de_vida_editar_fin + empleado.id + '" ';
                        respuesta_html += 'class="btn btn-primary pl-1 pr-1 btn-xs_hv btn-sombra mr-3"><i class="fa fa-edit mr-1" aria-hidden="true"></i>';
                        respuesta_html += "Editar</a>";
                        respuesta_html += '<a href="' +  hojas_de_vida_detalles_fin + empleado.id + '" ';
                        respuesta_html += 'class="btn btn-primary pl-1 pr-1 btn-xs_hv btn-sombra"><i class="fa fa-eye mr-1" aria-hidden="true"></i>';
                        respuesta_html += "Detalles</a>";
                        respuesta_html += '</span>';
                        respuesta_html += "</div>";
                        respuesta_html += "</div>";
                        respuesta_html += "</div>";
                        respuesta_html += "</div>";
                        respuesta_html += "</div>";
                        respuesta_html += "</td>";
                        respuesta_html += "</tr>";*/
                    });
                    $('#cajaBusqueda').removeClass('d-none');
                    $('#newCajaHV').removeClass('d-none');
                }else{
                    $('#cajaBusqueda').addClass('d-none');
                    $('#newCajaHV').addClass('d-none');
                }
                //$("#tabla_empleados").DataTable().destroy();
                //$("#tbody_hojas_de_vida").html(respuesta_html);
                $("#newCajaHV").html(respuestaNew_html);
                //asignarDataTableAjax("#tabla_empleados", "Tabla Empleados");
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
});

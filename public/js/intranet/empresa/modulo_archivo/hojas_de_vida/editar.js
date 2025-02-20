$(document).ready(function () {
    const cargoModal = new bootstrap.Modal(document.getElementById('cargoModal'));
    const rutaSoportes  = $('#rutaSoportes').val() + '/';
    //--------------------------------------------------------------------------
    $("#departamento").on("change", function () {
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
                if (respuesta.municipios.length > 0) {
                    respuesta_html +=
                        '<option value="">Elija un Municipio</option>';
                    $.each(respuesta.municipios, function (index, item) {
                        respuesta_html += '<option value="' + item.municipio + '">' + item.municipio + "</option>";
                    });
                }
                $("#municipio").html(respuesta_html);
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
    $("#departamentoInformal").on("change", function () {
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
                if (respuesta.municipios.length > 0) {
                    respuesta_html +=
                        '<option value="">Elija un Municipio</option>';
                    $.each(respuesta.municipios, function (index, item) {
                        respuesta_html += '<option value="' + item.municipio + '">' + item.municipio + "</option>";
                    });
                }
                $("#municipioInformal").html(respuesta_html);
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
    $("#area_id").on("change", function () {
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
                if (respuesta.cargos.length > 0) {
                    respuesta_html +=
                        '<option value="">Elija un cargo</option>';
                    $.each(respuesta.cargos, function (index, item) {
                        respuesta_html += '<option value="' + item.id + '">' + item.cargo + "</option>";
                    });
                }
                $("#cargo_id").html(respuesta_html);
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
    $("#formCargo").submit(function(e) {
        e.preventDefault();
        const form = $(this);
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: form.serialize(),
            success: function (respuesta) {
                if (respuesta.mensaje == "ok") {
                    $('#spanIdArea').text(respuesta.area)
                    $('#spanIdCargo').text(respuesta.cargo)
                    Sistema.notificaciones(
                        "Se asigno el cargo correctamente, los permisos se restableceran despues de reiniciar sesión",
                        "Sistema",
                        "success"
                    );
                } else {
                    Sistema.notificaciones(
                        "No se pudo hacer el cambio de cargo, solicite asistencia técnica",
                        "Sistema",
                        "error"
                    );
                }
            },
            error: function () {},
        });
        $("#cargoModal").modal('hide');

      });
    //--------------------------------------------------------------------------
    $('#formDatosPersonales').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        var formData = new FormData(this);
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.mensaje == "ok") {
                    Sistema.notificaciones(
                        "Se asigno el cargo correctamente, los permisos se restableceran despues de reiniciar sesión",
                        "Sistema",
                        "success"
                    );
                } else {
                    Sistema.notificaciones(
                        "No se pudo hacer el cambio de cargo, solicite asistencia técnica",
                        "Sistema",
                        "error"
                    );
                }
            },
            error: function () {},
        });


      });
    //--------------------------------------------------------------------------
    $('#tipo_id').on("change", function () {
        const valor = $(this).val();
        if (valor==1) {
            $('#caja_tarjeta_prof').addClass('d-none');
            $('#tarjeta_prof').prop('required', false);
            $('#caja_cant_horas').addClass('d-none');
            $('#cant_horas').prop('required', false);
        }else if(valor==2){
            $('#caja_tarjeta_prof').removeClass('d-none');
            $('#tarjeta_prof').prop('required', true);
            $('#caja_cant_horas').addClass('d-none');
            $('#cant_horas').prop('required', false);
        }else{
            $('#caja_tarjeta_prof').addClass('d-none');
            $('#tarjeta_prof').prop('required', false);
            $('#caja_cant_horas').removeClass('d-none');
            $('#cant_horas').prop('required', true);
        }
    });
    //--------------------------------------------------------------------------
    $('#formEducacionEmpleado').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        var formData = new FormData(this);
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                if (respuesta.mensaje == "ok") {
                    var respuesta_html = "";
                    if (respuesta.educacion.tipo_id == '1') {
                        respuesta_html+='<tr>';
                        respuesta_html+='    <td>' + respuesta.educacion.estado + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.ultimo_cursado + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.titulo + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.establecimiento + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.fecha_termino + '</td>';
                        respuesta_html+='    <td><a href="'+ rutaSoportes + respuesta.educacion.soporte +'" target="_blank" rel="noopener noreferrer">'+ respuesta.educacion.soporte +'</a></td>';
                        respuesta_html+='    <td></td>';
                        respuesta_html+='</tr>';
                        $('#tbodyEducacionBasica').append(respuesta_html);
                    }else if(respuesta.educacion.tipo_id == '2'){
                        respuesta_html+='<tr>';
                        respuesta_html+='    <td>' + respuesta.educacion.estado + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.titulo + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.establecimiento + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.fecha_termino + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.tarjeta_prof + '</td>';
                        respuesta_html+='    <td><a href="'+ rutaSoportes + respuesta.educacion.soporte +'" target="_blank" rel="noopener noreferrer">'+ respuesta.educacion.soporte +'</a></td>';
                        respuesta_html+='    <td></td>';
                        respuesta_html+='</tr>';
                        $('#tbodyEducacionSuperior').append(respuesta_html);
                    }else{
                        respuesta_html+='<tr>';
                        respuesta_html+='    <td>' + respuesta.educacion.estado + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.titulo + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.establecimiento + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.cant_horas + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.fecha_inicio + '</td>';
                        respuesta_html+='    <td>' + respuesta.educacion.fecha_termino + '</td>';
                        respuesta_html+='    <td><a href="'+ rutaSoportes + respuesta.educacion.soporte +'" target="_blank" rel="noopener noreferrer">'+ respuesta.educacion.soporte +'</a></td>';
                        respuesta_html+='    <td></td>';
                        respuesta_html+='</tr>';
                        $('#tbodyEducacionOtra').append(respuesta_html);
                    }
                    $("#educacionModal").modal('hide');
                    Sistema.notificaciones(
                        "Se asigno el cargo correctamente, los permisos se restableceran despues de reiniciar sesión",
                        "Sistema",
                        "success"
                    );
                } else {
                    Sistema.notificaciones(
                        "No se pudo hacer el cambio de cargo, solicite asistencia técnica",
                        "Sistema",
                        "error"
                    );
                }
            },
            error: function () {},
        });


      });
    //--------------------------------------------------------------------------
    $('#formAddExperienciaLaboral').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var eliminarlaboralformal_ini = $("#rutaSoportes").attr("data_url_borrar_laboral");
        eliminarlaboralformal_ini = eliminarlaboralformal_ini.substring(0,eliminarlaboralformal_ini.length - 1);
        const eliminarlaboralformal_fin = eliminarlaboralformal_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var formData = new FormData(this);
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                console.log(respuesta);
                var respuesta_html = "";
                if (respuesta.mensaje == "ok") {
                    experiencia = respuesta.experienciaLaboral;
                    respuesta_html +='<tr>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.entidad   + experiencia.actual == 'Si' ? ' - Actual' : '' + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.tipo_entidad  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.pais  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.pais == 'COLOMBIA' ? experiencia.departamento : '---'  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.pais == 'COLOMBIA' ? experiencia.municipio : '---'  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.direccion  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.telefono  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.fecha_ingreso  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.actual == 'Si' ? 'Actual' : experiencia.fecha_termino  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.tipo_contrato  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.tiempo_contrato  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.cargo  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.dependencia  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.jefe_inmediato  + '</td>';
                    respuesta_html +='    <td style="vertical-align: normal;max-width: 300px;min-height: 200px;">' + experiencia.observaciones + '</td>';
                    respuesta_html+='     <td><a href="'+ rutaSoportes + experiencia.soporte +'" target="_blank" rel="noopener noreferrer">'+ experiencia.soporte +'</a></td>';
                    respuesta_html +='    <td class="text-center" style="min-width: 100px;">';
                    respuesta_html +='        <form action="' + eliminarlaboralformal_fin + '/' +  experiencia.id + '" class="d-inline form-eliminar" method="POST">';
                    respuesta_html +=           '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" autocomplete="off">';
                    respuesta_html +=           '<input type="hidden" name="_method" value="delete">';
                    respuesta_html +='            <button type="submit"';
                    respuesta_html +='                class="btn-accion-tabla eliminar tooltipsC text-danger"';
                    respuesta_html +='                title="Eliminar este registro">';
                    respuesta_html +='                <i class="fas fa-trash-alt"></i>';
                    respuesta_html +='            </button>';
                    respuesta_html +='        </form>';
                    respuesta_html +='    </td>';
                    respuesta_html +='</tr>';
                    $("#laboralModal").modal('hide');
                    $('#tbodyExperienciaFormal').append(respuesta_html);
                    Sistema.notificaciones(
                        "Se registro correctamente la experiencia laboral",
                        "Sistema",
                        "success"
                    );
                } else {
                    Sistema.notificaciones(
                        "No se pudo hacer el cambio de cargo, solicite asistencia técnica",
                        "Sistema",
                        "error"
                    );
                }
            },
            error: function () {},
        });


      });
    //--------------------------------------------------------------------------
    $('#formAddExperienciaInformal').submit(function(e) {
        e.preventDefault();
        const form = $(this);
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var eliminarlaboralinformal_ini = $("#rutaSoportes").attr("data_url_borrar_informal");
        eliminarlaboralinformal_ini = eliminarlaboralinformal_ini.substring(0,eliminarlaboralinformal_ini.length - 1);
        const eliminarlaboralinformal_fin = eliminarlaboralinformal_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        var formData = new FormData(this);
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: formData,
            contentType: false,
            processData: false,
            success: function (respuesta) {
                console.log(respuesta);
                var respuesta_html = "";
                if (respuesta.mensaje == "ok") {
                    experiencia = respuesta.experienciaLaboral;
                    respuesta_html +='<tr>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.entidad + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.tipo_entidad  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.actividad  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.producto  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.pais  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.pais == 'COLOMBIA' ? experiencia.departamento : '---'  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.pais == 'COLOMBIA' ? experiencia.municipio : '---'  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.direccion  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.telefono  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.fecha_inicio  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.fecha_termino  + '</td>';
                    respuesta_html +='    <td style="white-space:nowrap;">' + experiencia.tipo_contrato  + '</td>';
                    respuesta_html +='    <td style="vertical-align: normal;max-width: 300px;min-height: 200px;">' + experiencia.observaciones + '</td>';
                    respuesta_html+='     <td><a href="'+ rutaSoportes + experiencia.soporte +'" target="_blank" rel="noopener noreferrer">'+ experiencia.soporte +'</a></td>';
                    respuesta_html +='    <td class="text-center" style="min-width: 100px;">';
                    respuesta_html +='        <form action="' + eliminarlaboralinformal_fin + '/' +  experiencia.id + '" class="d-inline form-eliminar" method="POST">';
                    respuesta_html +=           '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" autocomplete="off">';
                    respuesta_html +=           '<input type="hidden" name="_method" value="delete">';
                    respuesta_html +='            <button type="submit"';
                    respuesta_html +='                class="btn-accion-tabla eliminar tooltipsC text-danger"';
                    respuesta_html +='                title="Eliminar este registro">';
                    respuesta_html +='                <i class="fas fa-trash-alt"></i>';
                    respuesta_html +='            </button>';
                    respuesta_html +='        </form>';
                    respuesta_html +='    </td>';
                    respuesta_html +='</tr>';
                    $("#informalModal").modal('hide');
                    $('#tbodyExperienciaInformal').append(respuesta_html);
                    Sistema.notificaciones(
                        "Se registro correctamente la experiencia laboral",
                        "Sistema",
                        "success"
                    );
                } else {
                    Sistema.notificaciones(
                        "No se pudo hacer el cambio de cargo, solicite asistencia técnica",
                        "Sistema",
                        "error"
                    );
                }
            },
            error: function () {},
        });


      });
    //--------------------------------------------------------------------------

});

function mostrar() {
    var archivo = document.getElementById("foto").files[0];
    var reader = new FileReader();
    if (archivo) {
        reader.readAsDataURL(archivo);
        reader.onloadend = function () {
            document.getElementById("fotoUsuario").src = reader.result;
        };
    }
}

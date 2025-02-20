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
                        respuesta_html += '<option value="' + item.id + '">' + item.empresa + "</option>";
                    });
                } else {
                    respuesta_html += '<option value="">Elija un grupo</option>';
                }
                $("#empresa_id").html(respuesta_html);
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
        var eliminarManual_ini = $("#eliminarManual").val();
        eliminarManual_ini = eliminarManual_ini.substring(0,eliminarManual_ini.length - 1);
        const eliminarManual_fin = eliminarManual_ini;
        // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
        const data_archivo = $("#eliminarManual").attr("data_archivo") + '/';

        $.ajax({
            url: data_url,
            type: "GET",
            data: data,
            success: function (respuesta) {
                var respuesta_html = "";
                if (respuesta.areas.length > 0) {
                    $.each(respuesta.areas, function (index, area) {
                        $.each(area.cargos, function (index, cargo) {
                            respuesta_html+='<tr>';
                            respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;">'+area.area+'</td>';
                            respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;">'+cargo.cargo+'</td>';
                            if (cargo.manual != null) {
                                respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;"><a href="'+data_archivo + cargo.manual.url+'" target="_blank">'+ cargo.manual.titulo+'</a></td>';
                                respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;">'+ formatDate(cargo.manual.created_at) + '</td>';
                            } else {
                                respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;">No registra manual</td>';
                                respuesta_html+='    <td class="text-center" style="white-space:nowrap; vertical-align:top;"><span class="text-danger">---</span></td>';
                            }
                            if (cargo.manual != null) {
                                respuesta_html +='<td class="text-center" style="min-width: 100px;">';
                                respuesta_html +='    <form action="' + eliminarManual_fin  +  cargo.manual.id + '" class="d-inline form-eliminar" method="POST">';
                                respuesta_html +=       '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" autocomplete="off">';
                                respuesta_html +=       '<input type="hidden" name="_method" value="delete">';
                                respuesta_html +='        <button type="submit"';
                                respuesta_html +='            class="btn-accion-tabla eliminar tooltipsC text-danger"';
                                respuesta_html +='            title="Eliminar este registro">';
                                respuesta_html +='            <i class="fas fa-trash-alt"></i>';
                                respuesta_html +='        </button>';
                                respuesta_html +='    </form>';
                                respuesta_html +='</td>';
                            } else {
                                respuesta_html+='<td class="text-center" style="white-space:nowrap; vertical-align:top;">';
                                respuesta_html +='  <button type="button" class="btn-accion-tabla eliminar tooltipsC" onclick="valueIdCargo(\' ' + cargo.id +' \')" data-bs-toggle="modal" data-bs-target="#manualModal">';
                                respuesta_html +='      <i class="fas fa-plus-circle text-success"></i>';
                                respuesta_html +='  </button>';
                                respuesta_html+=' </td>';
                            }
                            respuesta_html+='</tr>';
                        });
                    });
                }
                $("#tablaManuales").DataTable().destroy();
                $("#tbody_manuales").html(respuesta_html);
                asignarDataTableAjax('#tablaManuales',10,"portrait","Legal","listado de Manuales por cargo",false);
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
    $("#formManualCargo").submit(function(e) {
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
                    recargarTabla();
                    Sistema.notificaciones(
                        "Se cargo el manual de manera correcta",
                        "Sistema",
                        "success"
                    );
                } else {
                    Sistema.notificaciones(
                        "No se pudo cargar el documento, solicite asistencia técnica",
                        "Sistema",
                        "error"
                    );
                }
            },
            error: function () {},
        });
      });

      //-------------------------------------------------------
    $(".tabla-borrando_manuales").on("submit", ".form-eliminar", function () {
        event.preventDefault();
        const form = $(this);
        Swal.fire({
            title: "¿Está seguro que desea eliminar el manual?",
            text: "Esta acción no se puede deshacer!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Si, Borrar!",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                ajaxRequest(form);
            }
        });
    });

    function ajaxRequest(form) {
        $.ajax({
            url: form.attr("action"),
            type: "POST",
            data: form.serialize(),
            success: function (respuesta) {
                if (respuesta.mensaje == "ok") {
                    recargarTabla();
                    Sistema.notificaciones(
                        "El registro fue eliminado correctamente",
                        "Sistema",
                        "success"
                    );
                } else {
                    Sistema.notificaciones(
                        "El registro no pudo ser eliminado, hay recursos usandolo",
                        "Sistema",
                        "error"
                    );
                }
            },
            error: function () {},
        });
    }
    //--------------------------------------------------------------------------------------------
});
function recargarTabla(){
    $("#manualModal").modal('hide');
    const data_url = $('#empresa_id').attr("data_url");
    const id = $('#empresa_id').val();
    var data = {
        id: id,
    };
    // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
    var eliminarManual_ini = $("#eliminarManual").val();
    eliminarManual_ini = eliminarManual_ini.substring(0,eliminarManual_ini.length - 1);
    const eliminarManual_fin = eliminarManual_ini;
    // -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*- -*-
    const data_archivo = $("#eliminarManual").attr("data_archivo") + '/';

    $.ajax({
        url: data_url,
        type: "GET",
        data: data,
        success: function (respuesta) {
            var respuesta_html = "";
            if (respuesta.areas.length > 0) {
                $.each(respuesta.areas, function (index, area) {
                    $.each(area.cargos, function (index, cargo) {
                        respuesta_html+='<tr>';
                        respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;">'+area.area+'</td>';
                        respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;">'+cargo.cargo+'</td>';
                        if (cargo.manual != null) {
                            respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;"><a href="'+data_archivo + cargo.manual.url+'" target="_blank">'+ cargo.manual.titulo+'</a></td>';
                            respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;">'+ formatDate(cargo.manual.created_at) + '</td>';
                        } else {
                            respuesta_html+='    <td style="white-space:nowrap; vertical-align:top;">No registra manual</td>';
                            respuesta_html+='    <td class="text-center" style="white-space:nowrap; vertical-align:top;"><span class="text-danger">---</span></td>';
                        }
                        if (cargo.manual != null) {
                            respuesta_html +='<td class="text-center" style="min-width: 100px;">';
                            respuesta_html +='    <form action="' + eliminarManual_fin +  cargo.manual.id + '" class="d-inline form-eliminar" method="POST">';
                            respuesta_html +=       '<input type="hidden" name="_token" value="'+$("input[name=_token]").val()+'" autocomplete="off">';
                            respuesta_html +=       '<input type="hidden" name="_method" value="delete">';
                            respuesta_html +='        <button type="submit"';
                            respuesta_html +='            class="btn-accion-tabla eliminar tooltipsC text-danger"';
                            respuesta_html +='            title="Eliminar este registro">';
                            respuesta_html +='            <i class="fas fa-trash-alt"></i>';
                            respuesta_html +='        </button>';
                            respuesta_html +='    </form>';
                            respuesta_html +='</td>';
                        } else {
                            respuesta_html+='<td class="text-center" style="white-space:nowrap; vertical-align:top;">';
                            respuesta_html +='  <button type="button" class="btn-accion-tabla eliminar tooltipsC" data-bs-toggle="modal" data-bs-target="#manualModal">';
                            respuesta_html +='      <i class="fas fa-plus-circle text-success"></i>';
                            respuesta_html +='  </button>';
                            respuesta_html+=' </td>';
                        }
                        respuesta_html+='</tr>';
                    });
                });
            }
            $("#tablaManuales").DataTable().destroy();
            $("#tbody_manuales").html(respuesta_html);
            asignarDataTableAjax('#tablaManuales',10,"portrait","Legal","listado de Manuales por cargo",false);
        },
        error: function () {},
    });
}

function formatDate(date) {
    var d = new Date(date),
        month = '' + (d.getMonth() + 1),
        day = '' + d.getDate(),
        year = d.getFullYear();

    if (month.length < 2)
        month = '0' + month;
    if (day.length < 2)
        day = '0' + day;

    return [year, month, day].join('-');
}

function valueIdCargo(id_cargo){
    $('#id_cargo').val(id_cargo);
}

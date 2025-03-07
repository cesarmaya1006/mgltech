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
        $.ajax({
            url: data_url,
            type: "GET",
            data: data,
            success: function (respuesta) {
                var respuesta_html = "";
                if (respuesta.empleados.length > 0) {
                    recargarTabla(respuesta.empleados);
                }
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------------------------
});
function verSoportes(id){
    const data_soportes = $('#datosUpLaod').attr("data_soportes");
    const ruta_soporte = $('#datosUpLaod').attr("ruta_soporte");
    const id_empl = id;
    var data = {
        id: id_empl,
    };
    $.ajax({
        url: data_soportes,
        type: "GET",
        data: data,
        success: function (respuesta) {
            var respuesta_html = "";
            respuesta_html+='<table class="table">';
            respuesta_html+='<tbody></tbody>';
            $.each(respuesta.soportes, function (index, soporte) {
                //respuesta_html += '<li class="list-group-item"><a href="'+ ruta_soporte + soporte.url+'" target="_blank">'+soporte.titulo+'</a></li>';
                respuesta_html+='<tr id="tr_'+soporte.id+'" style="font-size: 0.8em;">';
                var titulo = '';
                if (soporte.titulo.length>60) {
                    titulo = soporte.titulo.substring(0, 60) + '...';
                } else {
                    titulo = soporte.titulo;
                }
                respuesta_html+='<td class="text-left" scope="row"><a href="'+ ruta_soporte + soporte.url+'" target="_blank">'+titulo+'</a></td>';
                respuesta_html+='<td><button class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro" onClick="borrarSoporte(\''+soporte.id+'\')"><i class="fa fa-fw fa-trash text-danger"></i></button></td>';
                respuesta_html+='</tr>';

            });
            respuesta_html+='</tbody>';
            respuesta_html+='</table>';
            Swal.fire({
                width: 700,
                title: "Soportes",
                //html: '<ul class="list-group" style="font-size: 0.8em;">'+respuesta_html+'</ul>',
                html: respuesta_html,
                confirmButtonText: 'Cerrar',
                showClass: {
                    popup: `animate__animated
                            animate__fadeInUp
                            animate__faster`
                },
                hideClass: {
                    popup: `animate__animated
                            animate__fadeOutDown
                            animate__faster`
                }
            });
        },
        error: function () {},
    });

}

function cargarSoportes(id){
    "use strict'";
    const data_url = $('#datosUpLaod').attr("data_url");
    Swal.fire({
        title: 'Ingrese el archivo soporte',
        input: 'file',
        showCancelButton: true,
        cancelButtonText: 'Cancelar',
        confirmButtonText: 'Guardar',
        customClass: {
          validationMessage: 'my-validation-message',
        },
        preConfirm: (value) => {
          if (!value) {
            Swal.showValidationMessage('El archivo es requerido')
          }
        },
      }).then((file) => {
        if (file.value) {
            var formData = new FormData();
            var file = $('.swal2-file')[0].files[0];
            formData.append("empleado_id", id);
            formData.append("fileToUpload", file);
            $.ajax({
                async: true,
                headers: { 'X-CSRF-TOKEN': $("input[name=_token]").val() },
                method: 'post',
                url: data_url,
                data: formData,
                processData: false,
                contentType: false,
                success: function (resp) {
                    if (resp.mensaje == "ok") {
                        recargarTabla(resp.empleados);
                        Swal.fire("Archivo Guardado", "", "success");
                    } else {
                        Swal.fire("La carga de archivo no fue posible, Intentalo nuevamente", "", "error");
                    }

                },
                error: function() {
                    Swal({ type: 'error', title: 'Oops...', text: 'Something went wrong!' })
                }
            })
        }
    })
}
function recargarTabla (empleados){
    var respuesta_html = '';
    $("#tablaSoportes").DataTable().destroy();
    $("#tbody_soportes").html(respuesta_html);
    var soportes = '';
    $.each(empleados, function (index,  empleado) {
        respuesta_html+='<tr>';
        respuesta_html+='    <td style="white-space:nowrap;">'+empleado.cargo.area.area+'</td>';
        respuesta_html+='    <td style="white-space:nowrap;">'+empleado.cargo.cargo+'</td>';
        respuesta_html+='    <td style="white-space:nowrap;">'+empleado.nombres + ' ' + empleado.apellidos +'</td>';
        respuesta_html+='    <td style="white-space:nowrap;" class="text-center">';
        if (empleado.soportes.length === 0) {
            soportes = '<span class="badge bg-warning pt-1 pb-1 pl-3 pr-3">Sin Soportes</span>';
        } else {
            soportes = '<button type="button" class="btn-accion-tabla bg-gradient-info tooltipsC pt-1 pb-1 pl-3 pr-3 rounded-1" onclick="verSoportes('+ empleado.id +')"><i class="fas fa-eye mr-3"></i> '+empleado.soportes.length+'</button>';
        }
        respuesta_html+=soportes;
        respuesta_html+='    </td>';
        respuesta_html+='    <td style="white-space:nowrap;" class="text-center">';
        respuesta_html+='        <button type="button" class="btn-accion-tabla bg-gradient-success tooltipsC pt-1 pb-1 pl-3 pr-3 rounded-1" onclick="cargarSoportes('+ empleado.id +')"><i class="fas fa-plus-circle" aria-hidden="true"></i></button>';
        respuesta_html+='    </td>';
        respuesta_html+='</tr>';
    });
    $("#tablaSoportes").DataTable().destroy();
    $("#tbody_soportes").html(respuesta_html);
    asignarDataTableAjax('#tablaSoportes',"listado de soportes por usuario");
}
function borrarSoporte(id_soporte){
    Swal.fire({
        title: "¿Está seguro que desea eliminar el soporte?",
        text: "Esta acción no se puede deshacer!",
        icon: "warning",
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Si, Borrar!",
        cancelButtonText: "Cancelar",
    }).then((result) => {
        if (result.isConfirmed) {
            const data_url = $('#borrarSoportes').attr("data_url");
            var data = {
                id: id_soporte,
            };
            $.ajax({
                async: true,
                headers: { 'X-CSRF-TOKEN': $("input[name=_token]").val() },
                url: data_url,
                type: "DELETE",
                data: data,
                success: function (respuesta) {
                    if (respuesta.mensaje == "ok") {
                        recargarTabla(respuesta.empleados);
                        Sistema.notificaciones("El soporte fue eliminado correctamente","Sistema","success"
                        );
                    } else {
                        Sistema.notificaciones("El soporte no pudo ser eliminado, hay recursos usandolo","Sistema","error"
                        );
                    }
                },
                error: function () {},
            });
        }
    });
}

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
                    $('#label_empresa_id').addClass('requerido');

                }else{
                    $("#empresa_id").html(respuesta_html);
                    $("#caja_empresas").addClass("d-none");
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
        $.ajax({
            url: data_url,
            type: "GET",
            data: data,
            success: function (respuesta) {
                var respuesta_html = "";
                if (respuesta.areasPadre.length > 0) {
                    respuesta_html += '<option value="">Elija área</option>';
                    $.each(respuesta.areasPadre, function (index, item) {
                        respuesta_html += '<option value="' + item.id + '">' + item.area + "</option>";
                    });
                    $("#area_id").html(respuesta_html);
                    $("#col_caja_areas").removeClass("d-none");
                    $("#area_id").prop('required',true);
                }else{
                    $("#area_id").html(respuesta_html);
                    $("#col_caja_areas").addClass("d-none");
                    $("#area_id").prop('required',false);
                }
            },
            error: function () {},
        });
    });
    //--------------------------------------------------------------------------
    $("#area_id").on("change", function () {
        const id = $(this).val();
        console.log(id);
        var vacio = '';
        $("#cargo").html(vacio);
        if (id!=0) {
            $("#caja_cargo_nueva").removeClass("d-none");
            $("#cargo").prop('required',true);
        } else {
            $("#caja_cargo_nueva").addClass("d-none");
            $("#cargo").prop('required',false);
        }
    });
    //--------------------------------------------------------------------------

});



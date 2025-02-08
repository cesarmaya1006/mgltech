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

$(document).ready(function () {

    $("#nestable")
        .nestable()
        .on("change", function () {
            const data = {
                menu: window.JSON.stringify(
                    $("#nestable").nestable("serialize")
                ),
                _token: $("input[name=_token]").val(),
            };
            $.ajax({
                type: "get", //THIS NEEDS TO BE GET
                url: "http://127.0.0.1:8000/dashboard/configuracion/menu/guardar-orden",
                dataType: "json",
                data: data,
                success: function (respuesta) {},
            });
        });

    $(".eliminar-menu").on("click", function (event) {
        event.preventDefault();
        const url = $(this).attr("href");

        Swal.fire({
            title: "¿Está seguro que desea eliminar el registro ??",
            text: "Esta acción no se puede deshacer!",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            ccancelButtonText: "Cancelar",
            confirmButtonText: "Aceptar",
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = url;
            }
        });
    });

    $("#nestable").nestable("expandAll");
});

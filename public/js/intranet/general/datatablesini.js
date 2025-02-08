$(document).ready(function () {
    $(".tabla_data_table_gantt").DataTable({
        lengthMenu: [5, 10, 15, 25, 50, 75, 100],
        pageLength: 5,
        dom: "lBfrtip",
        buttons: [
            "excel",
            {
                extend: "pdfHtml5",
                orientation: "landscape",
                pageSize: "A1",
            },
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ resultados",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
            sInfoEmpty:
                "Mostrando resultados del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });
    $(".tabla_data_table").DataTable({
        lengthMenu: [10, 15, 25, 50, 75, 100],
        pageLength: 15,
        dom: "lBfrtip",
        buttons: [
            "excel",
            {
                extend: "pdfHtml5",
                orientation: "landscape",
                pageSize: "A1",
                defaultStyle: {
                    fontSize: 10,
                },
            },
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ resultados",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
            sInfoEmpty:
                "Mostrando resultados del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });

    $(".tabla_data_table_xl").DataTable({
        lengthMenu: [10, 15, 25, 50, 75, 100],
        pageLength: 15,
        dom: "lBfrtip",
        buttons: [
            "excel",
            {
                extend: "pdfHtml5",
                orientation: "landscape",
                pageSize: "A1",
            },
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ resultados",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
            sInfoEmpty:
                "Mostrando resultados del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });

    $(".tabla_data_table_l").DataTable({
        lengthMenu: [10, 15, 25, 50, 75, 100],
        pageLength: 15,
        dom: "lBfrtip",
        buttons: [
            "excel",
            {
                extend: "pdfHtml5",
                orientation: "landscape",
                pageSize: "Legal",
                title: $("#titulo_tabla").val(),
            },
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ resultados",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
            sInfoEmpty:
                "Mostrando resultados del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });

    $(".tabla_data_table_m").DataTable({
        lengthMenu: [10, 15, 25, 50, 75, 100],
        pageLength: 5,
        dom: "lBfrtip",
        buttons: [
            "excel",
            {
                extend: "pdfHtml5",
                pageSize: "Legal",
                title: $("#titulo_tabla").val(),
            },
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ resultados",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
            sInfoEmpty:
                "Mostrando resultados del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });

    $(".tabla_data_table_s").DataTable({
        lengthMenu: [10, 15, 25, 50, 75, 100],
        pageLength: 15,
        dom: "lBfrtip",
        buttons: [
            "excel",
            {
                extend: "pdfHtml5",
                orientation: "landscape",
                pageSize: "letter",
            },
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ resultados",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
            sInfoEmpty:
                "Mostrando resultados del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });

    $(".tabla_data_table_xs").DataTable({
        lengthMenu: [10, 15, 25, 50, 75, 100],
        pageLength: 15,
        dom: "lBfrtip",
        buttons: [
            "excel",
            {
                extend: "pdfHtml5",
                pageSize: "letter",
            },
        ],
        language: {
            sProcessing: "Procesando...",
            sLengthMenu: "Mostrar _MENU_ resultados",
            sZeroRecords: "No se encontraron resultados",
            sEmptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
            sInfoEmpty:
                "Mostrando resultados del 0 al 0 de un total de 0 registros",
            sInfoFiltered: "(filtrado de un total de _MAX_ registros)",
            sSearch: "Buscar:",
            sLoadingRecords: "Cargando...",
            oPaginate: {
                sFirst: "Primero",
                sLast: "Último",
                sNext: "Siguiente",
                sPrevious: "Anterior",
            },
        },
    });

    $(".search").keyup(function () {
        var searchTerm = $(".search").val();
        var listItem = $(".results tbody").children("tr");
        var searchSplit = searchTerm.replace(/ /g, "'):containsi('");

        $.extend($.expr[":"], {
            containsi: function (elem, i, match, array) {
                return (
                    (elem.textContent || elem.innerText || "")
                        .toLowerCase()
                        .indexOf((match[3] || "").toLowerCase()) >= 0
                );
            },
        });

        $(".results tbody tr")
            .not(":containsi('" + searchSplit + "')")
            .each(function (e) {
                $(this).attr("visible", "false");
            });

        $(".results tbody tr:containsi('" + searchSplit + "')").each(function (
            e
        ) {
            $(this).attr("visible", "true");
        });

        var jobCount = $('.results tbody tr[visible="true"]').length;
        $(".counter").text(jobCount + " item");

        if (jobCount == "0") {
            $(".no-result").show();
        } else {
            $(".no-result").hide();
        }
    });
});

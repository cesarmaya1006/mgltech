<!-- dat Table -->

<script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
<script src="https://cdn.datatables.net/2.0.8/js/dataTables.bootstrap5.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/dataTables.buttons.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.bootstrap5.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.print.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.0.2/js/buttons.colVis.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/5.3.0/js/bootstrap.bundle.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/v/bs5/jq-3.7.0/jszip-3.10.1/dt-2.2.1/af-2.7.0/b-3.2.0/b-colvis-3.2.0/b-html5-3.2.0/fc-5.0.4/fh-4.0.1/r-3.0.3/rg-1.5.1/rr-1.5.0/sc-2.4.3/sb-1.8.1/sp-2.3.3/sl-3.0.0/datatables.min.js"></script>



<script>
    $(document).ready(function () {
        $(".tabla_data_table_inicial").DataTable({
            scrollX: true,
            ordering: false,
            pageLength: 10,
            layout: {
                topStart: {
                    pageLength: {
                        menu: [ 5, 10, 25, 50, 100 ]
                    }
                },
                topEnd: {
                    search: {
                        placeholder: 'Buscar'
                    }
                }
            },
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ resultados",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
                sInfoEmpty: "Mostrando resultados del 0 al 0 de un total de 0 registros",
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

        $(".tabla_data_table_inicial_opt").DataTable({
            pageLength: $(this).attr('data_pageLength'),
            layout: {
                top2Start: {
                    pageLength: {
                        menu: [ 5, 10, 25, 50, 100 ]
                    }
                },
                top2End: null
                ,topStart: {
                    buttons: [{extend: 'excel',title:$(this).attr('data_titulo')},{extend: 'pdf',title: $(this).attr('data_titulo')}]
                },
                topEnd: {
                    search: {
                        placeholder: 'Buscar'
                    }
                }
            },
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ resultados",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
                sInfoEmpty: "Mostrando resultados del 0 al 0 de un total de 0 registros",
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
    });


    function asignarDataTableEmpl(tabla_id, paginacion, orientation, pageSize) {
        $("#" + tabla_id).DataTable({
            scrollX: true,
            lengthMenu: [5, 10, 15, 25, 50, 75, 100],
            pageLength: paginacion,
            buttons: [
                "excel",
                {
                    extend: "pdfHtml5",
                    orientation: orientation,
                    pageSize: pageSize,
                },
            ],
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ resultados",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
                sInfoEmpty: "Mostrando resultados del 0 al 0 de un total de 0 registros",
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

    }

    function asignarDataTable_ajax(tabla, paginacion, orientation, pageSize,titulo, buttons) {
        var buttons_t = '';
        if (buttons) {
            buttons_t = [{extend: 'excel',title:titulo},{extend: 'pdf',title: titulo}];
            layout_var = [{top2Start: {pageLength: paginacion}},{top2End: null},{topStart: {buttons: buttons_t}},{topEnd: 'search'}];
        }else{
            layout_var = [{topStart: {pageLength: paginacion}},{topEnd: 'search'}];
        }
        $(tabla).DataTable({
            scrollX: true,
            bSort: true,
            lengthMenu: [5, 10, 15, 25, 50, 75, 100],
            pageLength: paginacion,
            layout: {layout_var},
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ resultados",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
                sInfoEmpty: "Mostrando resultados del 0 al 0 de un total de 0 registros",
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
    }

    function asignarDataTableAjax(table_id,titulo_tabla,paginacion) {
        var buttons = true;
        var buttons_t = '';
        if (buttons) {
            buttons_t = [{extend: 'excel',title:titulo_tabla},{extend: 'pdf',title: titulo_tabla}];
            layout_var = [{top2Start: {pageLength: paginacion}},{top2End: null},{topStart: {buttons: [
                "excel",
                {
                    extend: "pdfHtml5",
                    orientation: "landscape",
                    pageSize: "Legal",
                    title: titulo_tabla,
                },
            ]}},{topEnd: 'search'}];
        }else{
            buttons_t = [{extend: 'excel',title:titulo_tabla},{extend: 'pdf',title: titulo_tabla}];
            layout_var = [{top2Start: {pageLength: paginacion}},{top2End: null},{topStart: {buttons: [
                "excel",
                {
                    extend: "pdfHtml5",
                    orientation: "landscape",
                    pageSize: "Legal",
                    title: titulo_tabla,
                },
            ]}},{topEnd: 'search'}];
        }

        $(table_id).DataTable({
            bSort: true,
            pageLength: paginacion,
            layout: {
                top2Start: {
                    pageLength: {
                        menu: [ 5, 10, 25, 50, 100 ]
                    }
                },
                top2End: null
                ,topStart: {
                    buttons: [{extend: 'excel',title:$(this).attr('data_titulo')},{extend: 'pdf',title: $(this).attr('data_titulo')}]
                },
                topEnd: {
                    search: {
                        placeholder: 'Buscar'
                    }
                }
            },
            language: {
                sProcessing: "Procesando...",
                sLengthMenu: "Mostrar _MENU_ resultados",
                sZeroRecords: "No se encontraron resultados",
                sEmptyTable: "Ningún dato disponible en esta tabla",
                sInfo: "Mostrando resultados _START_-_END_ de  _TOTAL_",
                sInfoEmpty: "Mostrando resultados del 0 al 0 de un total de 0 registros",
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
    }
    function vaciarTabla(table_id,tbody) {
        respuesta_tabla_html = '';
        $(table_id).DataTable().destroy();
        $(tbody).html(respuesta_tabla_html);
    };
</script>

<!-- ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== ===== -->
<!-- dat Table -->
<script src="https://cdn.datatables.net/1.13.1/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/dataTables.buttons.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/jszip/3.10.1/jszip.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/pdfmake.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.1.53/vfs_fonts.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.html5.min.js"></script>
<script src="https://cdn.datatables.net/buttons/3.2.0/js/buttons.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/1.13.4/js/dataTables.bootstrap5.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/dataTables.responsive.min.js"></script>
<script src="https://cdn.datatables.net/responsive/2.4.1/js/responsive.bootstrap5.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>

<script src="{{ asset('js/intranet/general/datatablesini.js') }}"></script>
<script>
    function asignarDataTableAjax(table_id,titulo_tabla) {
        $(table_id).DataTable({
            bSort: false,
            lengthMenu: [10, 15, 25, 50, 75, 100],
            pageLength: 15,
            dom: "lBfrtip",
            buttons: [
                "excel",
                {
                    extend: "pdfHtml5",
                    orientation: "landscape",
                    pageSize: "Legal",
                    title: titulo_tabla,
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

    function vaciarTabla(table_id,tbody) {
        respuesta_tabla_html = '';
        $(table_id).DataTable().destroy();
        $(tbody).html(respuesta_tabla_html);
    };
</script>

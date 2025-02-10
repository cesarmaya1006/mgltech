@extends('intranet.layout.app')

@section('css_pagina')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css" />
    <link rel="stylesheet" href="https://cdn.datatables.net/2.0.8/css/dataTables.dataTables.css">
@endsection

@section('titulo_pagina')
    <i class="fas fa-building mr-3" aria-hidden="true"></i> Configuración Empresas
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Empresas</li>
@endsection

@section('titulo_card')
    Listado de Empresas
@endsection

@section('botones_card')
    <a href="{{ route('empresa.create') }}" class="btn btn-primary btn-sm btn-sombra text-center pl-5 pr-5 float-md-end">
        <i class="fa fa-plus-circle mr-3" aria-hidden="true"></i>
        Nuevo registro
    </a>
@endsection

@section('cuerpo')
    <div class="row">
        <div class="col-12 col-md-3 form-group">
            <label for="emp_grupo_id">Grupo Empresarial</label>
            <select id="emp_grupo_id" class="form-control form-control-sm" data_url="{{ route('empresa.getEmpresas') }}">
                <option value="">Elija un Grupo Empresarial</option>
                @foreach ($grupos as $grupo)
                    <option value="{{ $grupo->id }}">
                        {{ $grupo->grupo }}
                    </option>
                @endforeach
            </select>
        </div>
    </div>
    <hr>
    <div class="row" id="caja_tabla_empresas">
        <div class="col-12">
            <div class="col-12">
                <input type="hidden" name="titulo_tabla" id="titulo_tabla" value="Listado de Grupos Empresariales">
                <input type="hidden" id="control_dataTable" value="1">
                <input type="hidden" id="grupo_empresas_edit" data_url="{{ route('empresa.edit', ['id' => 1]) }}">
                <input type="hidden" id="grupo_empresas_destroy" data_url="{{ route('empresa.destroy', ['id' => 1]) }}">
                @csrf @method('delete')

                <div class="col-12">
                    <input type="hidden" name="titulo_tabla" id="titulo_tabla" value="Listado de Grupos Empresariales">
                    <table class="table display table-striped table-hover table-sm  tabla-borrando tabla_data_table"
                        id="tablaEmpresas">
                        <thead>
                            <tr>
                                <th class="text-center">Id</th>
                                <th>Identificación</th>
                                <th>Empresa</th>
                                <th>Correo Electrónico</th>
                                <th>Teléfono</th>
                                <th>Dirección</th>
                                <th>Contacto</th>
                                <th>Cargo Contacto</th>
                                <th>Estado</th>
                                <td></td>
                            </tr>
                        </thead>
                        <tbody id="tbody_empresas">

                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

@section('footer_card')
@endsection

@section('modales')
@endsection

@section('scripts_pagina')
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="https://cdn.datatables.net/2.0.8/js/dataTables.js"></script>
    <script src="{{ asset('js/intranet/empresas/empresa/index.js') }}"></script>
    @include('intranet.layout.script_datatable')

    <script>
        $(document).ready(function() {
            // - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * -
            $("#emp_grupo_id").on("change", function() {

                $("#tablaEmpresas").dataTable().fnDestroy();
                respuesta_html = '';
                $("#tbody_empresas").html(respuesta_html);
                asignarDataTable();


                const data_url = $(this).attr("data_url");
                const id = $(this).val();
                const data_token = $(this).attr('data_token');
                var data = {
                    id: id,
                };
                const data_url_data = data_url + '?id=' + id;

                if ($(this).val()) {

                    var grupo_empresas_edit_ini = $('#grupo_empresas_edit').attr("data_url");
                    grupo_empresas_edit_ini = grupo_empresas_edit_ini.substring(0, grupo_empresas_edit_ini
                        .length - 1);
                    const grupo_empresas_edit_fin = grupo_empresas_edit_ini;

                    var grupo_empresas_destroy_ini = $('#grupo_empresas_destroy').attr("data_url");
                    grupo_empresas_destroy_ini = grupo_empresas_destroy_ini.substring(0,
                        grupo_empresas_destroy_ini.length - 1);
                    const grupo_empresas_destroy_fin = grupo_empresas_destroy_ini;






                    $.ajax({
                        url: data_url,
                        type: "GET",
                        data: data,
                        success: function(respuesta) {
                            respuesta_html = '';
                            if (respuesta.data.length > 0) {

                                $("#tablaEmpresas").dataTable().fnDestroy();
                                respuesta_html = '';
                                $.each(respuesta.data, function(index, item) {
                                    respuesta_html += '<tr>';
                                    respuesta_html += '<td class="text-center">' + item
                                        .id + '</td>';
                                    respuesta_html += '<td>' + item.identificacion +
                                        '</td>';
                                    respuesta_html += '<td>' + item.empresa + '</td>';
                                    respuesta_html += '<td>' + item.email + '</td>';
                                    respuesta_html += '<td>' + item.telefono + '</td>';
                                    respuesta_html += '<td>' + item.direccion + '</td>';
                                    respuesta_html += '<td>' + item.contacto + '</td>';
                                    respuesta_html += '<td>' + item.cargo + '</td>';
                                    respuesta_html += '<td>';
                                    respuesta_html += '<span class="btn-info btn-xs pl-3 pr-3 d-flex flex-row align-items-center bg-';
                                    if (item.estado == 1) {
                                        respuesta_html += 'success';
                                    } else {
                                        respuesta_html += 'gray';
                                    }
                                    respuesta_html += ' rounded">';
                                    if (item.estado == 1) {
                                        respuesta_html += 'Activo</span>';
                                    } else {
                                        respuesta_html += 'Inactivo</span>';
                                    }
                                    respuesta_html += '</td>';
                                    respuesta_html +=
                                        '<td class="d-flex justify-content-evenly align-items-center">';
                                    respuesta_html += '<a href="' +
                                        grupo_empresas_edit_fin + item.id +
                                        '" class="btn-accion-tabla tooltipsC" title="Editar este registro">';
                                    respuesta_html +=
                                        '<i class="fas fa-pen-square"></i>';
                                    respuesta_html += '</a>';
                                    respuesta_html += '<form action="' + grupo_empresas_destroy_fin + item.id + '" class="d-inline form-eliminar" method="POST">';
                                    respuesta_html += '<input type="hidden" name="_token" value="{{ csrf_token() }}" autocomplete="off">';
                                    respuesta_html += '<input type="hidden" name="_method" value="delete">';
                                    respuesta_html += '<button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro">';
                                    respuesta_html += '<i class="fa fa-fw fa-trash text-danger"></i>';
                                    respuesta_html += '</button>';
                                    respuesta_html += '</form>';
                                    respuesta_html += '</td>';
                                    respuesta_html += '</tr>';
                                });
                                $("#tbody_empresas").html(respuesta_html);
                                $("#tablaEmpresas").DataTable({
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
                        },
                        error: function() {},
                    });

                }

            });
            // - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * - - * -
        });

        function asignarDataTable() {
            $("#tablaEmpresas").DataTable({
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
    </script>
@endsection

@extends('intranet.layout.app')

@section('css_pagina')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css" />
@endsection

@section('tituloPagina')
    <i class="fas fa-check-square mr-3" aria-hidden="true"></i> Configuración Permisos
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Permisos</li>
@endsection

@section('titulo_card')
    Listado de Permisos
@endsection

@section('botones_card')
    <a href="{{ route('rol.create') }}" class="btn btn-info btn-sm btn-sombra text-center pl-5 pr-5 float-md-end">
        <i class="fa fa-plus-circle mr-3" aria-hidden="true"></i>
        Nuevo Permiso
    </a>
@endsection

@section('cuerpoPagina')
    <div class="row d-flex justify-content-md-center">
        <div class="col-12 col-md-6 table-responsive">
            <table class="table table-striped table-hover table-sm tabla_data_table_xs tabla-borrando" id="tabla-data">
                <thead>
                    <tr>
                        <th>Id</th>
                        <th>Permiso / Ruta</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permisos as $permiso)
                        <tr>
                            <td>{{ $permiso->id }}</td>
                            <td>{{ $permiso->name }}</td>
                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
    </div>
@endsection

@section('footer_card')
@endsection

@section('modales')
@endsection

@section('script_pagina')
    @include('intranet.layout.dataTableNew')
    <script src="{{ asset('js/intranet/general/datatablesini.js') }}"></script>
    <script src="{{ asset('js/intranet/configuracion/roles/index.js') }}"></script>

@endsection

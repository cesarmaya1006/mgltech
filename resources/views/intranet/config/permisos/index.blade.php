<!-- ======================================================================================================= -->
@extends('intranet.layout.app')
@section('css_pagina')
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

@endsection
@section('cuerpoPagina')
    @can('permiso_rutas.index')
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
    @else
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="alert alert-warning alert-dismissible mini_sombra">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Sin Acceso!</h5>
                    <p style="text-align: justify">Su usuario no tiene permisos de acceso para esta vista, Comuniquese con el
                        administrador del sistema.</p>
                </div>
            </div>
        </div>
    @endcan
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

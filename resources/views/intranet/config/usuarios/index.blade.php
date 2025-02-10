@extends('intranet.layout.app')
@section('css_pagina')
@endsection
@section('tituloPagina')
    <i class="fas fa-industry" aria-hidden="true"></i> Empresas
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Empresas</a></li>
@endsection
@section('titulo_card')
    Listado de Empresas
@endsection
@section('botones_card')
    @can('empresa.create')
        <a href="{{ route('empresa.create') }}" class="btn btn-primary btn-xs btn-sombra text-center pl-5 pr-5 float-md-end">
            <i class="fa fa-plus-circle mr-3" aria-hidden="true"></i>
            Nuevo Registro
        </a>
    @endcan
@endsection
@section('cuerpoPagina')
    @can('empresa.index')
        <div class="row d-flex justify-content-md-center">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-hover table-sm tabla_data_table_m tabla-borrando" id="tabla-data">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th>Identificación</th>
                            <th>Empresa</th>
                            <th>Correo Electrónico</th>
                            <th>Teléfono</th>
                            <th>Contacto</th>
                            <th>Cargo Contacto</th>
                            <th>Estado</th>
                            <th class="width70"></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($empresas as $empresa)
                            <tr>
                                <td class="text-nowrap text-center">{{ $empresa->id }}</td>
                                <td class="text-nowrap">{{ $empresa->tipos_docu->abreb_id . ' ' . $empresa->identificacion }}
                                </td>
                                <td class="text-nowrap">{{ $empresa->nombre }}</td>
                                <td class="text-nowrap">{{ $empresa->email }}</td>
                                <td class="text-nowrap">{{ $empresa->telefono }}</td>
                                <td class="text-nowrap">{{ $empresa->contacto }}</td>
                                <td class="text-nowrap">{{ $empresa->cargo }}</td>
                                <td><span class="btn-info btn-xs pl-3 pr-3 d-flex flex-row align-items-center bg-{{ $empresa->estado == 1 ? 'success' : 'gray' }} rounded">{{ $empresa->estado == 1 ? 'Activo' : 'Inactivo' }}</span></td>
                                <td class="d-flex justify-content-evenly">
                                    @can('empresa.edit')
                                        <a href="{{ route('empresa.edit', ['id' => $empresa->id]) }}" class="btn-accion-tabla tooltipsC text-info" title="Editar">
                                            <i class="fa fa-edit" aria-hidden="true"></i>
                                        </a>
                                    @endcan
                                    @can('empresa.destroy')
                                        <form action="{{ route('empresa.destroy', ['id' => $empresa->id]) }}"class="d-inline form-eliminar" method="POST">
                                            @csrf
                                            @method('delete')
                                            <button type="submit" class="btn-accion-tabla eliminar tooltipsC" title="Eliminar este registro">
                                                <i class="fa fa-fw fa-trash text-danger"></i>
                                            </button>
                                        </form>
                                    @endcan
                                </td>
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
@endsection

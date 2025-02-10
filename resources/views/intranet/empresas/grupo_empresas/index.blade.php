@extends('intranet.layout.app')
@section('css_pagina')
@endsection
@section('tituloPagina')
    <i class="fas fa-industry" aria-hidden="true"></i> Grupos Empresariales
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Grupos Empresariales</a></li>
@endsection
@section('titulo_card')
    Listado de Grupos Empresariales
@endsection
@section('botones_card')
    @can('grupo_empresas.create')
        <a href="{{ route('grupo_empresas.create') }}" class="btn btn-primary btn-xs btn-sombra text-center pl-5 pr-5 float-md-end">
            <i class="fa fa-plus-circle mr-3" aria-hidden="true"></i>
            Nuevo Registro
        </a>
    @endcan
@endsection
@section('cuerpoPagina')
    @can('grupo_empresas.index')
        <div class="row d-flex justify-content-md-center">
            <div class="col-12 table-responsive">
                <input type="hidden" name="titulo_tabla" id="titulo_tabla" value="Listado de Grupos Empresariales">
                <table class="table table-striped table-hover table-sm tabla_data_table_l tabla-borrando" id="tabla-data">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th>Identificación</th>
                            <th>Nombre Grupo Emp.</th>
                            <th>Correo Electrónico</th>
                            <th>Teléfono</th>
                            <th>Dirección</th>
                            <th>Contacto</th>
                            <th>Cargo Contacto</th>
                            <th>Empresas</th>
                            <th>Estado</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach ($grupos as $grupo)
                            <tr>
                                <td class="text-center">{{ $grupo->id }}</td>
                                <td>{{ $grupo->tipo_docu->abreb_id . ' ' . $grupo->identificacion }}</td>
                                <td>{{ $grupo->grupo }}</td>
                                <td>{{ $grupo->email }}</td>
                                <td>{{ $grupo->telefono }}</td>
                                <td>{{ $grupo->direccion }}</td>
                                <td>{{ $grupo->contacto }}</td>
                                <td>{{ $grupo->cargo }}</td>
                                <td class="{{ $grupo->empresas->count() ? '' : 'text-center' }}">
                                    @if ($grupo->empresas->count())
                                        <ul>
                                            @foreach ($grupo->empresas as $empresa)
                                                <li>{{ $empresa->empresa }}</li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <span class="text-danger">---</span>
                                    @endif
                                </td>
                                <td><spanclass="btn-info btn-xs pl-3 pr-3 d-flex flex-row align-items-center bg-{{ $grupo->estado == 1 ? 'success' : 'gray' }} rounded">{{ $empresa->estado == 1 ? 'Activo' : 'Inactivo' }}</spanclass=></td>
                                <td class="d-flex justify-content-evenly align-items-center">
                                    <a href="{{ route('grupo_empresas.edit', ['id' => $grupo->id]) }}"
                                        class="btn-accion-tabla tooltipsC" title="Editar este registro">
                                        <i class="fas fa-pen-square"></i>
                                    </a>
                                    <form action="{{ route('grupo_empresas.destroy', ['id' => $grupo->id]) }}"
                                        class="d-inline form-eliminar" method="POST">
                                        @csrf @method('delete')
                                        <button type="submit" class="btn-accion-tabla eliminar tooltipsC"
                                            title="Eliminar este registro">
                                            <i class="fa fa-fw fa-trash text-danger"></i>
                                        </button>
                                    </form>
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

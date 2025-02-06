@extends('intranet.layout.app')

@section('css_pagina')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css" />
@endsection

@section('tituloPagina')
    <i class="fas fa-user-shield mr-3" aria-hidden="true"></i> Configuración - Permisos/Roles
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Permisos/Roles</li>
@endsection

@section('titulo_card')
    Administración de Permisos - Roles
@endsection

@section('cuerpoPagina')
    <div class="row d-flex justify-content-md-center">
        <div class="col-12 table-responsive">
            @csrf
            <input type="hidden" id="id_guardar_permiso_rol" data_url="{{route('permisos_rol.store')}}">
            <table class="table table-striped table-hover tabla_data_table_m" id="tabla_permisos_rol">
                <thead>
                    <tr>
                        <th scope="col">Permisos / Roles</th>
                        @foreach ($roles as $rol)
                            <th scope="col">{{ $rol->name }}</th>
                        @endforeach
                    </tr>
                </thead>
                <tbody>
                    @foreach ($permisos as $permiso)
                        <tr>
                            <td>{{ $permiso->name }}</td>
                            @foreach ($roles as $rol)
                                <td>
                                    <div class="row">
                                        <div class="col-3">
                                            <div class="form-check d-flex align-items-center">
                                                <input class="form-check-input"
                                                       type="checkbox"
                                                       value="{{$rol->hasPermissionTo($permiso->name)}}"
                                                       id="check_{{$permiso->id}}_{{$rol->id}}"
                                                       {{ $rol->hasPermissionTo($permiso->name) ? 'checked' : '' }}
                                                       onclick="guardar_permiso_rol({{$permiso->id}},{{$rol->id}},{{$rol->hasPermissionTo($permiso->name)?1:0}})">
                                                <label class="form-check-label" for="check_{{$permiso->id}}_{{$rol->id}}" id="label_{{$permiso->id}}_{{$rol->id}}">
                                                    {{ $rol->hasPermissionTo($permiso->name) ? 'Si' : 'No' }}
                                                </label>
                                            </div>
                                        </div>
                                        <div class="col-9">
                                            <a class="btn btn-warning btn-xs pl-2 pr-2 ml-2 btn-mini_sombra" href="{{route('permisos_rol.excepciones',['permission_id' => $permiso->id,'role_id' => $rol->id])}}" style="font-size: 0.7em;">Excepciones</a>
                                        </div>
                                    </div>
                                </td>
                            @endforeach
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
    <script src="{{ asset('js/intranet/configuracion/permiso_rol/permiso_rol.js') }}"></script>

@endsection

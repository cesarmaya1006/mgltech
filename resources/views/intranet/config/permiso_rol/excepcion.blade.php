@extends('intranet.layout.app')

@section('css_pagina')
    <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/1.10.23/css/dataTables.bootstrap5.min.css" />
@endsection

@section('titulo_pagina')
    <i class="fas fa-user-shield mr-3" aria-hidden="true"></i> Configuración - Permisos/Roles
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('permisos_rol.index') }}">Permisos/Roles</a></li>
    <li class="breadcrumb-item active">Excepciones</li>
@endsection

@section('titulo_card')
    Excepciones a Permisos - Roles
@endsection
@section('botones_card')
    <a href="{{ route('permisos_rol.index') }}" class="btn btn-success btn-xs btn-sombra text-center pl-5 pr-5 float-md-end"
        style="font-size: 0.8em;">
        <i class="fas fa-reply mr-2"></i>
        Volver
    </a>
@endsection

@section('cuerpo')
    <div class="row d-flex justify-content-md-center">
        <div class="col-12">
            <h4>Excepciones a Usuarios</h4>
            <br>
            <h5>Rol: {{ $rol->name }}</h5>
            <h5>Permiso: {{ $permiso->name }}</h5>
        </div>
        <hr>
        @csrf
        <input type="hidden" id="id_guardar_permiso_usuario" data_url="{{ route('permisos_rol.store_excepciones') }}">
        @foreach ($usuarios as $usuario)
            <div class="col-12 col-sm-3">
                <div class="info-box text-bg-{{ $usuario->hasPermissionTo($permiso->name) ? 'primary' : 'secondary' }} mini_sombra"
                     id="info_box_{{ $usuario->id }}"
                     onclick="guardar_permiso_usuario('{{ $permiso->name }}',{{ $usuario->id }},{{ $usuario->hasPermissionTo($permiso->name) ? 1 : 0 }})"
                     style="cursor: pointer;">
                    <span class="info-box-icon">
                        <div class="image">
                            <img src="{{ asset('imagenes/usuarios/' . ($usuario->empleado()->count() > 0 ? $usuario->empleado->foto : 'usuario-inicial.jpg')) }}"
                                class="img-fluid img-circle elevation-2">
                        </div>
                    </span>
                    <div class="info-box-content">
                        <span
                            class="info-box-text">{{ $usuario->empleado()->count() > 0 ? $usuario->empleado->nombres . ' ' . $usuario->empleado->apellidos : $usuario->name }}</span>
                        <span
                            class="progress-description">{{ $usuario->empleado()->count() > 0 ? $usuario->empleado->cargo->cargo : '' }}</span>
                        <span
                            class="progress-description" id="progress_description_{{ $usuario->id }}">{{ $usuario->hasPermissionTo($permiso->name) ? 'Con permiso Asignado' : 'Sin permiso Asignado' }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    </div>
@endsection

@section('footer_card')
@endsection

@section('modales')
@endsection

@section('script_pagina')
    <script src="{{ asset('js/intranet/configuracion/permiso_rol/excepciones.js') }}"></script>
@endsection

@extends('intranet.layout.app')

@section('css_pagina')
@endsection

@section('tituloPagina')
    <i class="fas fa-users mr-3" aria-hidden="true"></i> Configuración Roles
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('rol.index') }}">Roles</a></li>
    <li class="breadcrumb-item active">Roles - Editar</li>
@endsection

@section('titulo_card')
    <i class="fa fa-edit mr-3" aria-hidden="true"></i> Editar Rol
@endsection

@section('botones_card')
    <a href="{{route('rol.index')}}" class="btn btn-success btn-sm btn-sombra text-center pl-5 pr-5 float-md-end" style="font-size: 0.8em;">
        <i class="fas fa-reply mr-2"></i>
        Volver
    </a>
@endsection

@section('cuerpoPagina')
<div class="row d-flex justify-content-center">
    <form class="col-12 col-md-6 form-horizontal" action="{{ route('rol.update',['id'=> $rol_edit->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
        @csrf
        @method('put')
        @include('intranet.config.roles.form')
        <div class="row mt-5">
            <div class="col-12 col-md-6 mb-4 mb-md-0 d-grid gap-2 d-md-block ">
                <button type="submit" class="btn btn-primary btn-sm btn-sombra pl-sm-5 pr-sm-5" style="font-size: 0.8em;">Guardar</button>
            </div>
        </div>
    </form>
</div>
@endsection

@section('footer_card')
@endsection

@section('modales')
@endsection

@section('script_pagina')
<script src="{{ asset('js/intranet/configuracion/roles/crear.js') }}"></script>
@endsection

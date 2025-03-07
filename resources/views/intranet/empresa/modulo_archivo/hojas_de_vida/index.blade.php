<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
@extends('intranet.layout.app')
@section('css_pagina')
@endsection
@section('tituloPagina')
    <i class="far fa-folder-open" aria-hidden="true"></i> Módulo Archivo
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="{{ route('archivo-modulo.index') }}">Módulo Archivo</a></li>
    <li class="breadcrumb-item"><a href="#">Hojas de Vida</a></li>


@endsection
@section('titulo_card')
    Hojas de Vida
@endsection
@section('botones_card')

@endsection
@section('cuerpoPagina')
    @can('hojas_vida.index')
        <div class="row">
            <div class="col-12 col-md-3 form-group">
                <label for="emp_grupo_id">Grupo Empresarial</label>
                @if ($grupos->count()==1)
                    <span class="form-control form-control-sm">{{$grupos[0]->grupo}}</span>
                @else
                    <select id="emp_grupo_id" class="form-control form-control-sm" data_url="{{ route('grupo_empresas.getEmpresas') }}">
                        <option value="">Elija un Grupo Empresarial</option>
                        @foreach ($grupos as $grupo)
                            <option value="{{ $grupo->id }}">{{ $grupo->grupo }}</option>
                        @endforeach
                    </select>
                @endif
            </div>
            <div class="col-12 col-md-3 form-group">
                <label for="empresa_id">Empresa</label>
                @if ($usuario->empleado && $usuario->empleado->empresas_tranv->count()==0)
                    <span class="form-control form-control-sm">{{$usuario->empleado->cargo->area->empresa->empresa}}</span>
                @else
                    @if ($grupos->count()==1 && $prupos[0]->empresas->count()==1)
                        <span class="form-control form-control-sm">{{$grupo[0]->empresas[0]->empresa}}</span>
                    @else
                        @if ($grupos->count()==1)
                            <select id="empresa_id" class="form-control form-control-sm" data_url="{{ route('getUsuariosHojasVida') }}">
                                <option value="">Elija una Empresa</option>
                                @foreach ($grupos[0]->empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->empresa }}</option>
                                @endforeach
                            </select>
                        @else
                            <select id="empresa_id" class="form-control form-control-sm" data_url="{{ route('getUsuariosHojasVida') }}">
                                <option value="">Elija grupo</option>
                            </select>
                        @endif
                    @endif
                @endif
            </div>
        </div>
        <hr>
        <div class="row d-none" id="cajaBusqueda">
            <div class="col-12 col-md-3 form-group">
                <label for="buscartarjetas">Buscar por nombre o apellido</label>
                <input type="text" class="form-control form-control-sm" id="buscartarjetas" data_url="{{route('getFiltrarUsuarioNombre')}}">
            </div>
        </div>
        <br>
        <div class="row d-none" id="newCajaHV">

        </div>
        <input type="hidden" id="folderFotos" value="{{asset('imagenes/usuarios/')}}">
        <input type="hidden" id="hojas_de_vida_editar" data_url="{{route('hojas_vida.hojas_de_vida-editar',['id'=>1])}}">
        <input type="hidden" id="hojas_de_vida_detalles" data_url="{{route('hojas_vida.hojas_de_vida-detalles',['id'=>1])}}">
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
    <script src="{{ asset('js/intranet/empresa/modulo_archivo/hojas_de_vida/index.js') }}"></script>
@endsection

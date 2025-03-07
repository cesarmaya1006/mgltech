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
    <li class="breadcrumb-item"><a href="#">Manuales de funciones</a></li>
@endsection
@section('titulo_card')
<img src="{{asset('imagenes/sistema/4.png')}}" class="img-fluid" alt="..." style="max-height: 35px; width: auto;"> Soportes de Afiliación
@endsection
@section('botones_card')
<a href="{{route('archivo-modulo.index')}}" class="btn btn-success btn-xs mini_sombra pl-5 pr-5 float-md-end" style="font-size: 0.8em;">
    <i class="fas fa-reply mr-2"></i>
    Volver
</a>
@endsection
@section('cuerpoPagina')
    @can('soportes_afiliacion.index')
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
                            <select id="empresa_id" class="form-control form-control-sm" data_url="{{ route('hojas_vida.getCargarEmpleadosEmpresa') }}">
                                <option value="">Elija una Empresa</option>
                                @foreach ($grupos[0]->empresas as $empresa)
                                    <option value="{{ $empresa->id }}">{{ $empresa->empresa }}</option>
                                @endforeach
                            </select>
                        @else
                            <select id="empresa_id" class="form-control form-control-sm" data_url="{{ route('hojas_vida.getCargarEmpleadosEmpresa') }}">
                                <option value="">Elija grupo</option>
                            </select>
                        @endif
                    @endif
                @endif
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 table-responsive" style="font-size: 0.85em;">
                <table class="table display table-striped table-hover table-sm" id="tablaSoportes">
                    <thead>
                        <tr>
                            <th style="white-space:nowrap;" class="text-center" scope="col">Área</th>
                            <th style="white-space:nowrap;" class="text-center" scope="col">Cargo</th>
                            <th style="white-space:nowrap;" class="text-center" scope="col">Empleado</th>
                            <th style="white-space:nowrap;" class="text-center" scope="col">Soportes</th>
                            <th style="white-space:nowrap;" class="text-center" scope="col"></th>
                        </tr>
                    </thead>
                    <tbody id="tbody_soportes">

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
<!-- Modal addManual -->
<div class="modal fade" id="manualModal" tabindex="-1" aria-labelledby="manualModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formManualCargo" class="modal-content form-horizontal" action="{{ route('manuales.addManual') }}" method="POST" autocomplete="off">
            @csrf
            @method('post')
            <div class="modal-header">
                <h1 class="modal-title fs-5" id="manualModalLabel">Asignar manual de funciones al cargo</h1>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12">
                        <input type="hidden" name="id_cargo" id="id_cargo" value="">
                    </div>
                    <div class="col-12 form-group">
                        <label for="manual" class="requerido">Manual</label>
                        <input class="form-control form-control-sm" type="file" name="manual" id="manual" accept="application/pdf" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">Close</button>
                <button type="submit" class="btn btn-primary btn-xs" data-bs-dismiss="modal">Guardar</button>
            </div>
        </form>
    </div>
</div>
<!-- Modal addManual -->
<div class="row">
    <div class="col-12">
        <input type="hidden" id="datosUpLaod"
                data_soportes="{{route('hojas_vida.getSoporteAfiliacion')}}"
                data_url="{{route('hojas_vida.setSoporteAfiliacion')}}"
                ruta_soporte="{{asset('documentos/soportes') . '/'}}">
        <input type="hidden" id="borrarSoportes" data_url="{{route('hojas_vida.eliminarSoporte')}}">
        @csrf
    </div>
</div>

@endsection

@section('script_pagina')
<script src="{{asset('js/intranet/general/popper.min.js')}}"></script>
    @include('intranet.layout.dataTableNew')
    <script src="{{ asset('js/intranet/general/datatablesini.js') }}"></script>
    <script src="{{ asset('js/intranet/empresa/modulo_archivo/soportes_afiliacion/index.js') }}"></script>



@endsection

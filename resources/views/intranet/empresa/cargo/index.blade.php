<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
@extends('intranet.layout.app')
@section('css_pagina')
@endsection
@section('tituloPagina')
    <i class="fas fa-user-tie mr-3" aria-hidden="true"></i> Configuración Cargos
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Cargos</li>
@endsection
@section('titulo_card')
    @if (session('rol_principal_id')== 1)
        Listado de Cargos por Empresas
    @else
        Listado de Cargos
    @endif
@endsection
@section('botones_card')
    @can('cargos.create')
        <a href="{{ route('cargos.create') }}" class="btn btn-primary btn-xs btn-sombra text-center pl-5 pr-5 float-md-end">
            <i class="fa fa-plus-circle mr-3" aria-hidden="true"></i>
            Nuevo registro
        </a>
    @endcan
@endsection
@section('cuerpoPagina')
    @can('cargos.index')
    <div class="row">
        @if (session('rol_principal_id')== 1)
            <div class="col-12 col-md-3 form-group">
                <label for="emp_grupo_id">Grupo Empresarial</label>
                <select id="emp_grupo_id" class="form-control form-control-sm" data_url="{{ route('grupo_empresas.getEmpresas') }}">
                    <option value="">Elija un Grupo Empresarial</option>
                    @foreach ($grupos as $grupo)
                        <option value="{{ $grupo->id }}">
                            {{ $grupo->grupo }}
                        </option>
                    @endforeach
                </select>
            </div>
        @endif
        <div class="col-12 col-md-3 form-group" id="caja_empresas">
            <label for="empresa_id">Empresa</label>
            <select id="empresa_id" class="form-control form-control-sm" data_url="{{ route('cargos.getAreas') }}">
                <option value="">{{session('rol_principal_id')== 1?'Elija un Grupo Empresarial':'Elija empresa'}}</option>
                @if (isset($grupo))
                    @foreach ($grupo->empresas as $empresa)
                        <option value="{{ $empresa->id }}">{{ $empresa->empresa }}</option>
                    @endforeach
                @endif
            </select>
        </div>
        <div class="col-12 col-md-3 form-group" id="caja_empresas">
            <label for="area_id">Área</label>
            <select id="area_id" class="form-control form-control-sm" data_url="{{ route('cargos.getCargos') }}">
                <option value="">Elija una empresa</option>
            </select>
        </div>
    </div>
    <hr>
    <div class="row d-flex justify-content-md-center">
        <input type="hidden" name="titulo_tabla" id="titulo_tabla" value="Listado de Cargos">
        <input type="hidden" id="control_dataTable" value="1">
        <input type="hidden" id="cargos_edit" data_url="{{ route('cargos.edit', ['id' => 1]) }}">
        <input type="hidden" id="cargos_destroy" data_url="{{ route('cargos.destroy', ['id' => 1]) }}">
        <input type="hidden" id="cargos_todos" data_url="{{ route('cargos.getCargosTodos') }}">
        @csrf @method('delete')
        <div class="col-12 col-md-8 table-responsive">
            @csrf
            <table class="table display table-striped table-hover table-sm tabla-borrando tabla_data_table" id="tablaCargos">
                <thead>
                    <tr>
                        <th class="text-center">Id</th>
                        <th class="text-center">Area</th>
                        <th class="text-center">Cargo</th>
                        <td></td>
                    </tr>
                </thead>
                <tbody id="tbody_cargos">

                </tbody>
            </table>
        </div>
    </div>
    @can('cargos.edit')
        <input type="hidden" id="permiso_cargos_edit" value="1">
    @else
        <input type="hidden" id="permiso_cargos_edit" value="0">
    @endcan

    @can('cargos.destroy')
        <input type="hidden" id="permiso_cargos_destroy" value="1">
    @else
        <input type="hidden" id="permiso_cargos_destroy" value="0">
    @endcan
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
    <script src="{{ asset('js/intranet/configuracion/cargos/index.js') }}"></script>
@endsection

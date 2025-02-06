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
        <div class="row">
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
        </div>
        <hr>
        <div class="row" id="caja_tabla_empresas">
            <div class="col-12">
                <div class="col-12">
                    <input type="hidden" name="titulo_tabla" id="titulo_tabla" value="Listado de Grupos Empresariales">
                    <input type="hidden" id="control_dataTable" value="1">
                    <input type="hidden" id="grupo_empresas_edit" data_url="{{ route('empresa.edit', ['id' => 1]) }}">
                    <input type="hidden" id="grupo_empresas_destroy" data_url="{{ route('empresa.destroy', ['id' => 1]) }}">
                    @csrf @method('delete')

                    <div class="col-12">
                        <input type="hidden" name="titulo_tabla" id="titulo_tabla" value="Listado de Grupos Empresariales">
                        <table class="table display table-striped table-hover table-sm  tabla-borrando tabla_data_table" id="tablaEmpresas">
                            <thead>
                                <tr>
                                    <th class="text-center">Id</th>
                                    <th>Identificación</th>
                                    <th>Empresa</th>
                                    <th>Correo Electrónico</th>
                                    <th>Teléfono</th>
                                    <th>Dirección</th>
                                    <th>Contacto</th>
                                    <th>Cargo Contacto</th>
                                    <th>Estado</th>
                                    <td></td>
                                </tr>
                            </thead>
                            <tbody id="tbody_empresas">

                            </tbody>
                        </table>
                    </div>
                </div>
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

    <script src="{{ asset('js/intranet/empresas/empresa/index.js') }}"></script>
@endsection

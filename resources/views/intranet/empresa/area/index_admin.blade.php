<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
@extends('intranet.layout.app')
@section('css_pagina')
@endsection
@section('tituloPagina')
    <i class="fas fa-project-diagram mr-3" aria-hidden="true"></i> Configuración Áreas
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Áreas</li>
@endsection
@section('titulo_card')
    Listado de Areas
@endsection
@section('botones_card')
    @can('areas.create')
        <a href="{{ route('areas.create') }}" class="btn btn-primary btn-xs btn-mini_sombra text-center pl-5 pr-5 float-md-end">
            <i class="fa fa-plus-circle mr-3" aria-hidden="true"></i>
            Nuevo registro
        </a>
    @endcan
@endsection
@section('cuerpoPagina')
    @can('areas.index')
        <div class="row">
            <div class="col-12 col-md-3 form-group">
                <label for="emp_grupo_id">Grupo Empresarial</label>
                <select id="emp_grupo_id" class="form-control form-control-sm" data_url="{{ route('grupo_empresas.getEmpresas') }}">
                    <option value="">Elija un Grupo Empresarial</option>
                    <option value="x">Sin grupo Empresarial</option>
                    @foreach ($grupos as $grupo)
                        <option value="{{ $grupo->id }}">
                            {{ $grupo->grupo }}
                        </option>
                    @endforeach
                </select>
            </div>
            <div class="col-12 col-md-3 form-group d-none" id="caja_empresas">
                <label for="empresa_id">Empresa</label>
                <select id="empresa_id" class="form-control form-control-sm" data_url="{{ route('areas.getAreas') }}">
                    <option value="">Elija grupo</option>
                </select>
            </div>
        </div>
        <hr>
        <div class="row" id="caja_tabla_areas">
            <input type="hidden" name="titulo_tabla" id="titulo_tabla" value="Listado de Áreas">
            <input type="hidden" id="control_dataTable" value="1">
            <input type="hidden" id="areas_edit" data_url="{{ route('areas.edit', ['id' => 1]) }}">
            <input type="hidden" id="areas_destroy" data_url="{{ route('areas.destroy', ['id' => 1]) }}">
            <input type="hidden" id="id_areas_getDependencias" data_url = "{{ route('areas.getDependencias', ['id' => 1]) }}">
            @csrf @method('delete')
            <div class="col-12 table-responsive">
                <table class="table display table-striped table-hover table-sm  tabla-borrando tabla_data_table"
                    id="tablaAreas">
                    <thead>
                        <tr>
                            <th class="text-center">Id</th>
                            <th class="text-center">Area</th>
                            <th class="text-center">Area Superior</th>
                            <th class="text-center">Dependencias</th>
                            <td></td>
                        </tr>
                    </thead>
                    <tbody id="tbody_areas">

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
    <!-- Modales  -->
    <div class="modal fade" id="exampleModal" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="exampleModalLabel">Listado de dependencias</h5>
                </div>
                <div class="modal-body">
                </div>
            </div>
        </div>
    </div>
    <!-- Fin Modales  -->
@endsection

@section('script_pagina')
    @include('intranet.layout.dataTableNew')
    <script src="{{ asset('js/intranet/general/datatablesini.js') }}"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.29.2/moment.min.js"></script>
    <script src="{{ asset('js/intranet/configuracion/areas/index_admin.js') }}"></script>
@endsection

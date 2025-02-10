<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
@extends('intranet.layout.app')
@section('css_pagina')
@endsection
@section('tituloPagina')
    <i class="far fa-folder-open" aria-hidden="true"></i> Módulo Archivo
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
    <li class="breadcrumb-item"><a href="#">Módulo Archivo</a></li>
@endsection
@section('titulo_card')
    Hojas de Vida
@endsection
@section('botones_card')
    @can('empresa.create')

    @endcan
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
        <div class="row d-flex justify-content-md-center">
            <div class="col-12 table-responsive">
                <table class="table table-striped table-hover table-sm tabla_data_table_m tabla-borrando" id="tabla-data">
                    <tbody>
                        @if ($usuario->empleado && $usuario->empleado->empresas_tranv->count()==0)
                            @can('ver_todas_hojas_de_vida')
                                @foreach ($empleado->cargo->area->empresa->areas as $area)
                                    @foreach ($area->cargos as $cargo)
                                        @foreach ($cargo->empleados as $empleado)
                                            <tr>
                                                <td>
                                                    <div class="card card-widget widget-user shadow">
                                                        <div class="widget-user-header bg-info">
                                                            <h6 class="widget-user-username">
                                                                {{ $empleado->usuario->nombres . ' ' . $empleado->usuario->apellidos }}
                                                            </h6>
                                                            <p class="widget-user-desc">{{ $empleado->cargo->cargo }}</p>
                                                        </div>
                                                        <div class="widget-user-image">
                                                            <img class="img-circle elevation-4"
                                                                src="{{ asset('imagenes/hojas_de_vida/' . $empleado->foto) }}"
                                                                alt="{{ $empleado->usuario->nombres . ' ' . $empleado->usuario->apellidos }}">
                                                        </div>
                                                        <div class="card-footer">
                                                            <div class="row d-flex justify-content-md-center">
                                                                <div class="col-sm-2 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">Identificación</h5>
                                                                        <span
                                                                            class="description-text">{{ $empleado->usuario->identificacion }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">Teléfono</h5>
                                                                        <span
                                                                            class="description-text">{{ $empleado->usuario->telefono }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">Email</h5>
                                                                        <span
                                                                            class="description-text text-lowercase text-nowrap">{{ $empleado->usuario->email }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-2 border-right">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">Vinculación</h5>
                                                                        <span
                                                                            class="description-text text-lowercase text-nowrap">{{ $empleado->vinculacion }}</span>
                                                                    </div>
                                                                </div>
                                                                <div class="col-sm-3">
                                                                    <div class="description-block">
                                                                        <h5 class="description-header">Opciones</h5>
                                                                        <span
                                                                            class="description-text d-flex justify-content-md-between mt-2">
                                                                            <a href="{{ route('hojas_de_vida-editar', ['id' => $empleado->id]) }}"
                                                                                class="btn btn-primary pl-1 pr-1 btn-xs btn-sombra"><i
                                                                                    class="fa fa-edit mr-1" aria-hidden="true"></i>
                                                                                Editar</a>
                                                                            <a href="{{ route('hojas_de_vida-detalles', ['id' => $empleado->id]) }}"
                                                                                class="btn btn-info pl-1 pr-1 btn-xs btn-sombra"><i
                                                                                    class="fa fa-eye mr-1" aria-hidden="true"></i>
                                                                                Detalles</a>
                                                                        </span>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </td>
                                            </tr>
                                        @endforeach
                                    @endforeach
                                @endforeach
                            @else
                                <tr>
                                    <td>
                                        <div class="card card-widget widget-user shadow">
                                            <div class="widget-user-header bg-info">
                                                <h6 class="widget-user-username">
                                                    {{ $usuario->empleado->usuario->nombres . ' ' . $usuario->empleado->usuario->apellidos }}
                                                </h6>
                                                <p class="widget-user-desc">{{ $usuario->empleado->cargo->cargo }}</p>
                                            </div>
                                            <div class="widget-user-image">
                                                <img class="img-circle elevation-4"
                                                    src="{{ asset('imagenes/hojas_de_vida/' . $usuario->empleado->foto) }}"
                                                    alt="{{ $usuario->empleado->usuario->nombres . ' ' . $usuario->empleado->usuario->apellidos }}">
                                            </div>
                                            <div class="card-footer">
                                                <div class="row d-flex justify-content-md-center">
                                                    <div class="col-sm-2 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header">Identificación</h5>
                                                            <span
                                                                class="description-text">{{ $usuario->empleado->usuario->identificacion }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header">Teléfono</h5>
                                                            <span
                                                                class="description-text">{{ $usuario->empleado->usuario->telefono }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header">Email</h5>
                                                            <span
                                                                class="description-text text-lowercase text-nowrap">{{ $usuario->empleado->usuario->email }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-2 border-right">
                                                        <div class="description-block">
                                                            <h5 class="description-header">Vinculación</h5>
                                                            <span
                                                                class="description-text text-lowercase text-nowrap">{{ $usuario->empleado->vinculacion }}</span>
                                                        </div>
                                                    </div>
                                                    <div class="col-sm-3">
                                                        <div class="description-block">
                                                            <h5 class="description-header">Opciones</h5>
                                                            <span
                                                                class="description-text d-flex justify-content-md-between mt-2">
                                                                <a href="{{ route('hojas_de_vida-editar', ['id' => $usuario->empleado->id]) }}"
                                                                    class="btn btn-primary pl-1 pr-1 btn-xs btn-sombra"><i
                                                                        class="fa fa-edit mr-1"
                                                                        aria-hidden="true"></i>
                                                                    Editar</a>
                                                                <a href="{{ route('hojas_de_vida-detalles', ['id' => $usuario->empleado->id]) }}"
                                                                    class="btn btn-info pl-1 pr-1 btn-xs btn-sombra"><i
                                                                        class="fa fa-eye mr-1"
                                                                        aria-hidden="true"></i>
                                                                    Detalles</a>
                                                            </span>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            @endcan
                        @else
                            <tbody id="tbody_hojas_de_vida">

                            </tbody>
                        @endif
                    </tbody>
                </table>
                <input type="hidden" id="folderFotos" value="{{asset('imagenes/hojas_de_vida/')}}">
                <input type="hidden" id="hojas_de_vida_editar" data_url="{{route('hojas_vida.hojas_de_vida-editar',['id'=>1])}}">
                <input type="hidden" id="hojas_de_vida_detalles" data_url="{{route('hojas_vida.hojas_de_vida-detalles',['id'=>1])}}">
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
    <script src="{{ asset('js/intranet/empresa/modulo_archivo/hojas_de_vida/index.js') }}"></script>
@endsection

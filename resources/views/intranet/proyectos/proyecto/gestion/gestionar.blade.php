<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
@extends('intranet.layout.app')

@section('css_pagina')
<link rel="stylesheet" href="{{asset('css/intranet/general/ninja/jquery-ui.min.css')}}">
<link rel="stylesheet" href="{{asset('css/intranet/proyectos/gestionar.css')}}">
@endsection
@section('tituloPagina')
    <i class="fas fa-project-diagram mr-3" aria-hidden="true"></i> Módulo de Proyectos
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proyectos.index') }}">Proyectos</a></li>
    <li class="breadcrumb-item active">Gestión</li>
@endsection
@section('titulo_card')
    Gestión Proyecto - {{ $proyecto->titulo }}
@endsection
@section('botones_card')
<a href="{{ route('proyectos.index') }}" type="button" class="btn btn-primary btn-xs btn-sombra pl-5 pr-5 float-md-end">
    <i class="fas fa-reply mr-2 ml-3"></i><span class="pr-4">Volver</span>
</a>
@endsection
@section('cuerpoPagina')
    @if (session('rol_principal_id') == 1 || $proyecto->empleado_id == session('id_usuario') || auth()->user()->hasPermissionTo('proyectos.gestion'))
        @can('proyectos.gestion')
            <div class="row">
                <div class="col-12">
                    <div class="row mb-3">
                        <div class="col-12">
                            <h6><strong>Datos de proyecto</strong></h6>
                        </div>
                    </div>
                    <div class="row" style="font-size: 0.9em">
                        <div class="col-12 col-md-5">
                            <div class="row">
                                <div class="col-5 text-right"><strong>Lider del proyecto:</strong></div>
                                <div class="col-7">{{ $proyecto->lider->nombres . ' ' . $proyecto->lider->apellidos }}
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="row">
                                <div class="col-5 col-md-3 text-right"><strong>Objetivo principal:</strong></div>
                                <div class="col-7 col-md-9 text-justify">{{ $proyecto->objetivo }}</div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="font-size: 0.9em">
                        <div class="col-12 col-md-5">
                            <div class="row">
                                <div class="col-5 text-right"><strong>Fecha de creación:</strong></div>
                                <div class="col-7">{{ $proyecto->fec_creacion }}</div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="row">
                                <div class="col-5 col-md-3 text-right"><strong>Estado:</strong></div>
                                <div class="col-7 col-md-9 text-capitalize"><span
                                        class="badge {{ $proyecto->estado == 'activo' ? 'badge-success' : ($proyecto->estado == 'extendido' ? 'badge-danger' : ($proyecto->estado == 'cerrado' ? 'badge-secondary' : 'badge-info')) }} pl-4 pr-4"><strong>{{ $proyecto->estado }}</strong></span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="row" style="font-size: 0.9em">
                        <div class="col-12 col-md-5">
                            <div class="row">
                                <div class="col-5 text-right"><strong>Progreso:</strong></div>
                                <div class="col-7">
                                    <?php
                                    switch ($proyecto->progreso) {
                                        case 0:
                                            $color = 'indigo';
                                            break;
                                        case $proyecto->progreso <= 25:
                                            $color = 'navy';
                                            break;
                                        case $proyecto->progreso <= 50:
                                            $color = 'dodgerblue';
                                            break;
                                        case $proyecto->progreso <= 75:
                                            $color = 'aquamarine';
                                            break;
                                        default:
                                            $color = 'lime';
                                            break;
                                    }
                                    $porcentaje1 = $proyecto->progreso;
                                    $porcentaje2 = 100 - $porcentaje1;
                                    $red = 0;
                                    $green = ($porcentaje1 * 255) / 100;
                                    $blue = ($porcentaje2 * 255) / 100;
                                    ?>

                                    <div class="col-8" style="color: {{ $color }}">
                                        {{ number_format($proyecto->progreso, 2, ',', '.') }} %
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-12 col-md-7">
                            <div class="row">
                                <div class="col-5 col-md-3 text-right"><strong>Tiempo gestión:</strong></div>
                                <div class="col-7 col-md-9">
                                    <?php
                                    $date1 = new DateTime($proyecto->fec_creacion);
                                    $date2 = new DateTime(Date('Y-m-d'));
                                    $diff = date_diff($date1, $date2);
                                    $differenceFormat = '%a';
                                    ?>
                                    <strong>{{ $diff->format($differenceFormat) }} días</strong>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if ($proyecto->presupuesto > 0 && (session('rol_principal_id') == 1 || $proyecto->empleado_id == session('id_usuario') || auth()->user()->hasPermissionTo('caja_presupuestos')))
                        @can('caja_presupuestos')
                            <hr>
                            <div class="row" style="font-size: 0.9em" id="caja_presupuestos">
                                <div class="col-12 col-md-4">
                                    @if ($proyecto->adiciones->count() > 0)
                                        <div class="row">
                                            <div class="col-7 col-md-8 text-right"><strong>Presupuesto total del proyecto:</strong></div>
                                            <div class="col-5 col-md-4 text-right text-md-left">
                                                {{ '$ ' . number_format($proyecto->presupuesto + $proyecto->adiciones->sum('adicion'), 2, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 col-md-8 text-right"><strong>Presupuesto inicial del proyecto:</strong></div>
                                            <div class="col-5 col-md-4 text-right text-md-left">
                                                {{ '$ ' . number_format($proyecto->presupuesto, 2, ',', '.') }}
                                            </div>
                                        </div>
                                        <div class="row">
                                            <div class="col-7 col-md-8 text-right"><strong>Adiciones al presupuesto del proyecto:</strong></div>
                                            <div class="col-5 col-md-4 text-right text-md-left">
                                                {{ '$ ' . number_format($proyecto->adiciones->sum('adicion'), 2, ',', '.') }}
                                            </div>
                                        </div>
                                    @else
                                        <div class="row">
                                            <div class="col-7 col-md-8 text-right"><strong>Presupuesto total del proyecto:</strong></div>
                                            <div class="col-5 col-md-4 text-right text-md-left">
                                                {{ '$ ' . number_format($proyecto->presupuesto, 2, ',', '.') }}
                                            </div>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="col-8 col-md-8 text-right"><strong>Ejecución del presupuesto:</strong></div>
                                        <div class="col-4 col-md-4">{{ '$ ' . number_format($proyecto->ejecucion, 2, ',', '.') }}</div>
                                    </div>
                                </div>
                                <div class="col-12 col-md-4">
                                    <div class="row">
                                        <div class="col-8 col-md-9 text-right"><strong>Porcentaje de ejecución:</strong></div>
                                        <div class="col-4 col-md-3">{{ number_format($proyecto->porc_ejecucion, 2, ',', '.') }} %</div>
                                    </div>
                                </div>
                            </div>
                        @endcan
                    @endif
                    @if (session('rol_principal_id') == 1 || $proyecto->usuario_id == session('id_usuario') || auth()->user()->hasPermissionTo('exportar_proyecto')|| auth()->user()->hasPermissionTo('proyectos.edit'))
                        <hr>
                        <div class="row">
                        <div class="col-12 d-grid gap-2 d-md-block">
                                @can('exportar_proyecto')
                                    <a href="{{ route('proyectos.expotar_informeproyecto', ['id' => $proyecto->id]) }}" target="_blank"
                                        class="btn btn-success btn-xs btn-sombra pl-md-3 pr-md-5 mb-3 mb-md-0 mr-md-3 float-md-end">
                                        <i class="fas fa-file-download mr-3 ml-md-2" aria-hidden="true"></i><span class="mr-md-3">Exportar Informe</span>
                                    </a>
                                @endcan
                                @can('proyectos.edit')
                                    <a href="{{ route('proyectos.edit', ['id' => $proyecto->id]) }}"
                                        class="btn btn-warning btn-xs btn-sombra pl-md-3 pr-md-5 mb-3 mb-md-0 mr-md-3 float-md-end">
                                        <i class="fas fa-edit mr-3 ml-md-2" aria-hidden="true"></i><span class="mr-md-3">Editar Proyecto</span>
                                    </a>
                                @endcan
                            </div>
                        </div>
                    @endif
                </div>
            </div>
            <hr>
            <div class="row" style="background-color: rgba(0, 0, 0, 0.05)">
                @if (session('rol_principal_id') == 1 || $proyecto->empleado_id == session('id_usuario') || auth()->user()->hasPermissionTo('personal_asignado_proyecto'))
                    @can('personal_asignado_proyecto')
                        <div class="col-12 col-md-6 pt-3 pl-md-2 pr-md-2">
                            <div class="card card-outline card-teal collapsed-card">
                                <div class="card-header">
                                    <div class="row">
                                        <div class="col-11">
                                            <div class="row">
                                                <div class="col-12 col-md-7">
                                                    <h6 class="card-title" style="font-size: 0.98em;"><strong>Personal asignado al proyecto</strong></h6>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-1">
                                            <div class="card-tools float-end">
                                                <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                    <i class="fas fa-plus"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="card-body table-responsive" style="display: none;font-size: 0.9em;">
                                    <table class="table-hover table-sm">
                                        <tbody>
                                            @foreach ($proyecto->miembros_proyecto as $usuario)
                                                <tr>
                                                    <th scope="row">{{ $usuario->nombres . ' ' . $usuario->apellidos }}</th>
                                                    <td class="pl-4">{{ $usuario->cargo->cargo }}</td>
                                                    <td class="pl-4">
                                                        {{ $usuario->cargo->area->empresa_id != $proyecto->empresa_id ? $usuario->cargo->area->empresa->nombres : '' }}
                                                        {{ $usuario->id == $proyecto->lider->id ? ' * Líder del Proyecto' : '' }}
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    @endcan
                @endif
                @if (session('rol_principal_id') == 1 || $proyecto->empleado_id == session('id_usuario') || auth()->user()->hasPermissionTo('tareas_vec_gestion_proyecto'))
                    <div class="col-12 col-md-6 pt-3 pl-md-2 pr-md-2">
                        <div class="card card-outline card-teal collapsed-card">
                            <div class="card-header">
                                <div class="row">
                                    <div class="col-11">
                                        <div class="row">
                                            <div class="col-12 col-md-7">
                                                <h6 class="card-title" style="font-size: 0.98em;"><strong>Tareas Vencidas</strong></h6>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-1">
                                        <div class="card-tools float-end">
                                            <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                                <i class="fas fa-plus"></i>
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body table-responsive" style="display: none;font-size: 0.9em;">
                                <table class="table table-striped table-hover table-sm tabla_data_table_m" id="tabla_tareas_vencidas">
                                    <thead>
                                        <tr>
                                            <th scope="col" class="text-nowrap pl-2 pr-3">Responsable</th>
                                            <th scope="col" class="text-nowrap pl-2 pr-3">Componente</th>
                                            <th scope="col" class="text-nowrap pl-2 pr-3">Nombre De La Tarea</th>
                                            <th scope="col" class="text-nowrap pl-2 pr-3">Fecha Límite</th>
                                            <th scope="col" class="text-nowrap pl-2 pr-3">Progreso</th>
                                            <th scope="col" class="text-nowrap pl-2 pr-3">Estado</th>
                                            <th scope="col" class="text-nowrap pl-2 pr-3">Gestionar</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($proyecto->componentes as $componente)
                                            @if (session('rol_principal_id') == 1 || $proyecto->empleado_id == session('id_usuario') || auth()->user()->hasPermissionTo('tareas_vec_gestion_proyecto_todas'))
                                                @php
                                                    $tareas = $componente->tareas;
                                                @endphp
                                            @else
                                                @php
                                                    $tareas = $componente->tareas->where('empleado_id',session('id_usuario'));
                                                @endphp
                                            @endif
                                            @foreach ($tareas as $tarea)
                                                @if ($tarea->fec_limite < date('Y-m-d'))
                                                    <tr>
                                                        <th scope="row" class="text-nowrap">
                                                            {{ $tarea->empleado->nombres . ' ' . $tarea->empleado->apellidos }}</th>
                                                        <td class=".w-td-350 text-wrap">{{ $componente->titulo }}</td>
                                                        <td>{{ $tarea->titulo }}</td>
                                                        <td>{{ $tarea->fec_limite }}</td>
                                                        <td class="w-td-250">
                                                            <div class="progress">
                                                                <div class="progress-bar progress-bar-striped" role="progressbar" style="width: {{ ($tarea->progreso * 360) / 100 }}%" aria-valuenow="{{ ($tarea->progreso * 360) / 100 }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </td>
                                                        <td class="text-danger">{{ $tarea->estado }}</td>
                                                        <td style=" white-space: nowrap;">
                                                            <a href="#" type="button"
                                                                class="btn btn-primary btn-xs btn-sombra pl-5 pr-5 float-md-end">
                                                                <i class="fas fa-edit mr-2 ml-3"></i><span
                                                                    class="pr-4">Gestionar</span>
                                                            </a>
                                                        </td>
                                                    </tr>
                                                @endif
                                            @endforeach
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                @endif
            </div>
            <hr>
            <div class="row" style="background-color: rgba(0, 0, 0, 0.05)">
                <div class="col-12 card card-outline card-dark collapsed-card">
                    <div class="card-header pb-3">
                        <div class="row">
                            <div class="col-11">
                                <div class="row">
                                    <div class="col-12 col-md-8">
                                        <h6 class="card-title" style="font-size: 0.98em;"><strong>Componentes del proyecto</strong></h6>
                                    </div>
                                    <div class="col-12 col-md-4 mt-3 mt-md-0 d-grid gap-2 d-md-block">
                                        @if (session('rol_principal_id') == 1 || $proyecto->empleado_id == session('id_usuario') || auth()->user()->hasPermissionTo('componentes.create'))
                                            <a href="{{ route('componentes.create', ['proyecto_id' => $proyecto->id]) }}"
                                                type="button" class="btn btn-primary btn-xs btn-sombra pl-5 pr-5 float-md-end">
                                                <i class="fas fa-plus-circle mr-2 ml-3"></i><span class="pr-4">Nuevo componente</span>
                                            </a>
                                        @endif
                                    </div>
                                </div>
                            </div>
                            <div class="col-1">
                                <div class="card-tools float-end">
                                    <button type="button" class="btn btn-tool" data-card-widget="collapse">
                                        <i class="fas fa-plus"></i>
                                    </button>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="card-body pt-3" style="font-size: 0.9em;">
                        @if ($proyecto->componentes->count() > 0)
                            <div class="row">
                                <div class="col-12">
                                    <div class="box-content">
                                        <!-- /.dropdown js__dropdown -->
                                        <div id="accordion" class="js__ui_accordion ui-accordion ui-widget ui-helper-reset" role="tablist">
                                            @foreach ($proyecto->componentes as $componente)
                                                @if (session('rol_principal_id') == 1 ||
                                                    $proyecto->empleado_id == session('id_usuario') ||
                                                    auth()->user()->hasPermissionTo('gestion_ver_componentes_info')||
                                                    $componente->empleado_id==session('id_usuario'))
                                                    @can('gestion_ver_componentes_info')
                                                        <!--    Componentes    -->
                                                        <h3 class="accordion-title ui-accordion-header ui-corner-top ui-accordion-header-collapsed ui-corner-all ui-state-default ui-accordion-icons" role="tab" id="ui-id-{{$componente->id}}" aria-controls="componente_info_{{$componente->id}}" aria-selected="false" aria-expanded="false" tabindex="0">
                                                            <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-e"></span>
                                                            {{$componente->titulo}}
                                                        </h3>
                                                        <div class="accordion-content ui-accordion-content ui-corner-bottom ui-helper-reset ui-widget-content" style="display: none;" id="componente_info_{{$componente->id}}" aria-labelledby="ui-id-{{$componente->id}}" role="tabpanel" aria-hidden="true">
                                                            <div class="row datos_componente datos_componente-md">
                                                                <div class="col-12 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right"><strong>Responsable:</strong></div>
                                                                        <div class="col-8">
                                                                            {{ $componente->responsable->nombres . ' ' . $componente->responsable->apellidos }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 text-right"><strong>Cargo:</strong></div>
                                                                        <div class="col-8">
                                                                            {{ $componente->responsable->cargo->cargo }}
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 text-right"><strong>Fecha de creación:</strong></div>
                                                                        <div class="col-8">{{ $componente->fec_creacion }}</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 text-right"><strong>Estado:</strong></div>
                                                                        <div class="col-8">{{ $componente->estado }}</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 text-right"><strong>Impacto:</strong></div>
                                                                        <div class="col-8">{{ $componente->impacto }}</div>
                                                                    </div>
                                                                </div>
                                                                <div class="col-12 col-md-6">
                                                                    <div class="row">
                                                                        <div class="col-4 text-right"><strong>Porcentaje de avance:</strong>
                                                                        </div>
                                                                        <div class="col-8">
                                                                            {{ number_format(doubleval($componente->progreso), 2, ',', '.') }}
                                                                            %</div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-4 text-right"><strong>Objetivo:</strong></div>
                                                                        <div class="col-8">
                                                                            <p class="text-justify">{{ $componente->objetivo }}</p>
                                                                        </div>
                                                                    </div>
                                                                    <div class="row">
                                                                        <div class="col-12">
                                                                            @if ( (session('rol_principal_id') == 1 ||
                                                                                $proyecto->empleado_id == session('id_usuario') ||
                                                                                $componente->empleado_id == session('id_usuario'))
                                                                                && auth()->user()->hasPermissionTo('componentes.edit')
                                                                            )
                                                                            <a href="{{ route('componentes.edit', ['id' => $componente->id]) }}"
                                                                                class="btn btn-warning btn-xs btn-sombra pl-md-3 pr-md-5 mb-3 mb-md-0 mr-md-3 float-md-end">
                                                                                <i class="fas fa-edit mr-3 ml-md-2" aria-hidden="true"></i><span class="mr-md-3">Editar Componente</span>
                                                                            </a>
                                                                            @endif
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            @if ($proyecto->presupuesto > 0 &&
                                                            (session('rol_principal_id') == 1 ||
                                                            $proyecto->empleado_id == session('id_usuario') ||
                                                            auth()->user()->hasPermissionTo('ver_presupuesto_componentes')
                                                            ))
                                                                <hr>
                                                                <div class="row datos_componente datos_componente-md">
                                                                    <div class="col-12 col-md-5">
                                                                        @if ($componente->adiciones->count() > 0)
                                                                            <div class="row">
                                                                                <div class="col-7 col-md-5 text-right"><strong>Presupuesto total del Componente:</strong></div>
                                                                                <div class="col-5 col-md-7 text-right text-md-left">
                                                                                    {{ '$ ' . number_format($componente->presupuesto + $componente->adiciones->sum('adicion'), 2, ',', '.') }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-7 col-md-5 text-right"><strong>Presupuesto inicial del Componente:</strong></div>
                                                                                <div class="col-5 col-md-7 text-right text-md-left">
                                                                                    {{ '$ ' . number_format($componente->presupuesto, 2, ',', '.') }}
                                                                                </div>
                                                                            </div>
                                                                            <div class="row">
                                                                                <div class="col-7 col-md-5 text-right"><strong>Adiciones al presupuesto del Componente:</strong></div>
                                                                                <div class="col-5 col-md-7 text-right text-md-left">
                                                                                    {{ '$ ' . number_format($componente->adiciones->sum('adicion'), 2, ',', '.') }}
                                                                                </div>
                                                                            </div>
                                                                        @else
                                                                            <div class="row">
                                                                                <div class="col-7 col-md-5 text-right"><strong>Presupuesto total del Componente:</strong></div>
                                                                                <div class="col-5 col-md-7 text-right text-md-left">
                                                                                    {{ '$ ' . number_format($componente->presupuesto, 2, ',', '.') }}
                                                                                </div>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                    <div class="col-12 col-md-4">
                                                                        <div class="row">
                                                                            <div class="col-7 col-md-5 text-right"><strong>Ejecución del presupuesto:</strong></div>
                                                                            <div class="col-5 col-md-7 text-right text-md-left">
                                                                                {{ '$ ' . number_format($componente->ejecucion, 2, ',', '.') }}
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <div class="col-12 col-md-3">
                                                                        <div class="row">
                                                                            <div class="col-7 col-md-5 text-right"><strong>Porcentaje de ejecución:</strong></div>
                                                                            <div class="col-5 col-md-7 text-right text-md-left">
                                                                                {{ number_format($componente->porc_ejecucion, 2, ',', '.') }} %
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                            <hr>
                                                            <div class="row mb-2 w-100">
                                                                <div class="col-12">
                                                                    <div class="row">
                                                                        <div class="col-12 col-md-6">
                                                                            <strong>Tareas</strong>
                                                                        </div>
                                                                        @if ( session('rol_principal_id') == 1 ||
                                                                            auth()->user()->hasPermissionTo('tareas.create')||
                                                                            $proyecto->empleado_id == session('id_usuario') ||
                                                                            $componente->empleado_id==session('id_usuario')
                                                                            )
                                                                            <div class="col-12 col-md-6 d-grid gap-2 d-md-block">
                                                                                <a href="{{ route('tareas.create', ['componente_id' => $componente->id]) }}"
                                                                                    type="button"
                                                                                    class="btn bg-success btn-xs btn-sombra pl-5 pr-5 float-md-end">
                                                                                    <i class="fas fa-plus-circle mr-2 ml-3"></i><span class="pr-4">Nueva Tarea</span>
                                                                                </a>
                                                                            </div>
                                                                        @endif
                                                                    </div>
                                                                </div>
                                                            </div>
                                                            <hr>
                                                            @if ($componente->tareas->count() > 0)
                                                                @if (
                                                                    session('rol_principal_id') == 1 ||
                                                                    auth()->user()->hasPermissionTo('ver_tareas_componentes')||
                                                                    $proyecto->empleado_id == session('id_usuario') ||
                                                                    $componente->empleado_id==session('id_usuario') ||
                                                                    $componente->tareas->where('empleado_id',session('id_usuario')->count() > 0)
                                                                )
                                                                    <div class="row mb-2 w-100">
                                                                        <div class="col-12 d-flex flex-column flex-md-row">
                                                                            @if (session('rol_principal_id') == 1 ||
                                                                            auth()->user()->hasPermissionTo('tareas.gestion')||
                                                                            $proyecto->empleado_id == session('id_usuario') ||
                                                                            $componente->empleado_id==session('id_usuario')||
                                                                            $tarea->empleado_id==session('id_usuario'))
                                                                                @php
                                                                                    $permiso_ver_tareas = true;
                                                                                @endphp
                                                                            @else
                                                                                @php
                                                                                    $permiso_ver_tareas = false;
                                                                                @endphp
                                                                            @endif
                                                                            <div class="form-check mr-md-3 mb-2 mb-md-0">
                                                                                <input class="form-check-input check_tabla_tarea check_tabla_tarea_{{$componente->id}}" type="checkbox" value="Todas"
                                                                                    id="check_Todas"
                                                                                    data_url="{{ route('tareas.getapitareas', ['componente_id' => $componente->id, 'estado' => 'Todas']) }}"
                                                                                    data_componente_id="{{$componente->id}}"
                                                                                    data_permiso_ver_tareas ="{{$permiso_ver_tareas}}">
                                                                                <label class="form-check-label" for="check_Todas">Todas</label>
                                                                            </div>
                                                                            <div class="form-check mr-md-3 mb-2 mb-md-0">
                                                                                <input class="form-check-input check_tabla_tarea check_tabla_tarea_{{$componente->id}}" type="checkbox" value="Activa"
                                                                                    id="check_Activas"
                                                                                    data_url="{{ route('tareas.getapitareas', ['componente_id' => $componente->id, 'estado' => 'Activa']) }}"
                                                                                    data_componente_id="{{$componente->id}}"
                                                                                    data_permiso_ver_tareas ="{{$permiso_ver_tareas}}"
                                                                                    checked>
                                                                                <label class="form-check-label" for="check_Activas">Activas</label>
                                                                            </div>
                                                                            <div class="form-check mr-md-3 mb-2 mb-md-0">
                                                                                <input class="form-check-input check_tabla_tarea check_tabla_tarea_{{$componente->id}}" type="checkbox" value="Inactiva"
                                                                                    id="check_Inactivas"
                                                                                    data_url="{{ route('tareas.getapitareas', ['componente_id' => $componente->id, 'estado' => 'Inactiva']) }}"
                                                                                    data_componente_id="{{$componente->id}}"
                                                                                    data_permiso_ver_tareas ="{{$permiso_ver_tareas}}">
                                                                                <label class="form-check-label" for="check_Inactivas">Inactivas</label>
                                                                            </div>
                                                                            <div class="form-check mr-md-3 mb-2 mb-md-0">
                                                                                <input class="form-check-input check_tabla_tarea check_tabla_tarea_{{$componente->id}}" type="checkbox" value="Cerrada"
                                                                                    id="check_Cerradas"
                                                                                    data_url="{{ route('tareas.getapitareas', ['componente_id' => $componente->id, 'estado' => 'Cerrada']) }}"
                                                                                    data_componente_id="{{$componente->id}}"
                                                                                    data_permiso_ver_tareas ="{{$permiso_ver_tareas}}">
                                                                                <label class="form-check-label" for="check_Cerradas">Cerradas</label>
                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                    <br>
                                                                    <div class="row">
                                                                        <div class="col-12 table-responsive">
                                                                            <table class="table table-striped table-hover table-sm tabla_data_table_m tabla_tareas_componente nowrap display w-100" id="tabla_tareas_componente_{{ $componente->id }}" style="width:100%">
                                                                                <thead class="w-100">
                                                                                    <tr>
                                                                                        <th class="text-center">Ver</th>
                                                                                        <th class="text-center" scope="col">Responsable</th>
                                                                                        <th class="text-center" scope="col">Titulo</th>
                                                                                        <th class="text-center" scope="col">Fecha de creación</th>
                                                                                        <th class="text-center" scope="col">Fecha límite</th>
                                                                                        <th class="text-center" scope="col">Progreso</th>
                                                                                        <th class="text-center" scope="col">Estado</th>
                                                                                        <th class="text-center" scope="col">Impacto</th>
                                                                                        <th class="text-center" scope="col">Objetivo</th>
                                                                                    </tr>
                                                                                </thead>
                                                                                <tbody class="w-100" id="tbody_{{ $componente->id }}">
                                                                                    @if (session('rol_principal_id') == 1 ||
                                                                                        auth()->user()->hasPermissionTo('ver_tareas_componentes')||
                                                                                        $proyecto->empleado_id == session('id_usuario') ||
                                                                                        $componente->empleado_id==session('id_usuario'))
                                                                                        @php
                                                                                            $tareas = $componente->tareas;
                                                                                        @endphp
                                                                                    @else
                                                                                        @php
                                                                                            $tareas = $componente->tareas->where('empleado_id',session('id_usuario'));
                                                                                        @endphp
                                                                                    @endif
                                                                                    @foreach ($tareas->where('estado', 'Activa') as $tarea)
                                                                                        <tr>
                                                                                            <td class="text-center">
                                                                                                @if (session('rol_principal_id') == 1 ||
                                                                                                    auth()->user()->hasPermissionTo('tareas.gestion')||
                                                                                                    $proyecto->empleado_id == session('id_usuario') ||
                                                                                                    $componente->empleado_id==session('id_usuario')||
                                                                                                    $tarea->empleado_id==session('id_usuario'))
                                                                                                    <a href="{{ route('tareas.gestion', ['id' => $tarea->id]) }}"
                                                                                                        class="btn-accion-tabla text-primary"
                                                                                                        title="Gestionar tarea"><i
                                                                                                            class="fas fa-eye mr-2"></i></a>
                                                                                                @else
                                                                                                <span class="btn-accion-tabla text-primary" title="Gestionar tarea">
                                                                                                    <i class="fas fa-eye-slash"></i>
                                                                                                </span>
                                                                                                @endif
                                                                                            </td>
                                                                                            <td style="white-space:nowrap;">{{ ucfirst(strtolower($tarea->empleado->nombres)) . ' ' . ucfirst(strtolower($tarea->empleado->apellidos)) }}</td>
                                                                                            <td style="white-space:nowrap;">{{ $tarea->titulo }}</td>
                                                                                            <td class="text-center" style="white-space:nowrap;">{{ $tarea->fec_creacion }}</td>
                                                                                            <td class="text-center" style="white-space:nowrap;">{{ $tarea->fec_limite }}</td>
                                                                                            <td class="text-center" style="white-space:nowrap;">
                                                                                                <span>{{ $tarea->progreso }} %</span>
                                                                                                <div class="progress">
                                                                                                    <div class="progress-bar" role="progressbar" style="width: {{ $tarea->progreso }} %;" aria-valuenow="{{ $tarea->progreso }}" aria-valuemin="0" aria-valuemax="100"></div>
                                                                                                </div>
                                                                                            </td>
                                                                                            <td class="text-center" style="white-space:nowrap;"><span class="bg-{{ $tarea->estado == 'Activa'?'success':($tarea->estado == 'Completa'?'secondary':'') }} pl-3 pr-3 " style="font-size: 0.85em;">{{$tarea->estado}}</span></td>
                                                                                            <td class="text-center" style="white-space:nowrap;">{{ $tarea->impacto }}</td>
                                                                                            <td width="25%"><p class="text-wrap" style="text-align: justify;width: 250px;">{{ $tarea->objetivo }}</p></td>
                                                                                        </tr>
                                                                                    @endforeach
                                                                                </tbody>
                                                                            </table>
                                                                        </div>
                                                                    </div>
                                                                @endif
                                                            @else
                                                                <div class="row mb-2 w-100">
                                                                    <div class="col-12 text-center">
                                                                        <h4>Componente sin tareas</h4>
                                                                    </div>
                                                                </div>
                                                            @endif
                                                        </div>
                                                    @endcan
                                                @endif
                                            @endforeach
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @else
                            <div class="row">
                                <div class="col-12">
                                    <h6><strong>Sin Componentes</strong></h6>
                                </div>
                            </div>
                        @endif
                    </div>
                </div>
            </div>
        @endcan
    @else
        <div class="row d-flex justify-content-center">
            <div class="col-12 col-md-6">
                <div class="alert alert-warning alert-dismissible mini_sombra">
                    <button type="button" class="close" data-dismiss="alert" aria-hidden="true">×</button>
                    <h5><i class="icon fas fa-exclamation-triangle"></i> Sin Acceso!</h5>
                    <p style="text-align: justify">Su usuario no tiene permisos de acceso para este modulo, Comuniquese con el
                        administrador del sistema.</p>
                </div>
            </div>
        </div>
    @endif
@endsection

@section('footer_card')
<input type="hidden" id="id_tareas_gestion_url" data_url="{{ route('tareas.gestion', ['id' => 1]) }}">
@endsection

@section('modales')
@endsection

@section('script_pagina')
@include('intranet.layout.dataTableNew')
    <script src="{{ asset('js/intranet/general/datatablesini.js') }}"></script>
    <script src="{{asset('js/intranet/general/ninja/nprogress.js')}}"></script>
    <script src="{{asset('js/intranet/general/ninja/jquery-ui.min.js')}}"></script>
    <script src="{{asset('js/intranet/general/ninja/main.min.js')}}"></script>
    <script src="{{ asset('js/intranet/proyectos/proyecto/gestion.js') }}"></script>
@endsection

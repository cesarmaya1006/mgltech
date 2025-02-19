<!-- +++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
@extends('intranet.layout.app')
@section('css_pagina')
<link rel="stylesheet" href="{{asset('css/intranet/hv/editar.css')}}">
@endsection
@section('tituloPagina')
    <i class="far fa-folder-open" aria-hidden="true"></i> Módulo Archivo
@endsection
@section('breadcrumb')
<li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Home</a></li>
<li class="breadcrumb-item"><a href="{{ route('archivo-modulo.index') }}">Módulo Archivo</a></li>
<li class="breadcrumb-item"><a href="{{ route('hojas_vida.index') }}">Hojas de Vida</a></li>
<li class="breadcrumb-item"><a href="#">Edición</a></li>
@endsection
@section('titulo_card')
<img src="{{asset('imagenes/sistema/1.png')}}" class="img-fluid" alt="..." style="max-height: 35px; width: auto;"> Edición de Hoja de vida
<p class="ml-5" style="font-size: 0.7em;">Ultima edición: {{date_format($empleado->updated_at,'Y-m-d')}}</p>
@endsection
@section('botones_card')
    @can('hojas_vida.index')
        <a href="{{ route('hojas_vida.index') }}" class="btn btn-success btn-xs mini_sombra pl-5 pr-5 float-md-end" style="font-size: 0.8em;">
            <i class="fas fa-reply mr-2"></i>
            Volver
        </a>
    @endcan
@endsection
@section('cuerpoPagina')
    @can('hojas_vida.hojas_de_vida-editar')
        <div class="row">
            <div class="col-12">
                <h5>{{$empleado->nombres . ' ' . $empleado->apellidos}}</h5>
            </div>
            <div class="col-12">
                <span class="text-muted">{{$empleado->cargo->cargo}}</span>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-12 col-md-3 form-group" id="caja_area_nueva">
                <label class="requerido" for="area">Área</label>
                <span class="form-control form-control-sm" id="spanIdArea">{{$empleado->cargo->area->area}}</span>
            </div>
            <div class="col-12 col-md-3 form-group" id="caja_area_nueva">
                <label class="requerido" for="area">Cargo</label>
                <span class="form-control form-control-sm" id="spanIdCargo">{{$empleado->cargo->cargo}}</span>
            </div>
            @can('hojas_vida.edicionCargos')
                <div class="col-12 col-md-1 d-flex align-items-center">
                    <button type="button" class="btn btn-warning btn-xs btn-sombra" data-bs-toggle="modal" data-bs-target="#cargoModal">
                        Editar
                    </button>
                </div>
            @endcan
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h5 style="text-decoration: underline;"><strong>Datos Personales </strong></h5>
            </div>
            <br>
        </div>
        <br>
        <div class="row">
            <form class="col-12 form-horizontal" id="formDatosPersonales" action="{{ route('hojas_vida.setEmpleadodatos',['id'=>$empleado->id]) }}" method="POST" autocomplete="off" enctype="multipart/form-data">
                @csrf
                @method('put')
                <input type="hidden" name="empleado_id" value="{{$empleado->id}}">
                <div class="row">
                    <div class="col-12 col-md-2 form-group">
                        <label class="requerido" for="tipo_documento_id">Tipo de identificación</label>
                        <select id="tipo_documento_id" class="form-control form-control-sm" name="tipo_documento_id" required>
                            <option value="">Elija tipo</option>
                            @foreach ($tiposdocu as $tipoDocu)
                                <option value="{{ $tipoDocu->id }}" {{isset($empleado)?$empleado->tipo_documento_id == $tipoDocu->id?'selected':'':''}}>
                                    {{ $tipoDocu->abreb_id .' - ' . $tipoDocu->tipo_id}}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 col-md-2 form-group">
                        <label class="requerido" for="identificacion">Identificación</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('identificacion', $empleado->identificacion ?? '') }}" name="identificacion" id="identificacion" required>
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="requerido" for="nombres">Nombres</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('nombres', $empleado->nombres ?? '') }}" name="nombres" id="nombres" required>
                    </div>
                    <div class="col-12 col-md-4 form-group">
                        <label class="requerido" for="apellidos">Apellidos</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('apellidos', $empleado->apellidos ?? '') }}" name="apellidos" id="apellidos" required>
                    </div>
                    <div class="col-12 col-md-3 form-group">
                        <label class="requerido" for="email">Correo Electrónico</label>
                        <input type="email" class="form-control form-control-sm" value="{{ old('email', $empleado->usuario->email ?? '') }}" name="email" id="email" required>
                    </div>
                    <div class="col-12 col-md-3 form-group">
                        <label class="requerido" for="telefono">Teléfono</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('telefono', $empleado->telefono ?? '') }}" name="telefono" id="telefono" required>
                    </div>
                    <div class="col-12 col-md-6 form-group">
                        <label class="requerido" for="direccion">Dirección</label>
                        <input type="text" class="form-control form-control-sm" value="{{ old('direccion', $empleado->direccion ?? '') }}" name="direccion" id="direccion" required>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 form-group">
                        <label for="foto" class="requerido">Fotografía</label>
                        <input type="file" class="form-control form-control-sm" id="foto" name="foto" placeholder="Foto del usuario" accept="image/png,image/jpeg" onchange="mostrar()">
                    </div>
                    <div class="col-12">
                        <div class="row d-flex justify-content-evenly">
                            <div class="col-6 col-md-4">
                                <img class="img-fluid fotoUsuario"
                                     id="fotoUsuario"
                                     src="{{ isset($empleado) ?($empleado->foto!=null?asset('/imagenes/usuarios/'.$empleado->foto) : asset('/imagenes/usuarios/usuario-inicial.jpg')) : asset('/imagenes/usuarios/usuario-inicial.jpg') }}" alt=""
                                     style="max-height: 300px;width: auto;">
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row mt-3 mb-3">
                    <div class="col-12 col-md-3">
                        <div class="d-grid gap-2">
                            <button type="submit" class="btn btn-primary btn-xs btn-sombra" type="button">Actualizar datos personales</button>
                          </div>
                    </div>
                </div>
            </form>
        </div>
        <hr>
        <div class="row">
            <div class="col-12">
                <h5 style="text-decoration: underline;"><strong>Formación Academica - Publicaciones - Idiomas</strong></h5>
                <button type="button" class="btn btn-green-moon btn-xs btn-mini_sombra text-center pl-5 pr-5 float-md-end" data-bs-toggle="modal" data-bs-target="#educacionModal">
                    <i class="fas fa-cloud-upload-alt mr-3"></i>
                    Nuevo Registro
                  </button>
            </div>
            <br>
        </div>
        <div class="row mt-3" style="font-size: 0.85em;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Formación Academica</h3>
                    </div>
                    <div class="card-body">
                        <div id="accordion">
                            <div class="card card-light">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseOne" aria-expanded="false">Educación Básica</a>
                                    </h4>
                                </div>
                                <div id="collapseOne" class="collapse" data-parent="#accordion" style="">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" scope="col">Estado</th>
                                                            <th class="text-center" scope="col">Último grado cursado</th>
                                                            <th class="text-center" scope="col">Título obtenido</th>
                                                            <th class="text-center" scope="col">Establecimiento educativo</th>
                                                            <th class="text-center" scope="col">Fecha grado o ult curs</th>
                                                            <th class="text-center" scope="col">Soporte</th>
                                                            <th class="text-center" scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyEducacionBasica">
                                                        @foreach ($empleado->info_educacion->where('tipo_id',1) as $educacion)
                                                            <tr>
                                                                <td>{{$educacion->estado}}</td>
                                                                <td>{{$educacion->ultimo_cursado}}</td>
                                                                <td>{{$educacion->titulo}}</td>
                                                                <td>{{$educacion->establecimiento}}</td>
                                                                <td>{{$educacion->fecha_termino}}</td>
                                                                <td><a href="{{asset('documentos/empleados/' . $educacion->soporte)}}" target="_blank">{{substr($educacion->soporte, strpos($educacion->soporte, "-") + 1);}}</a></td>
                                                                <td></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-light">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">Educación Superior</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" scope="col">Estado</th>
                                                            <th class="text-center" scope="col">Título obtenido</th>
                                                            <th class="text-center" scope="col">Establecimiento educativo</th>
                                                            <th class="text-center" scope="col">Fecha grado o ult curs</th>
                                                            <th class="text-center" scope="col">Num tarjeta prof.</th>
                                                            <th class="text-center" scope="col">Soporte</th>
                                                            <th class="text-center" scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyEducacionSuperior">
                                                        @foreach ($empleado->info_educacion->where('tipo_id',2) as $educacion)
                                                            <tr>
                                                                <td>{{$educacion->estado}}</td>
                                                                <td>{{$educacion->titulo}}</td>
                                                                <td>{{$educacion->establecimiento}}</td>
                                                                <td>{{$educacion->fecha_termino}}</td>
                                                                <td>{{$educacion->tarjeta_prof}}</td>
                                                                <td><a href="{{asset('documentos/empleados/' . $educacion->soporte)}}" target="_blank">{{substr($educacion->soporte, strpos($educacion->soporte, "-") + 1);}}</a></td>
                                                                <td></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-light">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">Otra Educación</a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" scope="col">Estado</th>
                                                            <th class="text-center" scope="col">Título obtenido</th>
                                                            <th class="text-center" scope="col">Establecimiento educativo</th>
                                                            <th class="text-center" scope="col">Cant Horas</th>
                                                            <th class="text-center" scope="col">Fecha de Inicio</th>
                                                            <th class="text-center" scope="col">Fecha de Termino</th>
                                                            <th class="text-center" scope="col">Soporte</th>
                                                            <th class="text-center" scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyEducacionOtra">
                                                        @foreach ($empleado->info_educacion->where('tipo_id',3) as $educacion)
                                                            <tr>
                                                                <td>{{$educacion->estado}}</td>
                                                                <td>{{$educacion->titulo}}</td>
                                                                <td>{{$educacion->establecimiento}}</td>
                                                                <td>{{$educacion->cant_horas}}</td>
                                                                <td>{{$educacion->fecha_inicio}}</td>
                                                                <td>{{$educacion->fecha_termino}}</td>
                                                                <td><a href="{{asset('documentos/empleados/' . $educacion->soporte)}}" target="_blank">{{substr($educacion->soporte, strpos($educacion->soporte, "-") + 1);}}</a></td>
                                                                <td></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <hr>
        <div class="row mt-3" style="font-size: 0.85em;">
            <div class="col-12">
                <div class="card">
                    <div class="card-header">
                        <h3 class="card-title">Experiencia laboral</h3>
                        <button type="button" class="btn btn-green-moon btn-xs btn-mini_sombra text-center pl-5 pr-5 float-md-end" data-bs-toggle="modal" data-bs-target="#laboralModal">
                            <i class="fas fa-cloud-upload-alt mr-3"></i>
                            Nuevo Registro
                          </button>
                    </div>
                    <div class="card-body">
                        <div id="accordionLaboral">
                            <div class="card card-light">
                                <div class="card-header">
                                    <h5 class="card-title w-100">
                                        <a class="d-block w-100 collapsed" data-toggle="collapse" href="#collapseLaboralFormal" aria-expanded="false">Experiencia laboral Formal</a>
                                    </h5>
                                </div>
                                <div id="collapseLaboralFormal" class="collapse" data-parent="#accordionLaboral" style="">
                                    <div class="card-body">
                                        <div class="row">
                                            @csrf @method('delete')
                                            <div class="col-12 table-responsive">
                                                <table class="table tabla-borrando">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" scope="col">Entidad</th>
                                                            <th class="text-center" scope="col">Tipo de Entidad</th>
                                                            <th class="text-center" scope="col">Pais</th>
                                                            <th class="text-center" scope="col">Departamento</th>
                                                            <th class="text-center" scope="col">Municipio</th>
                                                            <th class="text-center" scope="col">Dirección</th>
                                                            <th class="text-center" scope="col">Teléfono</th>
                                                            <th class="text-center" scope="col">Fecha de Ingreso</th>
                                                            <th class="text-center" scope="col">Fecha de Termino</th>
                                                            <th class="text-center" scope="col">Tipo de Contrato</th>
                                                            <th class="text-center" scope="col">Destinación de Tiempo</th>
                                                            <th class="text-center" scope="col">Cargo</th>
                                                            <th class="text-center" scope="col">Dependencia</th>
                                                            <th class="text-center" scope="col">Jefe Inmediato</th>
                                                            <th class="text-center" scope="col">Observaciones</th>
                                                            <th class="text-center" scope="col">Soporte</th>
                                                            <th class="text-center" scope="col"></th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyExperienciaFormal">
                                                        @foreach ($empleado->experienciaslab->sortByDesc('fecha_termino') as $experiencia)
                                                            <tr>
                                                                <td style="white-space:nowrap;">{{ $experiencia->entidad }} {{ $experiencia->actual == 'Si' ? ' - Actual' : '' }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->tipo_entidad }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->pais }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->pais == 'COLOMBIA' ? $experiencia->departamento : '---' }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->pais == 'COLOMBIA' ? $experiencia->municipio : '---' }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->direccion }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->telefono }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->fecha_ingreso }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->actual == 'Si' ? 'Actual' : $experiencia->fecha_termino }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->tipo_contrato }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->tiempo_contrato }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->cargo }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->dependencia }}</td>
                                                                <td style="white-space:nowrap;">{{ $experiencia->jefe_inmediato }}</td>
                                                                <td style="vertical-align: normal;max-width: 300px;min-height: 200px;">{{ $experiencia->observaciones }}</td>
                                                                <td style="white-space:nowrap;"><a href="{{ asset('documentos/empleados/' . $experiencia->soporte) }}" target="_blank">{{ $experiencia->soporte }}</a></td>
                                                                <td class="text-center" style="min-width: 100px;">
                                                                    <form action="{{ route('hojas_vida.eliminarlaboralformal', ['id' => $experiencia->id]) }}" class="d-inline form-eliminar" method="POST">
                                                                        @csrf @method("delete")
                                                                        <button type="submit"
                                                                            class="btn-accion-tabla eliminar tooltipsC text-danger"
                                                                            title="Eliminar este registro">
                                                                            <i class="fas fa-trash-alt"></i>
                                                                        </button>
                                                                    </form>
                                                                </td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-light">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseTwo">Experiencia laboral Informal</a>
                                    </h4>
                                </div>
                                <div id="collapseTwo" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" scope="col">Estado</th>
                                                            <th class="text-center" scope="col">Título obtenido</th>
                                                            <th class="text-center" scope="col">Establecimiento educativo</th>
                                                            <th class="text-center" scope="col">Fecha grado o ult curs</th>
                                                            <th class="text-center" scope="col">Num tarjeta prof.</th>
                                                            <th class="text-center" scope="col">Soporte</th>
                                                            <th class="text-center" scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyEducacionSuperior">
                                                        @foreach ($empleado->info_educacion->where('tipo_id',2) as $educacion)
                                                            <tr>
                                                                <td>{{$educacion->estado}}</td>
                                                                <td>{{$educacion->titulo}}</td>
                                                                <td>{{$educacion->establecimiento}}</td>
                                                                <td>{{$educacion->fecha_termino}}</td>
                                                                <td>{{$educacion->tarjeta_prof}}</td>
                                                                <td><a href="{{asset('documentos/empleados/' . $educacion->soporte)}}" target="_blank">{{substr($educacion->soporte, strpos($educacion->soporte, "-") + 1);}}</a></td>
                                                                <td></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            <div class="card card-light">
                                <div class="card-header">
                                    <h4 class="card-title w-100">
                                        <a class="d-block w-100" data-toggle="collapse" href="#collapseThree">Tiempo total de experiencia y situación laboral</a>
                                    </h4>
                                </div>
                                <div id="collapseThree" class="collapse" data-parent="#accordion">
                                    <div class="card-body">
                                        <div class="row">
                                            <div class="col-12 table-responsive">
                                                <table class="table">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-center" scope="col">Estado</th>
                                                            <th class="text-center" scope="col">Título obtenido</th>
                                                            <th class="text-center" scope="col">Establecimiento educativo</th>
                                                            <th class="text-center" scope="col">Cant Horas</th>
                                                            <th class="text-center" scope="col">Fecha de Inicio</th>
                                                            <th class="text-center" scope="col">Fecha de Termino</th>
                                                            <th class="text-center" scope="col">Soporte</th>
                                                            <th class="text-center" scope="col">Opciones</th>
                                                        </tr>
                                                    </thead>
                                                    <tbody id="tbodyEducacionOtra">
                                                        @foreach ($empleado->info_educacion->where('tipo_id',3) as $educacion)
                                                            <tr>
                                                                <td>{{$educacion->estado}}</td>
                                                                <td>{{$educacion->titulo}}</td>
                                                                <td>{{$educacion->establecimiento}}</td>
                                                                <td>{{$educacion->cant_horas}}</td>
                                                                <td>{{$educacion->fecha_inicio}}</td>
                                                                <td>{{$educacion->fecha_termino}}</td>
                                                                <td><a href="{{asset('documentos/empleados/' . $educacion->soporte)}}" target="_blank">{{substr($educacion->soporte, strpos($educacion->soporte, "-") + 1);}}</a></td>
                                                                <td></td>
                                                            </tr>
                                                        @endforeach
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
<!-- Modal -->
<div class="modal fade" id="cargoModal" tabindex="-1" aria-labelledby="cargoModalLabel" aria-hidden="true">
    <div class="modal-dialog">
        <form id="formCargo" class="modal-content form-horizontal" action="{{ route('hojas_vida.setCargoEmpleado') }}" method="POST" autocomplete="off">
            @csrf
            @method('put')
            <div class="modal-header">
                <h6 class="modal-title" id="cargoModalLabel">Reasignación de Cargo </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 form-group">
                        <label class="requerido" for="area_id">Área</label>
                        <select id="area_id" class="form-control form-control-sm" data_url="{{route('cargos.getCargos')}}" required>
                            @foreach ($empleado->cargo->area->empresa->areas as $area)
                                <option value="{{ $area->id }}" {{$empleado->cargo->area_id==$area->id? 'selected':''}}>
                                    {{ $area->area }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="cargo_id">Cargo</label>
                        <select id="cargo_id" name="cargo_id" class="form-control form-control-sm" required>
                            @foreach ($empleado->cargo->area->cargos as $cargo)
                                <option value="{{ $cargo->id }}" {{$empleado->cargo_id==$cargo->id? 'selected':''}}>
                                    {{ $cargo->cargo }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
                <input type="hidden" name="empleado_id" value="{{$empleado->id}}">
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary btn-xs">Cuardar</button>
            </div>
        </form>
    </div>
</div>
<!-- fin Modal -->
<!-- Modal Educacion -->
<div class="modal fade" id="educacionModal" tabindex="-1" aria-labelledby="educacionModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form id="formEducacionEmpleado" class="modal-content form-horizontal" action="{{ route('hojas_vida.setEducacionEmpleadodatos') }}" method="POST" autocomplete="off">
            @csrf
            @method('put')
            <div class="modal-header">
                <h6 class="modal-title" id="educacionModalLabel">Registrar Formación Académica </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <input type="hidden" name="empleado_id" value="{{$empleado->id}}">
                <div class="row">
                    <div class="col-12 form-group">
                        <label class="requerido" for="tipo_id">Tipo de Educación</label>
                        <select id="tipo_id" name="tipo_id" class="form-control form-control-sm" data_url="{{route('cargos.getCargos')}}" required>
                            @foreach ($tiposeducacion as $tipo)
                                <option value="{{$tipo->id}}">{{$tipo->tipo}}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 form-group caja_fijos">
                        <label class="requerido" for="estado">Estado</label>
                        <select id="estado" name="estado" class="form-control form-control-sm" data_url="{{route('cargos.getCargos')}}" required>
                            <option value="">Selc Opción</option>
                            <option value="Completa">Completa</option>
                            <option value="Incompleta">Incompleta</option>
                        </select>
                    </div>
                    <div class="col-12 form-group caja_fijos">
                        <label class="requerido" for="ultimo_cursado">Últ Grado Cursado</label>
                        <input type="text" class="form-control form-control-sm " name="ultimo_cursado" id="ultimo_cursado" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <div class="col-12 form-group caja_fijos">
                        <label class="requerido" for="titulo">Titulo Obtenido</label>
                        <input type="text" class="form-control form-control-sm " name="titulo" id="titulo" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <div class="col-12 form-group caja_fijos">
                        <label class="requerido" for="establecimiento">Establecimiento</label>
                        <input type="text" class="form-control form-control-sm " name="establecimiento" id="establecimiento" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <div class="col-12 form-group caja_superior d-none" id="caja_tarjeta_prof">
                        <label class="requerido" for="tarjeta_prof">N° Tarj Profesional</label>
                        <input type="text" class="form-control form-control-sm " name="tarjeta_prof" id="tarjeta_prof" aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="col-12 form-group caja_otros d-none" id="caja_cant_horas">
                        <label class="requerido" for="cant_horas">Cant Horas</label>
                        <input type="text" class="form-control form-control-sm " name="cant_horas" id="cant_horas" aria-describedby="helpId" placeholder="">
                    </div>
                    <div class="col-12 form-group caja_fijos">
                        <label class="requerido" for="fecha_inicio">Fecha inicio</label>
                        <input type="date" class="form-control form-control-sm" max="{{ date('Y-m-d', strtotime(date('Y-m-d') . '- 1 days')) }}"
                               value="{{ date('Y-m-d', strtotime(date('Y-m-d') . '- 1 days')) }}" name="fecha_inicio" id="fecha_inicio" required>
                    </div>
                    <div class="col-12 form-group caja_fijos">
                        <label for="fecha_termino">Fecha Termino</label>
                        <input type="date" class="form-control form-control-sm" max="{{ date('Y-m-d', strtotime(date('Y-m-d') . '- 1 days')) }}"
                               value="{{ date('Y-m-d', strtotime(date('Y-m-d') . '- 1 days')) }}" name="fecha_termino" id="fecha_termino">
                    </div>
                    <div class="col-12 form-group caja_fijos">
                        <label class="requerido" for="soporte">Soporte Pdf</label>
                        <input class="form-control form-control-sm" type="file" name="soporte" id="soporte" accept="application/pdf" required>
                    </div>
                </div>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary btn-xs">Cuardar</button>
            </div>
        </form>
    </div>
</div>
<!-- fin Modal -->
<!-- Modal -->
<div class="modal fade" id="laboralModal" tabindex="-1" aria-labelledby="laboralModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-dialog-scrollable">
        <form id="formAddExperienciaLaboral" class="modal-content form-horizontal" action="{{ route('hojas_vida.addExperienciaLaboral') }}" method="POST" autocomplete="off">
            @csrf
            @method('post')
            <input type="hidden" name="empleado_id" value="{{$empleado->id}}">
            <div class="modal-header">
                <h6 class="modal-title" id="laboralModalLabel">Añadir Experiencia Laboral Formal </h6>
                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
            </div>
            <div class="modal-body">
                <div class="row">
                    <div class="col-12 form-group">
                        <label class="requerido" for="actual">Empleo Actual</label>
                        <select class="form-control form-control-sm" name="actual" id="actual" required>
                            <option value="">Seleccione Opción</option>
                            <option value="Si">Si</option>
                            <option value="No">No</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="entidad">Entidad/Empresa</label>
                        <input type="text" class="form-control form-control-sm" name="entidad" id="entidad" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="tipo_entidad">Tipo de Entidad</label>
                        <select class="form-control form-control-sm" name="tipo_entidad" id="tipo_entidad" required>
                            <option value="">Seleccione Opción</option>
                            <option value="Pública">Pública</option>
                            <option value="Privada">Privada</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="pais">País</label>
                        <select class="form-control form-control-sm" name="pais" id="pais">
                            <option value="">Elija un País</option>
                            @foreach ($paises as $pais)
                                <option value="{{ $pais->pais }}" {{ $pais->pais == 'COLOMBIA' ? 'Selected' : '' }}>{{ $pais->pais }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="departamento" id="label_departamento">Departamento</label>
                        <select class="form-control form-control-sm" name="departamento" data_url="{{ route('hojas_vida.getCargarMunicipios') }}" id="departamento">
                            <option value="">Elija un Departamento</option>
                            @foreach ($departamentos as $departamento)
                                <option value="{{$departamento->id }}">{{ $departamento->departamento }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="municipio" id="label_municipio">Municipio</label>
                        <select class="form-control form-control-sm" name="municipio" id="municipio">
                            <option value="">Elija primero un Depto.</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="direccion">Dirección</label>
                        <input type="text" class="form-control form-control-sm" name="direccion" id="direccion" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="telefono">Teléfono</label>
                        <input type="text" class="form-control form-control-sm" maxlength="13" name="telefono"
                               id="telefono" onKeypress="if (event.keyCode < 45 || event.keyCode > 57) event.returnValue = false;" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="fecha_ingreso">Fecha Ingreso</label>
                        <input type="date" class="form-control form-control-sm"
                               max="{{ date('Y-m-d', strtotime(date('Y-m-d') . '- 1 days')) }}"
                               value="{{ date('Y-m-d', strtotime(date('Y-m-d') . '- 1 days')) }}"
                               name="fecha_ingreso" id="fecha_ingreso" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="" for="fecha_termino" id="label_fecha_termino">Fecha termino</label>
                        <input type="date" class="form-control form-control-sm" min="{{ date('Y-m-d') }}" name="fecha_termino" id="fecha_termino">
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="tipo_contrato">Tipo de Contrato</label>
                        <select class="form-control form-control-sm" name="tipo_contrato" id="tipo_contrato"
                            required>
                            <option value="">Seleccione Opción</option>
                            <option value="A Término Indefinido ">A Término Indefinido </option>
                            <option value="A Término Fijo">A Término Fijo</option>
                            <option value="De Obra o Labor">De Obra o Labor</option>
                            <option value="Temporal, Ocasional o Accidental">Temporal, Ocasional o Accidental</option>
                            <option value="Civil por Prestación de Servicios">Civil por Prestación de Servicios</option>
                            <option value="De Aprendizaje">De Aprendizaje</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="tiempo_contrato">Destinación de Tiempo</label>
                        <select class="form-control form-control-sm" name="tiempo_contrato" id="tiempo_contrato" required>
                            <option value="">Seleccione Opción</option>
                            <option value="Tiempo Completo">Tiempo Completo </option>
                            <option value="Medio Tiempo">Medio Tiempo</option>
                            <option value="Por Horas o Días">Por Horas o Días</option>
                        </select>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="cargo">Cargo</label>
                        <input type="text" class="form-control form-control-sm" name="cargo" id="cargo" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="dependencia">Dependencia</label>
                        <input type="text" class="form-control form-control-sm" name="dependencia" id="dependencia" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="requerido" for="jefe_inmediato">Jefe inmediato</label>
                        <input type="text" class="form-control form-control-sm" name="jefe_inmediato" id="jefe_inmediato" aria-describedby="helpId" placeholder="" required>
                    </div>
                    <div class="col-12 form-group">
                        <label class="" for="soporte">Soporte Pdf</label>
                        <input class="form-control form-control-sm" type="file" name="soporte" id="soporte" accept="application/pdf" style="font-size: 0.9em;">

                    </div>
                    <div class="col-12 form-group">
                        <label class="" for="observaciones">Observaciones</label>
                        <textarea class="form-control form-control-sm" name="observaciones" id="observaciones" rows="4" style="resize: none;" required></textarea>
                    </div>
                </div>

            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-secondary btn-xs" data-bs-dismiss="modal">Cancelar</button>
                <button type="submit" class="btn btn-primary btn-xs">Cuardar</button>
            </div>
        </form>
    </div>
</div>
<!-- fin Modal -->

<input type="hidden" id="rutaSoportes" value="{{asset('documentos/empleados/')}}" data_url_borrar_laboral="{{route('hojas_vida.eliminarlaboralformal', ['id' => 1])}}">
@endsection

@section('script_pagina')
    <script src="{{ asset('js/intranet/empresa/modulo_archivo/hojas_de_vida/editar.js') }}"></script>
@endsection

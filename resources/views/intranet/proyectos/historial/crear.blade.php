@extends('intranet.layout.app')

@section('css_pagina')
@endsection

@section('titulo_pagina')
    <i class="fas fa-project-diagram mr-3" aria-hidden="true"></i> Módulo de Proyectos
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proyectos.index') }}">Proyectos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proyectos.gestion', ['id' => $tarea->componente->proyecto->id]) }}">Gestión Proyecto</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tareas.gestion', ['id' => $tarea->id]) }}">Gestionar Tarea</a></li>
    <li class="breadcrumb-item active">Crear Historial</li>
@endsection

@section('titulo_card')
    <i class="fa fa-plus-square mr-3" aria-hidden="true"></i> Nuevo historial
@endsection

@section('botones_card')
    <a href="{{ route('tareas.gestion', ['id' => $tarea->id]) }}" class="btn btn-primary btn-xs btn-sombra pl-5 pr-5 float-md-end">
        <i class="fas fa-reply mr-4 ml-2"></i><span class="mr-md-5">Volver</span>
    </a>
@endsection

@section('cuerpo')
    <div class="row d-flex justify-content-center">
        <form class="col-12 form-horizontal" action="{{ route('historiales.store_tarea') }}" method="POST" autocomplete="off"
            enctype="multipart/form-data">
            @csrf
            @method('post')
            @include('intranet.proyectos.historial.form')
            <div class="row mt-3">
                <div class="col-12 col-md-6 mb-4 mb-md-0 d-grid gap-2 d-md-block ">
                    <button type="submit" class="btn btn-primary btn-xs btn-sombra"
                        style="font-size: 0.8em;"><span class="pr-5 pl-5">Crear Historial</span></button>
                </div>
            </div>
        </form>
    </div>
@endsection

@section('footer_card')
@endsection

@section('modales')
@endsection

@section('scripts_pagina')
<script src="{{ asset('js/intranet/proyectos/tareas/crear.js') }}"></script>
@endsection

<!-- ++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++++ -->
@extends('intranet.layout.app')
@section('css_pagina')
@endsection
@section('tituloPagina')
    <i class="fas fa-project-diagram mr-3" aria-hidden="true"></i> Módulo de Proyectos
@endsection
@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proyectos.index') }}">Proyectos</a></li>
    <li class="breadcrumb-item"><a href="{{ route('proyectos.gestion', ['id' => $tarea->componente->proyecto->id]) }}">Gestión Proyecto</a></li>
    <li class="breadcrumb-item"><a href="{{ route('tareas.gestion', ['id' => $tarea->id]) }}">Gestionar Tarea</a></li>
    <li class="breadcrumb-item active">Crear Historial</li>
@endsection
@section('titulo_card')
    <i class="fa fa-plus-square mr-3" aria-hidden="true"></i> Nuevo historial
@endsection
@section('botones_card')
    <a href="{{ route('tareas.gestion', ['id' => $tarea->id]) }}" class="btn btn-primary btn-xs btn-sombra pl-5 pr-5 float-md-end">
        <i class="fas fa-reply mr-4 ml-2"></i><span class="mr-md-5">Volver</span>
    </a>
@endsection
@section('cuerpoPagina')
    @can('historiales.store_tarea')
        <div class="row d-flex justify-content-center">
            <form class="col-12 form-horizontal" action="{{ route('historiales.store_tarea') }}" method="POST" autocomplete="off"
                enctype="multipart/form-data">
                @csrf
                @method('post')
                @include('intranet.proyectos.historial.form')
                <div class="row mt-3">
                    <div class="col-12 col-md-6 mb-4 mb-md-0 d-grid gap-2 d-md-block ">
                        <button type="submit" class="btn btn-primary btn-xs btn-sombra"
                            style="font-size: 0.8em;"><span class="pr-5 pl-5">Crear Historial</span></button>
                    </div>
                </div>
            </form>
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
<script src="{{ asset('js/intranet/proyectos/tareas/crear.js') }}"></script>
@endsection

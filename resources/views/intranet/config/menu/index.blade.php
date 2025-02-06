@extends('intranet.layout.app')

@section('css_pagina')
<link rel="stylesheet" href="{{ asset('css/intranet/menu/index.css') }}">
<link rel="stylesheet" href="{{ asset('css/intranet/menu/menu_nestable.css') }}">
@endsection

@section('tituloPagina')
    <i class="fas fa-list-ul mr-3" aria-hidden="true"></i> Configuración Menus
@endsection

@section('breadcrumb')
    <li class="breadcrumb-item"><a href="{{ route('dashboard') }}">Inicio</a></li>
    <li class="breadcrumb-item active">Menús</li>
@endsection

@section('titulo_card')
    Listado de Menus
@endsection

@section('botones_card')

@endsection

@section('cuerpoPagina')
    <div class="row">
        <div class="col-12">
            @csrf
            <div class="cf nestable-lists">
                <div class="dd" id="nestable">
                    <ol class="dd-list" id="dd_list99" data-url="{{ route('menu.ordenar') }}">
                        @foreach ($menus as $key => $item)
                            @if ($item['menu_id'] != 0)
                            @break
                        @endif
                        @include('intranet.config.menu.menu-item')
                    @endforeach
                </ol>
            </div>
        </div>

    </div>
</div>
@endsection

@section('footer_card')

@endsection

@section('modales')

@endsection

@section('script_pagina')
<script src="{{ asset('js/intranet/configuracion/menu/jquery.nestable.js') }}"></script>
<script src="{{ asset('js/intranet/configuracion/menu/index.js') }}"></script>
@endsection

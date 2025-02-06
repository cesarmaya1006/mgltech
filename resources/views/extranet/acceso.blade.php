@extends('extranet.plantilla')
<!-- ************************************************************* -->
@section('cuerpo_pagina')
    <div class="row d-flex justify-content-center" style="height: 82vh;background-color: white;">
        <video autoplay muted loop id="myVideo">
            <source src="{{ asset('imagenes/sistema/fondo_principal.mp4') }}" type="video/mp4">
        </video>
        <div id="linea_adorno">
            <div id="linea_interior"></div>
        </div>
        <div class="col-12 contenido d-flex align-items-center justify-content-center flex-column"
            style="height: 100%; width: 100%;">
            <div class="row fixed-top" style="height: 14vh;width: 100%;margin: auto;background-color: white;">
                <div class="col-12 d-flex justify-content-center align-items-center"><img class="img-fluid"
                        src="{{ asset('imagenes/sistema/mgl_logo.png') }}" alt=""
                        style="width: 10wv; max-width: 150px;">
                </div>
            </div>
        </div>
        <div class="col-12" style="position: absolute;top: 20vh;">
            <div class="row d-flex justify-content-center" style="width: 100%;">
                <div class="col-10 col-md-5 col-lg-6" style="background-color: rgba(0, 0, 0, 0.7)">
                    <div class="row d-flex justify-content-center">
                        <div class="col-9">
                            @include('includes.error-form')
                            @include('includes.mensaje')
                        </div>
                    </div>
                    <div class="row mt-5 mb-1">
                        <div class="col-12 d-flex justify-content-center"
                            style="font-size: 1.5em;font-weight: bold;color: white;">
                            ACCESO DE USUARIOS
                        </div>
                    </div>
                    <form class="row mt-2" style="width: 100%;" action="{{ route('login') }}" method="post"
                        autocomplete="off">
                        @method('post')
                        @csrf
                        <div class="col-12 d-flex justify-content-center flex-column">
                            <div class="row d-flex justify-content-center mt-3" style="width: 100%;">
                                <div class="col-1 text-right">
                                    <i class="fas fa-at fa-2x" style="color:white;text-shadow: 1px 1px black"></i>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <input type="email" class="form-control" name="email" id="email" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center mt-3 mb-3" style="width: 100%;">
                                <div class="col-1 text-right">
                                    <i class="fas fa-key fa-2x" style="color:white;text-shadow: 1px 1px black"></i>
                                </div>
                                <div class="col-8">
                                    <div class="form-group">
                                        <input type="password" class="form-control" name="password" id="password" required>
                                    </div>
                                </div>
                            </div>
                            <div class="row d-flex justify-content-center mt-3 mb-3" style="width: 100%;">
                                <div class="col-5 col-md-2 col-lg-2">
                                    <div class="form-group">
                                        <button type="submit" class="btn btn-info btn-md pl-5 pr-5">Ingresar</button>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <div class="row mt-2 mb-5">
                        <div class="col-12 d-flex justify-content-center">
                            <a href="{{ route('restablecer') }}" style="text-decoration: none; color:white;">¿Olvid&oacute;
                                su contrase&ntilde;a?</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="row">
        <div class="col-12">
            <form action="{{route('logout')}}" method="post">
                @csrf
                @method('post')
                <button type="submit" class="btn btn-primary">Salir</button>
            </form>
        </div>
    </div>
@endsection

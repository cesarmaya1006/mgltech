<!DOCTYPE html>
<html lang="es">
<head>
    @include('intranet.layout.head')
    @yield('css_pagina')
</head>
<body class="hold-transition sidebar-mini layout-fixed">
    <div class="wrapper">
        <!-- Preloader -->
        <div class="preloader flex-column justify-content-center align-items-center">
            <img class="animation__shake" src="{{ asset('imagenes/sistema/icono_sistema.png') }}" alt="AdminLTELogo" height="120" width="120">
        </div>
        <!-- Navbar -->
        @include('intranet.layout.navbar')
        <!-- /.navbar -->
        <!-- Main Sidebar Container -->
        @include('intranet.layout.menu_lat')
        <!-- Content Wrapper. Contains page content -->
        <div class="content-wrapper">
            <!-- Content Header (Page header) -->
            <div class="content-header">
                <div class="container-fluid">
                    <div class="row mb-2">
                        <div class="col-sm-6">
                            <h1 class="m-0">
                                @yield('tituloPagina')
                            </h1>
                        </div>
                        <!-- /.col -->
                        <div class="col-sm-6">
                            <ol class="breadcrumb float-sm-right">
                                @yield('breadcrumb')
                            </ol>
                        </div><!-- /.col -->
                    </div><!-- /.row -->
                </div><!-- /.container-fluid -->
            </div>
            <!-- /.content-header -->
            <!-- Main content -->
            <section class="content">
                <div class="row pl-md-3 pr-md-3">
                    <div class="col-12 card card-outline card-info sombra" id="caja_card_outline">
                        <div class="card-header">
                            <div class="container-fluid">
                                <div class="row">
                                    <div class="col-12 col-md-6 mb-4 mb-md-0">
                                        <h4 class="card-title">
                                            <strong>@yield('titulo_card')</strong>
                                        </h4>
                                    </div>
                                    <div class="col-12 col-md-6 mb-4 mb-md-0 d-grid gap-2 d-md-block ">
                                        @yield('botones_card')
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="row d-flex justify-content-center">
                                <div class="col-12">
                                    @include('includes.mensaje')
                                    @include('includes.error-form')
                                </div>
                                <div class="col-12">
                                    @yield('cuerpoPagina')
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            @yield('footer_card')
                        </div>
                    </div>
                </div>
            </section>
            <!-- /.content -->
        </div>
        <!-- /.content-wrapper -->
        @include('intranet.layout.footer')
        <!-- Control Sidebar -->
        <aside class="control-sidebar control-sidebar-dark">
            <!-- Control sidebar content goes here -->
        </aside>
        <!-- /.control-sidebar -->
    </div>
    <!-- ./wrapper -->
    @yield('modales')
    @include('intranet.layout.script')
    @yield('script_pagina')
</body>

</html>

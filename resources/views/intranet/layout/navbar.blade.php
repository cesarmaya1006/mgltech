<nav class="main-header navbar navbar-expand navbar-white navbar-light">
    <!-- Left navbar links -->
    <ul class="navbar-nav">
        <li class="nav-item">
            <a class="nav-link" data-widget="pushmenu" href="#" role="button"><i class="fas fa-bars"></i></a>
        </li>
        <li class="nav-item d-none d-sm-inline-block">
            <a href="#" class="nav-link">Inicio</a>
        </li>
    </ul>
    <!-- Right navbar links -->
    <ul class="navbar-nav ml-auto">
        <!-- Get Empleados -->
        <input type="hidden" id="getEmpleadosChat" data_url="{{route('getEmpleadosChat')}}" data_url_MN="{{route('getMensajesNuevosEmpleadosChat')}}" ruta_fotos = "{{asset('imagenes/usuarios/ ')}}" dataMyId ="{{session('id_usuario')}}">
        <!-- Notificaciones  -->
        <input type="hidden" id="getNotificacionesEmpleado" data_url="{{route('getNotificacionesEmpleado')}}">

        <!-- Messages Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#">
                <i class="far fa-comments mr-2"></i>
                <span class="badge badge-primary navbar-badge ml-5" id="badge_mesajes_usu">10</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" style="min-width: 400px;">
                <a href="#" class="dropdown-item" data-bs-toggle="modal" data-bs-target="#chatModal" id="abrirModalChat" onclick="abrirModalChat()">
                    <!-- Message Start -->
                    Abrir Chat
                    <!-- Message End -->
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <!-- Message Start -->
                    <div class="media">
                        <img src="{{ asset('adminlte/dist/img/user8-128x128.jpg') }}" alt="User Avatar"
                            class="img-size-50 img-circle mr-3">
                        <div class="media-body">
                            <h3 class="dropdown-item-title">
                                John Pierce
                                <span class="float-right text-sm text-muted"><i class="fas fa-star"></i></span>
                            </h3>
                            <p class="text-sm">I got your message bro</p>
                            <p class="text-sm text-muted"><i class="far fa-clock mr-1"></i> 4 Hours Ago</p>
                        </div>
                    </div>
                    <!-- Message End -->
                </a>
            </div>
        </li>
        <!-- Notifications Dropdown Menu -->
        <li class="nav-item dropdown">
            <a class="nav-link" data-toggle="dropdown" href="#" >
                <i class="far fa-bell mr-3"></i>
                <span class="badge badge-primary navbar-badge ml-5" id="campana_numero">10</span>
            </a>
            <div class="dropdown-menu dropdown-menu-lg dropdown-menu-right" id="li_notificaciones" style="min-width: 400px;">
                <span class="dropdown-item dropdown-header">0 Notificaciones</span>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item">
                    <i class="fas fa-envelope mr-2"></i> 4 new messages
                    <span class="float-right text-muted text-sm">3 mins</span>
                </a>
                <div class="dropdown-divider"></div>
                <a href="#" class="dropdown-item dropdown-footer">Ver Todas las Notificaciones</a>
            </div>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="fullscreen" href="#" role="button">
                <i class="fas fa-expand-arrows-alt"></i>
            </a>
        </li>
        <li class="nav-item">
            <form action="{{ route('logout') }}" method="POST">
                @csrf @method('post')

                <button id="popoverData" type="submit" class="nav-link" data-content="Salir de la plataforma"
                    rel="popover" data-placement="bottom" data-trigger="hover">
                    <i class="fas fa-power-off text-danger"></i>
                </button>
            </form>
        </li>
        <li class="nav-item">
            <a class="nav-link" data-widget="control-sidebar" data-controlsidebar-slide="true" href="#"
                role="button">
                <i class="fas fa-th-large"></i>
            </a>
        </li>
    </ul>
</nav>

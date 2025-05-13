<?php

use App\Http\Controllers\Admin\UsuarioController;
use App\Http\Controllers\Config\MenuController;
use App\Http\Controllers\Config\MenuRolController;
use App\Http\Controllers\Config\PermisoController;
use App\Http\Controllers\Config\PermisoRolController;
use App\Http\Controllers\Config\RolController;
use App\Http\Controllers\Empresa\ArchivoController;
use App\Http\Controllers\Empresa\AreaController;
use App\Http\Controllers\Empresa\CapacitacionController;
use App\Http\Controllers\Empresa\CargoController;
use App\Http\Controllers\Empresa\ClienteController;
use App\Http\Controllers\Empresa\DiagnosticosController;
use App\Http\Controllers\Empresa\DocRetiroController;
use App\Http\Controllers\Empresa\DocumentosContractualesController;
use App\Http\Controllers\Empresa\DotacionesController;
use App\Http\Controllers\Empresa\EmpleadoController;
use App\Http\Controllers\Empresa\EmpresaController;
use App\Http\Controllers\Empresa\EvaluacionDesempController;
use App\Http\Controllers\Empresa\GrupoEmpresaController;
use App\Http\Controllers\Empresa\HistClinicasOcupController;
use App\Http\Controllers\Empresa\HojasDeVidaController;
use App\Http\Controllers\Empresa\ManualesController;
use App\Http\Controllers\Empresa\MenuEmpresaController;
use App\Http\Controllers\Empresa\PermisoEmpleadoController;
use App\Http\Controllers\Empresa\PermisosArchivoController;
use App\Http\Controllers\Empresa\PoliticaController;
use App\Http\Controllers\Empresa\ProcesoDiscipController;
use App\Http\Controllers\Empresa\ProveedoresController;
use App\Http\Controllers\Empresa\SitLabGenController;
use App\Http\Controllers\Empresa\SoportesAfiliacionController;
use App\Http\Controllers\Empresa\VacacionesController;
use App\Http\Controllers\Extranet\ExtranetPageController;
use App\Http\Controllers\Intranet\admin\IntranetPageController;
use App\Http\Controllers\Proyectos\ComponenteController;
use App\Http\Controllers\Proyectos\HistorialController;
use App\Http\Controllers\Proyectos\ProyectoController;
use App\Http\Controllers\Proyectos\TareaController;
use App\Http\Middleware\AdminEmp;
use App\Http\Middleware\Administrador;
use App\Http\Middleware\AdminSistema;
use App\Http\Middleware\Empleado;
use Illuminate\Support\Facades\Route;



Route::controller(ExtranetPageController::class)->group(function () {
    Route::get('/', 'index')->name('extranet.index');
    Route::get('/login', 'login')->name('login');
});

//Route::get('/', function () {return view('welcome');});

Route::prefix('dashboard')->middleware(['auth:sanctum',config('jetstream.auth_session'),'verified',])->group(function () {
    Route::get('/', [IntranetPageController::class, 'dashboard'])->name('dashboard');
    //===================================================================================================
    Route::prefix('configuracion_sis')->middleware(AdminSistema::class)->group(function () {
        Route::controller(MenuController::class)->prefix('menu')->group(function () {
            Route::get('', 'index')->name('menu.index');
            Route::get('crear', 'create')->name('menu.create');
            Route::get('editar/{id}', 'edit')->name('menu.edit');
            Route::post('guardar', 'store')->name('menu.store');
            Route::put('actualizar/{id}', 'update')->name('menu.update');
            Route::get('eliminar/{id}', 'destroy')->name('menu.destroy');
            Route::get('guardar-orden', 'guardarOrden')->name('menu.ordenar');
        });
        // ------------------------------------------------------------------------------------
        // Ruta Administrador del Sistema Roles
        Route::controller(RolController::class)->prefix('rol')->group(function () {
            Route::get('', 'index')->name('rol.index');
            Route::get('crear', 'create')->name('rol.create');
            Route::get('editar/{id}', 'edit')->name('rol.edit');
            Route::post('guardar', 'store')->name('rol.store');
            Route::put('actualizar/{id}', 'update')->name('rol.update');
            Route::delete('eliminar/{id}', 'destroy')->name('rol.destroy');
        });
        // ----------------------------------------------------------------------------------------
        /* Ruta Administrador del Sistema Menu Rol*/
        Route::controller(MenuRolController::class)->prefix('menu_rol')->group(function () {
            Route::get('', 'index')->name('menu.rol.index');
            Route::post('guardar', 'store')->name('menu.rol.store');
        });
        // ----------------------------------------------------------------------------------------
    });
    //===================================================================================================
    Route::prefix('configuracion_sis')->middleware(Administrador::class)->group(function (){
        /* Ruta Administrador del Sistema Menu Empresas*/
        Route::controller(MenuEmpresaController::class)->prefix('permisos_menus_empresas')->group(function () {
            Route::get('', 'index')->name('permisos_menus_empresas.index');
            Route::post('guardar', 'store')->name('permisos_menus_empresas.store');
        });
        // ------------------------------------------------------------------------------------
        // ------------------------------------------------------------------------------------
        // Ruta Administrador del Permisos Roles
        Route::controller(PermisoController::class)->prefix('permiso_rutas')->group(function () {
            Route::get('', 'index')->name('permiso_rutas.index');
        });
        // ----------------------------------------------------------------------------------------
        /* Ruta Administrador del Sistema Menu Rol*/
        Route::controller(PermisoRolController::class)->prefix('permisos_rol')->group(function () {
            Route::get('', 'index')->name('permisos_rol.index');
            Route::post('guardar', 'store')->name('permisos_rol.store');
            Route::get('excepciones/{permission_id}/{role_id}', 'excepciones')->name('permisos_rol.excepciones');
            Route::post('guardar_excepciones', 'store_excepciones')->name('permisos_rol.store_excepciones');
        });
        // ----------------------------------------------------------------------------------------
        // Ruta Administrador Grupo Empresas
        // ------------------------------------------------------------------------------------
        Route::controller(GrupoEmpresaController::class)->prefix('grupo_empresas')->group(function () {
            Route::get('', 'index')->name('grupo_empresas.index');
            Route::get('crear', 'create')->name('grupo_empresas.create');
            Route::get('editar/{id}', 'edit')->name('grupo_empresas.edit');
            Route::post('guardar', 'store')->name('grupo_empresas.store');
            Route::put('actualizar/{id}', 'update')->name('grupo_empresas.update');
            Route::delete('eliminar/{id}', 'destroy')->name('grupo_empresas.destroy');
            Route::get('activar/{id}', 'activar')->name('grupo_empresas.activar');
            Route::get('getEmpresas', 'getEmpresas')->name('grupo_empresas.getEmpresas');
        });
        // ----------------------------------------------------------------------------------------
        /* Ruta Administrador del Sistema Menu Rol*/
        Route::controller(EmpresaController::class)->prefix('empresas')->group(function () {
            Route::get('', 'index')->name('empresa.index');
            Route::get('crear', 'create')->name('empresa.create');
            Route::post('guardar', 'store')->name('empresa.store');
            Route::get('editar/{id}', 'edit')->name('empresa.edit');
            Route::put('actualizar/{id}', 'update')->name('empresa.update');
            Route::delete('eliminar/{id}', 'destroy')->name('empresa.destroy');
            Route::get('getEmpresas', 'getEmpresas')->name('empresa.getEmpresas');
            Route::get('activar/{id}', 'activar')->name('empresa.activar');
        });
        // ----------------------------------------------------------------------------------------
        // ----------------------------------------------------------------------------------------
        // Ruta Administrador del Sistema Usuarios
        Route::controller(UsuarioController::class)->prefix('usuarios')->group(function () {
            Route::get('', 'index')->name('usuario.index');
            Route::get('crear', 'create')->name('usuario.create');
            Route::get('editar/{id}', 'edit')->name('usuario.edit');
            Route::post('guardar', 'store')->name('usuario.store');
            Route::put('actualizar/{id}', 'update')->name('usuario.update');
            Route::delete('eliminar/{id}', 'destroy')->name('usuario.destroy');
            Route::put('activar/{id}', 'activar')->name('usuario.activar');
            // *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--*
        });
        // ----------------------------------------------------------------------------------------
    });
    //===================================================================================================
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    Route::prefix('configuracion')->middleware([AdminEmp::class,Administrador::class])->group(function () {
        // ------------------------------------------------------------------------------------
        // Ruta Administrador del Sistema Areas
        Route::controller(AreaController::class)->prefix('areas')->group(function () {
            Route::get('', 'index')->name('areas.index');
            Route::get('crear', 'create')->name('areas.create');
            Route::get('editar/{id}', 'edit')->name('areas.edit');
            Route::post('guardar', 'store')->name('areas.store');
            Route::put('actualizar/{id}', 'update')->name('areas.update');
            Route::delete('eliminar/{id}', 'destroy')->name('areas.destroy');
            Route::get('getDependencias/{id}', 'getDependencias')->name('areas.getDependencias');
            Route::get('getAreas', 'getAreas')->name('areas.getAreas');
        });
        // ------------------------------------------------------------------------------------
        // Ruta Administrador del Sistema Cargos
        Route::controller(CargoController::class)->prefix('cargos')->group(function () {
            Route::get('', 'index')->name('cargos.index');
            Route::get('crear', 'create')->name('cargos.create');
            Route::get('editar/{id}', 'edit')->name('cargos.edit');
            Route::post('guardar', 'store')->name('cargos.store');
            Route::put('actualizar/{id}', 'update')->name('cargos.update');
            Route::delete('eliminar/{id}', 'destroy')->name('cargos.destroy');
            Route::get('getCargos', 'getCargos')->name('cargos.getCargos');
            Route::get('getCargosTodos', 'getCargosTodos')->name('cargos.getCargosTodos');
            Route::get('getAreas', 'getAreas')->name('cargos.getAreas');
        });
        // ----------------------------------------------------------------------------------------
        // Ruta Administrador del Sistema Empleados
        Route::controller(EmpleadoController::class)->prefix('empleados')->group(function () {
            Route::get('', 'index')->name('empleados.index');
            Route::get('crear', 'create')->name('empleados.create');
            Route::get('editar/{id}', 'edit')->name('empleados.edit');
            Route::post('guardar', 'store')->name('empleados.store');
            Route::put('actualizar/{id}', 'update')->name('empleados.update');
            Route::delete('eliminar/{id}', 'destroy')->name('empleados.destroy');
            Route::put('activar/{id}', 'activar')->name('empleados.activar');
            Route::get('getCargos', 'getCargos')->name('empleados.getCargos');
            // *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--*
            Route::get('getEmpresas', 'getEmpresas')->name('empleados.getEmpresas');
            Route::get('getAreas', 'getAreas')->name('empleados.getAreas');
            Route::get('getCargos', 'getCargos')->name('empleados.getCargos');
            Route::get('getEmpleados', 'getEmpleados')->name('empleados.getEmpleados');
            // *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--*
            Route::get('setCambioLiderProyecto', 'setCambioLiderProyecto')->name('empleados.setCambioLiderProyecto');
            Route::get('setCambioGeneralResponsabilidades', 'setCambioGeneralResponsabilidades')->name('empleados.setCambioGeneralResponsabilidades');
            // *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--*
            Route::get('setCambioRespComponente', 'setCambioRespComponente')->name('empleados.setCambioRespComponente');
            Route::get('setCambioRespTarea', 'setCambioRespTarea')->name('empleados.setCambioRespTarea');
            // *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--* *--*
            Route::get('setDeshabilitarEmpleado', 'setDeshabilitarEmpleado')->name('empleados.setDeshabilitarEmpleado');
        });
        // ----------------------------------------------------------------------------------------
        // Ruta Permisos Empleados
        Route::controller(PermisoEmpleadoController::class)->prefix('permisoscargos')->group(function () {
            Route::get('', 'index')->name('permisoscargos.index');
            Route::get('getAreas', 'getAreas')->name('permisoscargos.getAreas');
            Route::get('getCargos', 'getCargos')->name('permisoscargos.getCargos');
            Route::get('getEmpleadosCargos', 'getEmpleadosCargos')->name('permisoscargos.getEmpleadosCargos');
            Route::get('getCambioCargo', 'getCambioCargo')->name('permisoscargos.getCambioCargo');
            Route::get('setCambiopermisoEmpleado', 'setCambiopermisoEmpleado')->name('permisoscargos.setCambiopermisoEmpleado');
        });
        // ----------------------------------------------------------------------------------------
    });
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    Route::middleware(Empleado::class)->group(function () {
        // ------------------------------------------------------------------------------------
        // Ruta Administrador del Sistema Areas
        Route::controller(ProyectoController::class)->prefix('proyectos')->group(function () {
            Route::middleware(AdminSistema::class)->group(function () {
                Route::get('proyecto_empresas', 'proyecto_empresas')->name('proyectos.proyecto_empresas');
            });
            Route::get('', 'index')->name('proyectos.index');
            Route::get('crear', 'create')->name('proyectos.create');
            Route::get('editar/{id}', 'edit')->name('proyectos.edit');
            Route::get('detalle/{id}', 'show')->name('proyectos.detalle');
            Route::post('guardar', 'store')->name('proyectos.store');
            Route::put('actualizar/{id}', 'update')->name('proyectos.update');
            Route::delete('eliminar/{id}', 'destroy')->name('proyectos.destroy');
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            Route::get('gestion/{id}/{notificacion_id?}', 'gestion')->name('proyectos.gestion');
            Route::get('expotar_informeproyecto/{id}', 'expotar_informeproyecto')->name('proyectos.expotar_informeproyecto');
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            Route::get('getEmpresas', 'getEmpresas')->name('proyectos.getEmpresas');
            Route::get('getEmpleados', 'getEmpleados')->name('proyectos.getEmpleados');

            Route::get('getproyectos/{estado}/{config_empresa_id}', 'getproyectos')->name('proyectos.getproyectos');
        });
        // ------------------------------------------------------------------------------------
        Route::controller(ComponenteController::class)->prefix('componentes')->group(function () {
            Route::get('crear/{proyecto_id}', 'create')->name('componentes.create');
            Route::post('guardar/{proyecto_id}', 'store')->name('componentes.store');
            Route::get('editar/{id}', 'edit')->name('componentes.edit');
            Route::put('actualizar/{id}', 'update')->name('componentes.update');
            Route::get('reasignacionComponente', 'reasignacionComponente')->name('componentes.reasignacionComponente');
            Route::get('reasignacionComponenteMasivo', 'reasignacionComponenteMasivo')->name('componentes.reasignacionComponenteMasivo');
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
        });
        // ------------------------------------------------------------------------------------
        Route::controller(TareaController::class)->prefix('tareas')->group(function () {
            Route::get('gestion/{id}/{notificacion_id?}', 'gestion')->name('tareas.gestion');
            Route::get('crear/{componente_id}', 'create')->name('tareas.create');
            Route::post('guardar/{componente_id}', 'store')->name('tareas.store');
            Route::get('editar/{id}', 'edit')->name('tareas.edit');
            Route::put('actualizar/{id}', 'update')->name('tareas.update');
            // . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . . .
            Route::get('getapitareas/{componente_id}/{estado}', 'getapitareas')->name('tareas.getapitareas');
            // - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - - -
            Route::get('reasignacionTarea', 'reasignacionTarea')->name('tareas.reasignacionTarea');
            Route::get('getTareasEmpleadoGrupos', 'getTareasEmpleadoGrupos')->name('tareas.getTareasEmpleadoGrupos');
            Route::delete('eliminarTareasEmpleadoGrupos/{id}', 'destroyTareasEmpleadoGrupos')->name('tareas.destroyTareasEmpleadoGrupos');
            Route::post('crearEmplGrupoTareas/{empleado_id}', 'createEmplGrupoTareas')->name('tareas.createEmplGrupoTareas');
            Route::get('reasignacionGrupoTarea', 'reasignacionGrupoTarea')->name('tareas.reasignacionGrupoTarea');


        });
        // ------------------------------------------------------------------------------------
        Route::controller(HistorialController::class)->prefix('historiales')->group(function () {
            Route::get('crear/{id}', 'create')->name('historiales.create');
            Route::post('guardar', 'store_subtarea')->name('historiales.store_subtarea');
            Route::post('guardar', 'store')->name('historiales.store_tarea');
            Route::get('gestion/{id}', 'gestion')->name('historiales.gestion');
            Route::post('guardar_doc_hist', 'guardar_doc_hist')->name('historiales.guardar_doc_hist');
        });
        // ----------------------------------------------------------------------------------------
        // Ruta sub-tareas
        // ------------------------------------------------------------------------------------
        Route::controller(TareaController::class)->prefix('subtareas')->group(function () {
            Route::get('crear/{id}', 'subtareas_create')->name('subtareas.create');
            Route::post('guardar/{id}', 'subtareas_store')->name('subtareas.store');
            Route::get('gestion/{id}/{notificacion_id?}', 'subtareas_gestion')->name('subtareas.gestion');
            Route::get('getHistSubTarea', 'getHistSubTarea')->name('subtareas.getHistSubTarea');
        });
        // ----------------------------------------------------------------------------------------
        // ----------------------------------------------------------------------------------------
        // Ruta get-pryectos
        // ------------------------------------------------------------------------------------
        Route::controller(EmpleadoController::class)->prefix('empleados')->group(function () {
            Route::get('getproyectos', 'getproyectos')->name('empleados.getproyectos');
            Route::get('getproyectosLider', 'getproyectosLider')->name('empleados.getproyectosLider');
            Route::get('getTareas', 'getTareas')->name('empleados.getTareas');
            Route::get('getTareasVencidas', 'getTareasVencidas')->name('empleados.getTareasVencidas');
            Route::get('calendar_empleado', 'calendar_empleado')->name('empleados.calendar_empleado');
            Route::get('calendar_empleado_proy', 'calendar_empleado_proy')->name('empleados.calendar_empleado_proy');
            Route::get('getProyectosGraficosLider', 'getProyectosGraficosLider')->name('empleados.getProyectosGraficosLider');
            Route::get('getResponsabilidadesTotal', 'getResponsabilidadesTotal')->name('empleados.getResponsabilidadesTotal');
        });
        // ----------------------------------------------------------------------------------------
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
        Route::controller(ArchivoController::class)->prefix('archivo-modulo')->group(function () {
            Route::get('', 'index')->name('archivo-modulo.index');
            Route::controller(HojasDeVidaController::class)->prefix('hojas_vida')->group(function () {
                Route::get('', 'index')->name('hojas_vida.index');
                Route::get('archivo-hojas_de_vida/editar/{id}', 'edit')->name('hojas_vida.hojas_de_vida-editar');
                Route::get('archivo-hojas_de_vida/detalles/{id}', 'show')->name('hojas_vida.hojas_de_vida-detalles');
                Route::get('getUsuariosHojasVida','getUsuariosHojasVida')->name('getUsuariosHojasVida');
                Route::get('getUsuariosHojasVidaFormateado/{id}','getUsuariosHojasVidaFormateado')->name('getUsuariosHojasVidaFormateado');
                Route::get('getFiltrarUsuarioNombre','getFiltrarUsuarioNombre')->name('getFiltrarUsuarioNombre');
                Route::put('setCargoEmpleado','setCargoEmpleado')->name('hojas_vida.setCargoEmpleado');
                Route::put('setEmpleadodatos','setEmpleadodatos')->name('hojas_vida.setEmpleadodatos');
                Route::put('setEducacionEmpleadodatos','setEducacionEmpleadodatos')->name('hojas_vida.setEducacionEmpleadodatos');
                Route::post('addExperienciaLaboral', 'addExperienciaLaboral')->name('hojas_vida.addExperienciaLaboral');
                Route::delete('eliminarlaboralformal/{id}', 'eliminarlaboralformal')->name('hojas_vida.eliminarlaboralformal');
                Route::post('addExperienciaInformal', 'addExperienciaInformal')->name('hojas_vida.addExperienciaInformal');
                Route::delete('eliminarlaboralinformal/{id}', 'eliminarlaboralinformal')->name('hojas_vida.eliminarlaboralinformal');
                Route::get('getCargarMunicipios','getCargarMunicipios')->name('hojas_vida.getCargarMunicipios');

            });
            Route::controller(ManualesController::class)->prefix('manuales')->group(function () {
                Route::get('', 'index')->name('manuales.index');
                Route::get('getAreasManuales', 'getAreasManuales')->name('manuales.getAreasManuales');
                Route::post('addManual', 'addManual')->name('manuales.addManual');
                Route::delete('eliminarManual/{id}', 'eliminarManual')->name('manuales.eliminarManual');
            });
            Route::controller(SoportesAfiliacionController::class)->prefix('soportes_afiliacion')->group(function () {
                Route::get('', 'index')->name('soportes_afiliacion.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('hojas_vida.getCargarEmpleadosEmpresa');
                Route::post('setSoporteAfiliacion','setSoporteAfiliacion')->name('hojas_vida.setSoporteAfiliacion');
                Route::get('getSoporteAfiliacion','getSoporteAfiliacion')->name('hojas_vida.getSoporteAfiliacion');
                Route::delete('eliminarSoporte', 'destroy')->name('hojas_vida.eliminarSoporte');


            });
            Route::controller(DocumentosContractualesController::class)->prefix('documentos_contractuales')->group(function () {
                Route::get('', 'index')->name('documentos_contractuales.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('documentos_contractuales.getCargarEmpleadosEmpresa');
                Route::get('getDocumentosContractuales','getDocumentosContractuales')->name('documentos_contractuales.getDocumentosContractuales');
                Route::post('setDocumentosContractuales','setDocumentosContractuales')->name('documentos_contractuales.setDocumentosContractuales');
                Route::delete('eliminarDocumentosContractuales', 'destroy')->name('documentos_contractuales.eliminarDocumentosContractuales');
            });
            Route::controller(SitLabGenController::class)->prefix('sit_lab_gen')->group(function () {
                Route::get('', 'index')->name('sit_lab_gen.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('sit_lab_gen.getCargarEmpleadosEmpresa');
                Route::get('getDocumentosContractuales','getDocumentosContractuales')->name('sit_lab_gen.getDocumentosContractuales');
                Route::post('setDocumentosContractuales','setDocumentosContractuales')->name('sit_lab_gen.setDocumentosContractuales');
                Route::delete('eliminarDocumentosContractuales', 'destroy')->name('sit_lab_gen.eliminarDocumentosContractuales');
            });
            Route::controller(HistClinicasOcupController::class)->prefix('histclinicasocup')->group(function () {
                Route::get('', 'index')->name('histclinicasocup.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('histclinicasocup.getCargarEmpleadosEmpresa');
                Route::get('getSoportes','getSoportes')->name('histclinicasocup.getSoportes');
                Route::post('setSoportes','setSoportes')->name('histclinicasocup.setSoportes');
                Route::delete('eliminarSoportes', 'destroy')->name('histclinicasocup.eliminarSoportes');
            });
            Route::controller(DotacionesController::class)->prefix('dotaciones')->group(function () {
                Route::get('', 'index')->name('dotaciones.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('dotaciones.getCargarEmpleadosEmpresa');
                Route::get('getSoportes','getSoportes')->name('dotaciones.getSoportes');
                Route::post('setSoportes','setSoportes')->name('dotaciones.setSoportes');
                Route::delete('eliminarSoportes', 'destroy')->name('dotaciones.eliminarSoportes');
            });
            Route::controller(ProcesoDiscipController::class)->prefix('proceso_discip')->group(function () {
                Route::get('', 'index')->name('proceso_discip.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('proceso_discip.getCargarEmpleadosEmpresa');
                Route::get('getSoportes','getSoportes')->name('proceso_discip.getSoportes');
                Route::post('setSoportes','setSoportes')->name('proceso_discip.setSoportes');
                Route::delete('eliminarSoportes', 'destroy')->name('proceso_discip.eliminarSoportes');
            });
            Route::controller(EvaluacionDesempController::class)->prefix('evaluacion_desemp')->group(function () {
                Route::get('', 'index')->name('evaluacion_desemp.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('evaluacion_desemp.getCargarEmpleadosEmpresa');
                Route::get('getSoportes','getSoportes')->name('evaluacion_desemp.getSoportes');
                Route::post('setSoportes','setSoportes')->name('evaluacion_desemp.setSoportes');
                Route::delete('eliminarSoportes', 'destroy')->name('evaluacion_desemp.eliminarSoportes');
            });
            Route::controller(VacacionesController::class)->prefix('vacaciones')->group(function () {
                Route::get('', 'index')->name('vacaciones.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('vacaciones.getCargarEmpleadosEmpresa');
                Route::get('getSoportes','getSoportes')->name('vacaciones.getSoportes');
                Route::post('setSoportes','setSoportes')->name('vacaciones.setSoportes');
                Route::delete('eliminarSoportes', 'destroy')->name('vacaciones.eliminarSoportes');
            });
            Route::controller(DocRetiroController::class)->prefix('doc_retiro')->group(function () {
                Route::get('', 'index')->name('doc_retiro.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('doc_retiro.getCargarEmpleadosEmpresa');
                Route::get('getSoportes','getSoportes')->name('doc_retiro.getSoportes');
                Route::post('setSoportes','setSoportes')->name('doc_retiro.setSoportes');
                Route::delete('eliminarSoportes', 'destroy')->name('doc_retiro.eliminarSoportes');
            });
            Route::controller(CapacitacionController::class)->prefix('capacitacion')->group(function () {
                Route::get('', 'index')->name('capacitacion.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('capacitacion.getCargarEmpleadosEmpresa');
                Route::get('getSoportes','getSoportes')->name('capacitacion.getSoportes');
                Route::post('setSoportes','setSoportes')->name('capacitacion.setSoportes');
                Route::delete('eliminarSoportes', 'destroy')->name('capacitacion.eliminarSoportes');
            });
            Route::controller(PoliticaController::class)->prefix('politica')->group(function () {
                Route::get('', 'index')->name('politica.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('politica.getCargarEmpleadosEmpresa');
                Route::get('getSoportes','getSoportes')->name('politica.getSoportes');
                Route::post('setSoportes','setSoportes')->name('politica.setSoportes');
                Route::delete('eliminarSoportes', 'destroy')->name('politica.eliminarSoportes');
            });
            Route::controller(DiagnosticosController::class)->prefix('diagnosticos')->group(function () {
                Route::get('', 'index')->name('diagnosticos.index');
            });
            Route::controller(ClienteController::class)->prefix('cliente')->group(function () {
                Route::get('', 'index')->name('cliente.index');
            });
            Route::controller(ProveedoresController::class)->prefix('proveedores')->group(function () {
                Route::get('', 'index')->name('proveedores.index');
            });
            Route::controller(PermisosArchivoController::class)->prefix('permisosarchivo')->group(function () {
                Route::get('', 'index')->name('permisosarchivo.index');
                Route::get('getCargarEmpleadosEmpresa','getCargarEmpleadosEmpresa')->name('permisosarchivo.getCargarEmpleadosEmpresa');
                Route::get('getPermisosEmpleado','getPermisosEmpleado')->name('permisosarchivo.getPermisosEmpleado');
            });
        });
        // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    });

    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *

    Route::get('/getEmpleadosChat', [IntranetPageController::class, 'getEmpleadosChat'])->name('getEmpleadosChat');
    Route::get('/getMensajesNuevosEmpleadosChat', [IntranetPageController::class, 'getMensajesNuevosEmpleadosChat'])->name('getMensajesNuevosEmpleadosChat');
    Route::post('/setNuevoMensaje', [IntranetPageController::class, 'setNuevoMensaje'])->name('setNuevoMensaje');
    Route::get('/getMensajesChatUsuario', [IntranetPageController::class, 'getMensajesChatUsuario'])->name('getMensajesChatUsuario');
    Route::get('/getMensajesNuevosDestinatarioChat', [IntranetPageController::class, 'getMensajesNuevosDestinatarioChat'])->name('getMensajesNuevosDestinatarioChat');
    // * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * * *
    Route::get('/getNotificacionesEmpleado', [IntranetPageController::class, 'getNotificacionesEmpleado'])->name('getNotificacionesEmpleado');
});

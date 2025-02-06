<?php

namespace Database\Seeders;

use App\Models\Config\Menu;
use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaMenuSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('menus')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('menu_rol')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        // ========== ========== ========== ========== ========== ========== ========== ========== ========== ========== ========== ==========
        $menus = [
            //Menu Inicio
            ['nombre' => 'Inicio', 'menu_id' => null, 'url' => '/dashboard', 'orden' => '1', 'icono' => 'fas fa-home', 'Array_1' => []],
            //Menu configuración 2
            ['nombre' => 'Sistema','menu_id' => null,'url' => '#','orden' => '2','icono' => 'fas fa-tools','Array_1' => [
                    //Menu menu
                    ['nombre' => 'Menús', 'menu_id' => '2',  'url' =>  'configuracion_sis/menu', 'orden' => '1',  'icono' => 'fas fa-list-ul', 'Array_1' => []],
                    //Menu Roles
                    ['nombre' => 'Roles Usuarios', 'menu_id' => '2',  'url' =>  'configuracion_sis/rol', 'orden' => '2',  'icono' => 'fas fa-user-tag', 'Array_1' => []],
                    //Menu Menu_Roles
                    ['nombre' => 'Menú - Roles', 'menu_id' => '2',  'url' =>  'configuracion_sis/menu_rol', 'orden' => '2',  'icono' => 'fas fa-chalkboard-teacher', 'Array_1' => []],
                    //Menu permisos
                    ['nombre' => 'Permisos', 'menu_id' => '2',  'url' =>  'configuracion_sis/permiso_rutas', 'orden' => '2',  'icono' => 'fas fa-lock', 'Array_1' => []],
                    //Menu permisos-rol
                    ['nombre' => 'Permisos -Rol', 'menu_id' => '2',  'url' =>  'configuracion_sis/_permiso-rol', 'orden' => '2',  'icono' => 'fas fa-user-lock', 'Array_1' => []],
                    //Menu Empresas
                    ['nombre' => 'Empresas', 'menu_id' => '2',  'url' =>  'configuracion_sis/empresa', 'orden' => '2',  'icono' => 'fas fa-user-lock', 'Array_1' => []],
                    //Menu Usuarios
                    ['nombre' => 'Usuarios', 'menu_id' => '2',  'url' =>  'configuracion_sis/usuarios', 'orden' => '2',  'icono' => 'fas fa-user-friends', 'Array_1' => []],

                ],
            ],

            //Menu Parametrización
            ['nombre' => 'Parametrización','menu_id' => null,'url' => '#','orden' => '2','icono' => 'fas fa-cogs','Array_1' => [
                    //Menu Juzgados
                    ['nombre' => 'Parametros Juzgados', 'menu_id' => null,  'url' =>  '#', 'orden' => '1',  'icono' => 'fas fa-balance-scale', 'Array_1' => [
                        //Menu Jurisdiccion Juzgados
                        ['nombre' => 'Jurisdiccion Juzgados', 'menu_id' => '2',  'url' =>  'admin/jurisdiccion_juzgado', 'orden' => '2',  'icono' => 'fas fa-globe-americas', 'Array_1' => []],
                        //Menu Departamentos Juzgados
                        ['nombre' => 'Departamentos Juzgados', 'menu_id' => '2',  'url' =>  'admin/departamento_juzgado', 'orden' => '2',  'icono' => 'as fa-map-marked', 'Array_1' => []],
                        //Menu Distritos Juzgados
                        ['nombre' => 'Distritos Juzgados', 'menu_id' => '2',  'url' =>  'admin/distrito_juzgado', 'orden' => '2',  'icono' => 'fas fa-code-branch', 'Array_1' => []],
                        //Menu Circuitos Juzgados
                        ['nombre' => 'Circuitos Juzgados', 'menu_id' => '2',  'url' =>  'admin/circuito_juzgado', 'orden' => '2',  'icono' => 'far fa-copyright', 'Array_1' => []],
                        //Menu Municipios Juzgados
                        ['nombre' => 'Municipios Juzgados', 'menu_id' => '2',  'url' =>  'admin/municipio_juzgado', 'orden' => '2',  'icono' => 'fas fa-archway', 'Array_1' => []],
                        //Menu Juzgados
                        ['nombre' => 'Juzgados', 'menu_id' => '2',  'url' =>  'admin/juzgado', 'orden' => '2',  'icono' => 'fas fa-university', 'Array_1' => []],

                    ]],
                    //Menu Procesos
                    ['nombre' => 'Parametros Procesos', 'menu_id' => null,  'url' =>  '#', 'orden' => '2',  'icono' => 'fas fa-copy', 'Array_1' => [
                        //Tipos de Procesos
                        ['nombre' => 'Tipos de Procesos', 'menu_id' => '2',  'url' =>  'admin/tipo_proceso', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],
                        //Papel Cliente
                        ['nombre' => 'Papel Cliente', 'menu_id' => '2',  'url' =>  'admin/papel_cliente', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],
                        //Estado Procesos
                        ['nombre' => 'Estado Procesos', 'menu_id' => '2',  'url' =>  'admin/estado_proceso', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],
                        //Etapa Procesos
                        ['nombre' => 'Etapa Procesos', 'menu_id' => '2',  'url' =>  'admin/etapa_proceso', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],
                        //Riesgo Perdida Procesos
                        ['nombre' => 'Riesgo Perdida Procesos', 'menu_id' => '2',  'url' =>  'admin/riesgo_perdida_proceso', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],
                        //Sentidos de Fallo Procesos
                        ['nombre' => 'Sentidos de Fallo Procesos', 'menu_id' => '2',  'url' =>  'admin/sentido_fallo_proceso', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],
                        //Terminación Anormal Procesos
                        ['nombre' => 'Terminación Anormal Procesos', 'menu_id' => '2',  'url' =>  'admin/terminacion_anormal', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],
                    ]],
                    //Menu Parametro H.V.
                    ['nombre' => 'Parametro H.V.', 'menu_id' => null,  'url' =>  'admin/param_hojas_de_vida', 'orden' => '2',  'icono' => 'far fa-id-card', 'Array_1' => []],

                ],
            ],
            //Menu Procesos
            ['nombre' => 'Procesos', 'menu_id' => null,  'url' =>  '#', 'orden' => '2',  'icono' => 'fas fa-gavel', 'Array_1' => [
                //Menu Listado Porcesos
                ['nombre' => 'Listado Porcesos', 'menu_id' => '2',  'url' =>  'admin/procesos_listado', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],
                //Menu Crear Proceso
                ['nombre' => 'Crear Proceso', 'menu_id' => '2',  'url' =>  'admin/crear_proceso', 'orden' => '2',  'icono' => 'fas fa-caret-right', 'Array_1' => []],

            ]],
            //Noticias
            ['nombre' => 'Noticias', 'menu_id' => null, 'url' => 'admin/noticias', 'orden' => '1', 'icono' => 'fas fa-newspaper', 'Array_1' => []],

            //Archivo
            ['nombre' => 'Archivo', 'menu_id' => null, 'url' => 'admin/archivo', 'orden' => '1', 'icono' => 'far fa-folder-open', 'Array_1' => []],

            //Proyectos
            ['nombre' => 'Proyectos', 'menu_id' => null, 'url' => 'admin/proyectos', 'orden' => '1', 'icono' => 'fas fa-project-diagram', 'Array_1' => []],

            //Boletines Antiguos
            ['nombre' => 'Boletines Antiguos', 'menu_id' => null, 'url' => 'admin/boletines', 'orden' => '1', 'icono' => 'fas fa-book', 'Array_1' => []],

            //Consultas/Solicitudes
            ['nombre' => 'Consultas/Solicitudes', 'menu_id' => null, 'url' => 'admin/consultas_solicitudes', 'orden' => '1', 'icono' => 'far fa-hand-paper', 'Array_1' => []],

            //Diagnosticos Legales
            ['nombre' => 'Diagnosticos Legales', 'menu_id' => null, 'url' => 'admin/diagnosticos', 'orden' => '1', 'icono' => 'fas fa-chart-line', 'Array_1' => []],

        ];
        // ========== ========== ========== ========== ========== ========== ========== ========== ========== ========== ========== ==========
        $x = 0;
        foreach ($menus as $menu) {
            $x++;
            $menu_new = Menu::create([
                'menu_id' => $menu['menu_id'],
                'nombre' => utf8_encode(utf8_decode($menu['nombre'])),
                'url' => $menu['url'],
                'orden' => $x,
                'icono' => $menu['icono'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            if (count($menu['Array_1']) > 0) {
                $this->sub_menu($menu['Array_1'], $menu_new->id);
            }
        }
        // ========== ========== ========== ========== ========== ========== ========== ========== ========== ========== ========== ==========
        // -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * --
        $menus = Menu::get();
        // -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * -- * --
        foreach ($menus as $menu) {
            DB::table('menu_rol')->insert(['menu_id' => $menu->id, 'rol_id' => 1,]);
        }
    }
    public function sub_menu($Array_1, $x)
    {
        $y = 0;
        foreach ($Array_1 as $sub_menu_array) {
            $y++;
            $sub_menu = Menu::create([
                'menu_id' => $x,
                'nombre' => utf8_encode(utf8_decode($sub_menu_array['nombre'])),
                'url' => $sub_menu_array['url'],
                'orden' => $y,
                'icono' => $sub_menu_array['icono'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
            if (count($sub_menu_array['Array_1']) > 0) {
                $this->sub_menu($sub_menu_array['Array_1'], $sub_menu->id);
            }
        }
    }
}

<?php

namespace Database\Seeders;

use App\Models\User;
// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // User::factory(10)->create();

        $this->call([
            TablaTipoDocumentos::class,
            TablaRoles::class,
            TablaMenuSeeder::class,
            TablaGruposEmpresas::class,
            Tabla_Empresas::class,
            TablaAreas::class,
            TablaCargos::class,
            TablaUser::class,
            TablaProyectos::class,
            TablaComponentes::class,
            TablaTareas::class,
            TablaOpcionArchivo::class,
            TablaTipoEducacion::class,
            TablaPais::class,
            TablaDepartamentos::class,
            TablaMunicipios::class,

        ]);
    }
}

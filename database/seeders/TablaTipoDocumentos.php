<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaTipoDocumentos extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('tipo_documentos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $tipos = [
            ['abreb_id' => 'CC', 'tipo_id' => 'Cedula de ciudadania'],
            ['abreb_id' => 'CE', 'tipo_id' => 'Cedula de extranjeria'],
            ['abreb_id' => 'PA', 'tipo_id' => 'Pasaporte'],
            ['abreb_id' => 'RC', 'tipo_id' => 'Registro Civil'],
            ['abreb_id' => 'TI', 'tipo_id' => 'Tarjeta de identidad'],
            ['abreb_id' => 'NIT', 'tipo_id' => 'Num Identif  Tributaria'],
            ['abreb_id' => 'PEP', 'tipo_id' => 'Permiso Especial de Permanencia'],
            ['abreb_id' => 'TMF', 'tipo_id' => 'Tarjeta de Movilidad Fronteriza'],
        ];
        foreach ($tipos as $item) {
            DB::table('tipo_documentos')->insert([
                'abreb_id' => $item['abreb_id'],
                'tipo_id' => $item['tipo_id'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}

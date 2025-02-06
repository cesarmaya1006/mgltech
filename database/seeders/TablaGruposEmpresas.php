<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaGruposEmpresas extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('emp_grupos')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');
        // ===================================================================================
        $datas = [
            [
                'tipo_documento_id' => 6,
                'identificacion' => '111000222333',
                'grupo' => 'Grupo Mas DYM',
                'email' => 'masdym@gmail.com',
                'telefono' => '3509875421',
                'direccion' => 'Calle 76 # 13-02',
                'contacto' => 'Miguel Rodriguez',
                'cargo' => 'Administrador',
                'logo' => 'images.jpeg',

            ],
            [
                'tipo_documento_id' => 6,
                'identificacion' => '333222111000',
                'grupo' => 'Grupo M',
                'email' => 'mmm@gmail.com',
                'telefono' => '3201234578',
                'direccion' => 'Calle 76 # 14-03',
                'contacto' => 'Juana Suarez',
                'cargo' => 'Gerente',
                'logo' => 'empresa1.png',

            ],
        ];
        // ===================================================================================
        foreach ($datas as $data) {
            DB::table('emp_grupos')->insert([
                'tipo_documento_id' => $data['tipo_documento_id'],
                'identificacion' => $data['identificacion'],
                'grupo' => $data['grupo'],
                'email' => $data['email'],
                'telefono' => $data['telefono'],
                'direccion' => $data['direccion'],
                'contacto' => $data['contacto'],
                'cargo' => $data['cargo'],
                'logo' => $data['logo'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}

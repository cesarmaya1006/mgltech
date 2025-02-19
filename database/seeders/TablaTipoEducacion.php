<?php

namespace Database\Seeders;

use Carbon\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class TablaTipoEducacion extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::statement('SET FOREIGN_KEY_CHECKS = 0;');
        DB::table('tipo_educacion')->truncate();
        DB::statement('SET FOREIGN_KEY_CHECKS = 1;');

        $tipos = [
            ['tipo' => 'Educación Básica'],
            ['tipo' => 'Educación Superior'],
            ['tipo' => 'Otra Educación'],
        ];
        foreach ($tipos as $item) {
            DB::table('tipo_educacion')->insert([
                'tipo' => $item['tipo'],
                'created_at' => Carbon::now()->format('Y-m-d H:i:s'),
            ]);
        }
    }
}

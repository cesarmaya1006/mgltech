<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('experiencia_ind', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id', 'fk_empleado_experiencia-ind')->references('id')->on('empleados')->onDelete('restrict')->onUpdate('restrict');
            $table->string('tipo_entidad', 255);
            $table->string('entidad', 255);
            $table->string('actividad', 255);
            $table->string('producto', 255);
            $table->string('pais', 255);
            $table->string('departamento', 255)->nullable();
            $table->string('municipio', 255)->nullable();
            $table->string('direccion', 255);
            $table->string('telefono', 255);
            $table->date('fecha_inicio');
            $table->date('fecha_termino')->nullable();
            $table->string('tipo_contrato', 255);
            $table->string('observaciones', 255);
            $table->string('soporte', 255)->nullable();
            $table->timestamps();
            $table->charset = 'utf8';
            $table->collation = 'utf8_spanish_ci';
        });
    }


    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('experiencia_ind');
    }
};

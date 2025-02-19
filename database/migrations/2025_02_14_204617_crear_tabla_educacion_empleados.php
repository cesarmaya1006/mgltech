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
        Schema::create('educacion_empleados', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id', 'fk_empleado_edubasica')->references('id')->on('empleados')->onDelete('restrict')->onUpdate('restrict');
            $table->unsignedBigInteger('tipo_id');
            $table->foreign('tipo_id', 'fk_tipo_educacion')->references('id')->on('tipo_educacion')->onDelete('restrict')->onUpdate('restrict');
            $table->string('estado', 255);
            $table->string('ultimo_cursado', 255);
            $table->string('titulo', 255);
            $table->string('establecimiento', 255);
            $table->string('tarjeta_prof', 255)->nullable();
            $table->string('cant_horas', 255)->nullable();
            $table->date('fecha_inicio');
            $table->date('fecha_termino')->nullable();
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
        Schema::dropIfExists('educacion_empleados');
    }
};

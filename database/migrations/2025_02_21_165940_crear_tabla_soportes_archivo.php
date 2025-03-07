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
        Schema::create('soportes_archivo', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id', 'fk_empleado_soportes_archivo')->references('id')->on('empleados')->onDelete('restrict')->onUpdate('restrict');
            $table->string('tipo', 255);
            $table->string('titulo');
            $table->string('url');
            $table->double('peso');
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
        Schema::dropIfExists('soportes_archivo');
    }
};

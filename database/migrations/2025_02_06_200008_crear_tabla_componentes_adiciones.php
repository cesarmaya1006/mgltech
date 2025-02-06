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
        Schema::create('componentes_adiciones', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->unsignedBigInteger('empleado_id');
            $table->foreign('empleado_id', 'fk_empleado_componente_adicion')->references('id')->on('empleados')->onDelete('cascade')->onUpdate('cascade');
            $table->unsignedBigInteger('componente_id')->nullable();
            $table->foreign('componente_id', 'fk_componente_adicion')->references('id')->on('componentes')->onDelete('cascade')->onUpdate('cascade');
            $table->double('adicion');
            $table->date('fecha');
            $table->longText('justificacion');
            $table->boolean('estado')->default(0);
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
        Schema::dropIfExists('componentes_adiciones');
    }
};

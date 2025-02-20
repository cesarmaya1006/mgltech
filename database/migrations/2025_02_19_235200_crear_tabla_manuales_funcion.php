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
        Schema::create('manuales_funcion', function (Blueprint $table) {
            $table->bigIncrements('id')->autoIncrement();
            $table->foreign('id', 'fk_cargo_maual')->references('id')->on('cargos')->onDelete('cascade')->onUpdate('cascade');
            $table->string('titulo');
            $table->string('url');
            $table->double('peso');
            $table->boolean('estado')->default(1);
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
        Schema::dropIfExists('manuales_funcion');
    }
};

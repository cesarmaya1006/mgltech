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
        Schema::create('menu_rol', function (Blueprint $table) {
            $table->unsignedBigInteger('menu_id');
            $table->foreign('menu_id', 'fk_cmr_configmenu')->references('id')->on('menus')->onDelete('cascade')->onUpdate('restrict');
            $table->unsignedBigInteger('rol_id');
            $table->foreign('rol_id', 'fk_cmr_configrol')->references('id')->on('roles')->onDelete('cascade')->onUpdate('restrict');
            $table->unique(['menu_id','rol_id'],'cmr_unico');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu_rol');
    }
};

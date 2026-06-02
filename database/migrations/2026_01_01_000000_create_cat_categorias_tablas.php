<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_categoria_zona', function (Blueprint $table) {
            $table->bigIncrements('idCategoriaZona');
            $table->string('tipoZona', 100);
            $table->string('descripcion', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('cat_categoria_carga', function (Blueprint $table) {
            $table->bigIncrements('idCategoriaCarga');
            $table->string('tipoZona', 100);
            $table->string('descripcion', 255)->nullable();
            $table->timestamps();
        });

        Schema::create('cat_categoria_mov', function (Blueprint $table) {
            $table->bigIncrements('idCategoriaMov');
            $table->string('tipoZona', 100);
            $table->string('descripcion', 255)->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cat_categoria_mov');
        Schema::dropIfExists('cat_categoria_carga');
        Schema::dropIfExists('cat_categoria_zona');
    }
};
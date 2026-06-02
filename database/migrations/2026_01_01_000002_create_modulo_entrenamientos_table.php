<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cat_ejercicio', function (Blueprint $table) {
            $table->bigIncrements('idEjercicio');
            $table->unsignedBigInteger('idEtapas');
            $table->unsignedBigInteger('idCategoriaZona');
            $table->unsignedBigInteger('idCategoriaCarga');
            $table->unsignedBigInteger('idCategoriaMov');
            $table->string('ejercicio', 100);
            $table->string('descripcion', 100)->nullable();
            $table->tinyInteger('activo')->default(1);
            $table->timestamps();
            
            $table->foreign('idEtapas')->references('idEtapas')->on('cat_etapas')->onDelete('cascade');
            $table->foreign('idCategoriaZona')->references('idCategoriaZona')->on('cat_categoria_zona')->onDelete('cascade');
            $table->foreign('idCategoriaCarga')->references('idCategoriaCarga')->on('cat_categoria_carga')->onDelete('cascade');
            $table->foreign('idCategoriaMov')->references('idCategoriaMov')->on('cat_categoria_mov')->onDelete('cascade');
        });

        Schema::create('programacion', function (Blueprint $table) {
            $table->bigIncrements('idProgramacion');
            $table->unsignedBigInteger('idUsuario');
            $table->date('fecha');
            $table->enum('diaPlan', ['LUNES', 'MARTES', 'MIERCOLES', 'JUEVES', 'VIERNES', 'SABADO']);
            $table->timestamps();

            $table->foreign('idUsuario')->references('idUsuario')->on('tbl_usuarios')->onDelete('cascade');
        });

        Schema::create('conf_prog', function (Blueprint $table) {
            $table->bigIncrements('idConfProg');
            $table->unsignedBigInteger('idProgramacion');
            $table->unsignedBigInteger('idEtapas');
            $table->string('tiposEntrenamientos', 100)->nullable();
            $table->text('descripcion')->nullable();
            $table->integer('rounds')->nullable();
            $table->time('tiempoTotal')->nullable();
            $table->time('tiempoTrabajo')->nullable();
            $table->time('tiempoDescanso')->nullable();
            $table->time('tiempoEj')->nullable();
            $table->integer('repInicio')->nullable();
            $table->integer('repEj')->nullable();
            $table->timestamps();

            $table->foreign('idProgramacion')->references('idProgramacion')->on('programacion')->onDelete('cascade');
            $table->foreign('idEtapas')->references('idEtapas')->on('cat_etapas')->onDelete('cascade');
        });

        Schema::create('prog_ej_detalle', function (Blueprint $table) {
            $table->bigIncrements('idDetalle');
            $table->unsignedBigInteger('idConfProg');
            $table->unsignedBigInteger('idEjercicio');
            $table->integer('orden')->default(1);
            $table->string('series', 50)->nullable();
            $table->string('reps', 50)->nullable();
            $table->string('pesoInicial', 50)->nullable();
            $table->string('pesoFinal', 50)->nullable();
            $table->text('nota')->nullable();
            $table->timestamps();

            $table->foreign('idConfProg')->references('idConfProg')->on('conf_prog')->onDelete('cascade');
            $table->foreign('idEjercicio')->references('idEjercicio')->on('cat_ejercicio')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('prog_ej_detalle');
        Schema::dropIfExists('conf_prog');
        Schema::dropIfExists('programacion');
        Schema::dropIfExists('cat_ejercicio');
    }
};
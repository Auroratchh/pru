<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function ConfProg(): void
    {
        Schema::create('conf_prog', function (Blueprint $table) {
            $table->id();
            $table->string('tiposEntrenamiento')->comment('AMRAP, TABATA, EMOM, FOR TIME, CIRCUIT');
            $table->string('descripcion');
            $table->integer('rounds');
            $table->timestamp('tiempoTotal');
            $table->timestamp('tiempoTrabajo');
            $table->timestamp('tiempoDescanso');
            $table->timestamp('tiempoEj');
            $table->integer('repInicio');
            $table->integer('repEj');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('conf_prog');
    }
};
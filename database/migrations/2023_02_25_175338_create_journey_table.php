<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('journey', function (Blueprint $table) {
            $table->id();
            $table->string("origin");
            $table->string("destiny");
            $table->dateTime("datetime_start");
            $table->dateTime("datetime_end");
            $table->integer("quotas");
            $table->double("price");
            $table->enum("status", ['DISPONIBLE', 'COMPLETO', 'EN CURSO', 'CANCELADO', 'FINALIZADO']);
            $table->string("description");
            $table->string('vehicle_plate');
            $table->foreign("vehicle_plate")->references("plate")->on("vehicle")->onUpdate("cascade")->onDelete("restrict");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('journey');
    }
};

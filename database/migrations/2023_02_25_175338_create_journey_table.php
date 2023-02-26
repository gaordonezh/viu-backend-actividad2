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
            $table->date("datetime_start");
            $table->date("datetime_end");
            $table->integer("quotas");
            $table->double("price");
            $table->enum("status", ['DISPONIBLE', 'COMPLETO', 'EN CURSO', 'CANCELADO', 'FINALIZADO']);
            $table->string("description");
            $table->unsignedBigInteger('vehicle_id');
            $table->foreign("vehicle_id")->references("id")->on("vehicle")->onUpdate("cascade")->onDelete("restrict");
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

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
            $table->string("origin")->nullable(false);
            $table->string("destiny")->nullable(false);
            $table->dateTime("datetime_start")->nullable(false);
            $table->dateTime("datetime_end")->nullable(false);
            $table->integer("quotas")->nullable(false);
            $table->double("price")->nullable(false);
            $table->enum("status", ['DISPONIBLE', 'COMPLETO', 'EN CURSO', 'CANCELADO', 'FINALIZADO'])->nullable(false)->default('DISPONIBLE');
            $table->string("description")->nullable(false);
            $table->string('vehicle_plate')->nullable(false);
            $table->foreign("vehicle_plate")->references("plate")->on("vehicle")->onUpdate("cascade")->onDelete("restrict");
            $table->timestamps();
            $table->softDeletes();
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

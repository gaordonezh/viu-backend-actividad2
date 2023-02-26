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
        Schema::create('vehicle_document', function (Blueprint $table) {
            $table->id();
            $table->string("name");
            $table->string("url");
            $table->string("extension");
            $table->boolean("is_valid")->default(true);
            $table->string('vehicle_plate');
            $table->foreign("vehicle_plate")->references("plate")->on("vehicle")->onUpdate("cascade")->onDelete("cascade");
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
        Schema::dropIfExists('vehicle_document');
    }
};

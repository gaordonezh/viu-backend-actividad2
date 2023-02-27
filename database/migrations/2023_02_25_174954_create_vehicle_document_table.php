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
            $table->string("name")->nullable(false);
            $table->string("url")->nullable(false);
            $table->string("extension")->nullable(false);
            $table->boolean("is_valid")->default(false);
            $table->string('vehicle_plate')->nullable(false);
            $table->foreign("vehicle_plate")->references("plate")->on("vehicle")->onUpdate("cascade")->onDelete("cascade");
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
        Schema::dropIfExists('vehicle_document');
    }
};

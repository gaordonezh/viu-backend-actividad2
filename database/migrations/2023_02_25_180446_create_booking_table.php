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
        Schema::create('booking', function (Blueprint $table) {
            $table->unsignedBigInteger('journey_id');
            $table->foreign("journey_id")->references("id")->on("journey")->onUpdate("cascade")->onDelete("restrict");
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references("id")->on("user")->onUpdate("cascade")->onDelete("restrict");
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
        Schema::dropIfExists('booking');
    }
};

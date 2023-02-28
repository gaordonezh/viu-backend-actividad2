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
        Schema::create('qualification', function (Blueprint $table) {
            $table->id();
            $table->integer("stars");
            $table->string("comment");
            $table->unsignedBigInteger('journey_id');
            $table->foreign("journey_id")->references("id")->on("journey")->onUpdate("cascade")->onDelete("cascade");
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references("id")->on("user")->onUpdate("cascade")->onDelete("restrict");
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
        Schema::dropIfExists('qualification');
    }
};

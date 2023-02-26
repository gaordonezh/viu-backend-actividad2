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
        Schema::create('vehicle', function (Blueprint $table) {
            $table->string("plate")->primary()->unique()->nullable(false);
            $table->enum("type", ["CARRO", "MOTO", "BUS", "MICROBUS"])->nullable(false);
            $table->string("brand")->nullable(false);
            $table->string("reference")->nullable(false);
            $table->string("model", 5)->nullable(false);
            $table->string("color", 20)->nullable(false);
            $table->integer("ability")->nullable(false);
            $table->boolean("is_active")->default(true)->nullable(false);
            $table->unsignedBigInteger('user_id')->nullable(false);
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
        Schema::dropIfExists('vehicle');
    }
};

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
            $table->id();
            $table->string("plate")->unique();
            $table->enum("type", ["CARRO", "MOTO", "BUS", "MICROBUS"]);
            $table->string("brand");
            $table->string("reference");
            $table->string("model", 5);
            $table->string("color", 20);
            $table->integer("ability");
            $table->boolean("is_active")->default(true);
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
        Schema::dropIfExists('vehicle');
    }
};

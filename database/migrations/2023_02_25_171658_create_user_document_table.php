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
        Schema::create('user_document', function (Blueprint $table) {
            $table->id();
            $table->string("filename");
            $table->string("url");
            $table->string("extension");
            $table->unsignedBigInteger('user_id');
            $table->foreign("user_id")->references("id")->on("user")->onUpdate("cascade")->onDelete("cascade");
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
        Schema::dropIfExists('user_document');
    }
};

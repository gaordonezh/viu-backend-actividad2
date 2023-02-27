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
        Schema::create('user', function (Blueprint $table) {
            $table->id();
            $table->string("ndoc")->unique();
            $table->enum("tdoc", ["DNI", "CARNET EXT", "RUC", "PASAPORTE"]);
            $table->string("first_name");
            $table->string("last_name");
            $table->string("phone");
            $table->string('email')->unique();
            $table->string('password');
            $table->boolean("is_active")->default(true);
            $table->unsignedBigInteger('address_id');
            $table->foreign("address_id")->references("id")->on("address")->onUpdate("cascade")->onDelete("restrict");
            $table->unsignedBigInteger('role_id');
            $table->foreign("role_id")->references("id")->on("role")->onUpdate("cascade")->onDelete("restrict");
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
        Schema::dropIfExists('user');
    }
};

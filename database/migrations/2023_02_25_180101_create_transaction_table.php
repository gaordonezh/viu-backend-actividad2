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
        Schema::create('transaction', function (Blueprint $table) {
            $table->id();
            $table->double("amount");
            $table->boolean("isDiscount");
            $table->date("date");
            $table->unsignedBigInteger('journey_id');
            $table->foreign("journey_id")->references("id")->on("journey")->onUpdate("cascade")->onDelete("restrict");
            $table->unsignedBigInteger('account_id');
            $table->foreign("account_id")->references("id")->on("account")->onUpdate("cascade")->onDelete("restrict");
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
        Schema::dropIfExists('transaction');
    }
};

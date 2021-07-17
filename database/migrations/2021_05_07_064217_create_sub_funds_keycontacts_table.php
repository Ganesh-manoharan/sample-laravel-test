<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubFundsKeycontactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_funds_keycontacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('sub_funds_id');
            $table->foreign('sub_funds_id')->references('id')->on('sub_funds');
            $table->string('name')->nullable();
            $table->string('email')->unique()->nullable();
            $table->string('phone_number')->nullable();
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
        Schema::dropIfExists('sub_funds_keycontacts');
    }
}

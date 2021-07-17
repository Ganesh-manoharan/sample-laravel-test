<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundsKeycontactsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funds_keycontacts', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fund_group_id');
            $table->foreign('fund_group_id')->references('id')->on('fund_groups');
            $table->integer('keycontact_id')->nullable();
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
        Schema::dropIfExists('funds_keycontacts');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSubFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('sub_funds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('sub_fund_name');
            $table->string('sub_fund_avatar')->nullable();
            $table->unsignedBigInteger('fund_group_id');
            $table->foreign('fund_group_id')->references('id')->on('fund_groups');
            $table->double('amount')->nullable();
            $table->integer('active_status')->default(1);
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
        Schema::dropIfExists('sub_funds');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportSubFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_sub_funds', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('report_sub_fund_id');
            $table->foreign('report_sub_fund_id')->references('id')->on('sub_funds');
            $table->unsignedBigInteger('report_id');
            $table->foreign('report_id')->references('id')->on('report');
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
        Schema::dropIfExists('report_sub_funds');
    }
}

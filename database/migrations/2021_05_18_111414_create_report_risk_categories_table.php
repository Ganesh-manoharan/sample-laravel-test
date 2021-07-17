<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportRiskCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_risk_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('risk_category_id');
            $table->foreign('risk_category_id')->references('id')->on('risk_categories');
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
        Schema::dropIfExists('report_risk_categories');
    }
}

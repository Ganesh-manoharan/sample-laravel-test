<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateRiskIssueImpactratingsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('risk_issue_impactrating', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('impact_rating_id');
            $table->foreign('impact_rating_id')->references('id')->on('field_dropdown_values');
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
        Schema::dropIfExists('risk_issue_impactrating');
    }
}

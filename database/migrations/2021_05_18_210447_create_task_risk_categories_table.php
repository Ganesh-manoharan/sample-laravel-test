<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskRiskCategoriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_risk_categories', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_id');
            $table->unsignedBigInteger('risk_category_id');
            $table->unsignedBigInteger('risk_sub_category_id')->nullable();
            $table->timestamps();
            $table->foreign('risk_category_id')->references('id')->on('risk_categories');
            $table->foreign('risk_sub_category_id')->references('id')->on('risk_categories');
            $table->foreign('task_id')->references('id')->on('tasks');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_risk_categories');
    }
}

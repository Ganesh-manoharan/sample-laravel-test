<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportType extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('report_type', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('name');
            $table->text('description');
            $table->string('code');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.3
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('report_type');
    }
}

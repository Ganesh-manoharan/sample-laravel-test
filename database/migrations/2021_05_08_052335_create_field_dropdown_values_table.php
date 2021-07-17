<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFieldDropdownValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('field_dropdown_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_field_id');
            $table->foreign('task_field_id')->references('id')->on('task_fields');
            $table->string('dropdown_name');
            $table->string('code');
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
        Schema::dropIfExists('field_dropdown_values');
    }
}

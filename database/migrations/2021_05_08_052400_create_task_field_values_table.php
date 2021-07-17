<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskFieldValuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_field_values', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_id');
            $table->foreign('task_id')->references('id')->on('tasks');
            $table->unsignedBigInteger('task_field_id');
            $table->foreign('task_field_id')->references('id')->on('task_fields');
            $table->integer('number')->nullable();
            $table->string('text')->nullable();
            $table->longText('long_text')->nullable();
            $table->timestamp('date')->nullable();
            $table->unsignedBigInteger('dropdown_value_id')->nullable();
            $table->foreign('dropdown_value_id')->references('id')->on('field_dropdown_values');
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
        Schema::dropIfExists('task_field_values');
    }
}

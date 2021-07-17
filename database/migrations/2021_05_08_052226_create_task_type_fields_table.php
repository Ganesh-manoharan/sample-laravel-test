<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskTypeFieldsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_type_fields', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_type_id');
            $table->foreign('task_type_id')->references('id')->on('task_types');
            $table->unsignedBigInteger('task_field_id');
            $table->foreign('task_field_id')->references('id')->on('task_fields');
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
        Schema::dropIfExists('task_type_fields');
    }
}

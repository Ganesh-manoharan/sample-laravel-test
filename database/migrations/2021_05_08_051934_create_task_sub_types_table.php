<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskSubTypesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_sub_types', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_type_id');
            $table->foreign('task_type_id')->references('id')->on('task_types');
            $table->string('task_sub_type_name')->unique();
            $table->string('code')->unique();
            $table->text('description')->nullable();
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
        Schema::dropIfExists('task_sub_types');
    }
}

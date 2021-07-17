<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTaskFormFieldGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('task_form_field_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_type_id');
            $table->string('group_title');
            $table->string('group_slug',50);
            $table->integer('sort_order')->default(99);
            $table->string('step_wizard')->nullable();
            $table->timestamps();
            $table->foreign('task_type_id')->references('id')->on('task_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('task_form_field_groups');
    }
}

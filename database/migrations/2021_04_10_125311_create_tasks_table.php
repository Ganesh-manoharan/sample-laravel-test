<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

class CreateTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('tasks', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('task_name');
            $table->text('task_desc');
            $table->timestamp('due_date')->default(DB::raw('CURRENT_TIMESTAMP'));
            $table->string('frequency');
            $table->string('additional_attachment_requirement');
            $table->text('comments')->nullable();
            $table->string('task_status');
            $table->string('completion_status');
            $table->string('task_challenge_status')->nullable();
            $table->unsignedBigInteger('created_by_id');
            $table->foreign('created_by_id')->references('id')->on('company_users');
            $table->timestamp('completed_date_by_assignee')->nullable();
            $table->unsignedBigInteger('completed_by')->nullable();
            $table->foreign('completed_by')->references('id')->on('company_users');
            $table->timestamp('approved_date')->nullable();
            $table->unsignedBigInteger('approved_by')->nullable();
            $table->foreign('approved_by')->references('id')->on('company_users');
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
        Schema::dropIfExists('tasks');
    }
}

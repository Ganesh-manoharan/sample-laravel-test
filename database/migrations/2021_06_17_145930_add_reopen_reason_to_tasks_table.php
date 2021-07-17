<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddReopenReasonToTasksTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->longText('reopen_reason')->after('approved_by')->nullable();
            $table->dateTime('reopen_date')->nullable()->after('reopen_reason');
            $table->unsignedBigInteger('reopen_by')->nullable();
            $table->foreign('reopen_by')->references('id')->on('company_users');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('tasks', function (Blueprint $table) {
            $table->dropForeign(['reopen_by']);
            $table->dropColumn(['reopen_reason','reopen_date','reopen_by']);
        });
    }
}

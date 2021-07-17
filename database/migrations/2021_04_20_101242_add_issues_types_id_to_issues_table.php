<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddIssuesTypesIdToIssuesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->unsignedBigInteger('issue_type_id')->after('issue_dependency');
            $table->foreign('issue_type_id')->references('id')->on('issues_types');
            $table->dropColumn('issue_dependency');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('issues', function (Blueprint $table) {
            $table->dropForeign(['issue_type_id']);
            $table->dropColumn('issue_type_id');
        });
    }
}

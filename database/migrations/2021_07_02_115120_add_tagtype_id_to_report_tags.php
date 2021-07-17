<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTagtypeIdToReportTags extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('report_tags', function (Blueprint $table) {
            $table->unsignedBigInteger('tagtype_id')->nullable()->after('company_id');
            $table->foreign('tagtype_id')->references('id')->on('tag_types');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('report_tags', function (Blueprint $table) {
            $table->dropForeign(['tagtype_id']);
            $table->dropColumn('tagtype_id');
        });
    }
}

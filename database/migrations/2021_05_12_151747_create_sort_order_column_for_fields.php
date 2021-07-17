<?php

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateSortOrderColumnForFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        DB::statement("SET foreign_key_checks=0");
        Schema::table('task_type_fields', function (Blueprint $table) {
            $table->integer('sort_order')->default(99)->after('task_field_id');
            $table->unsignedBigInteger('task_form_field_group_id')->after('sort_order')->nullable();
            $table->foreign('task_form_field_group_id')->references('id')->on('task_form_field_groups');
        });
        DB::statement("SET foreign_key_checks=1");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_type_fields', function (Blueprint $table) {
            $table->dropColumn('sort_order');
            $table->dropForeign(['task_form_field_group_id']);
            $table->dropColumn('task_form_field_group_id');
        });
    }
}

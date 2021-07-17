<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateIsReqColumnFormFields extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('task_type_fields', function (Blueprint $table) {
            $table->boolean('is_requried')->default(0)->after('task_field_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('task_type_fields', function (Blueprint $table) {
            $table->dropColumn('is_requried');
        });
    }
}

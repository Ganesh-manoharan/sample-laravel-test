<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableColumnsToSubFunds extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_funds', function (Blueprint $table) {
            $table->unsignedBigInteger('fund_group_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_funds', function (Blueprint $table) {
            $table->unsignedBigInteger('fund_group_id')->nullable(false)->change();
        });
    }
}

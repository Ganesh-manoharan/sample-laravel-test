<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToSubFundsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_funds', function (Blueprint $table) {
            $table->text('investment_strategy')->nullable()->after('fund_group_id');
            $table->string('investment_manager')->nullable()->after('investment_strategy');
            $table->timestamp('initial_launch_date')->nullable()->after('investment_manager');
            $table->unsignedBigInteger('created_by')->nullable()->after('initial_launch_date');
            $table->foreign('created_by')->references('id')->on('company_users');
            $table->dropColumn('amount');
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
            $table->dropColumn('investment_strategy');
            $table->dropColumn('investment_manager');
            $table->dropColumn('initial_launch_date');
            $table->dropForeign(['created_by']);
            $table->dropColumn('created_by');

        });
    }
}

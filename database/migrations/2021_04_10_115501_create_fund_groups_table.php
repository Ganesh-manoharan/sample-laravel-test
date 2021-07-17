<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateFundGroupsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_groups', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('fund_group_name');
            $table->string('avatar')->nullable();
            $table->double('amount')->nullable();
            $table->text('registered_address')->nullable();
            $table->text('entity_type')->nullable();
            $table->string('management')->nullable();
            $table->string('administrator')->nullable();
            $table->string('depository')->nullable();
            $table->string('auditor')->nullable();
            $table->timestamp('accounting_year_end')->nullable();
            $table->timestamp('initial_launch_date')->nullable();
            $table->unsignedBigInteger('country_id')->nullable();
            $table->foreign('country_id')->references('id')->on('countries');
            $table->unsignedBigInteger('created_by');
            $table->foreign('created_by')->references('id')->on('company_users');
            $table->integer('active_status')->default(1);
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
        Schema::dropIfExists('fund_groups');
    }
}

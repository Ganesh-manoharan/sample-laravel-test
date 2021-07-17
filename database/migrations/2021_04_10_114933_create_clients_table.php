<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateClientsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('clients', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->integer('registration_id');
            $table->string('client_name');
            $table->string('client_logo')->nullable();
            $table->text('description')->nullable();
            $table->string('phone_number');
            $table->string('email')->nullable();
            $table->text('address_line_one');
            $table->text('address_line_two');
            $table->string('zip_code');
            $table->unsignedBigInteger('city_id');
            $table->foreign('city_id')->references('id')->on('city');
            $table->unsignedBigInteger('country_id');
            $table->foreign('country_id')->references('id')->on('countries');
            $table->integer('deadline_priority');
            $table->text('regulated_status')->nullable();
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
        Schema::dropIfExists('clients');
    }
}

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddNullableColumnsToClients extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('registration_id')->nullable()->change();
            $table->string('phone_number')->nullable()->change();
            $table->text('address_line_one')->nullable()->change();
            $table->text('address_line_two')->nullable()->change();
            $table->string('zip_code')->nullable()->change();
            $table->unsignedBigInteger('city_id')->nullable()->change();
            $table->unsignedBigInteger('country_id')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('clients', function (Blueprint $table) {
            $table->integer('registration_id')->nullable(false)->change();
            $table->string('phone_number')->nullable(false)->change();
            $table->text('address_line_one')->nullable(false)->change();
            $table->text('address_line_two')->nullable(false)->change();
            $table->string('zip_code')->nullable(false)->change();
            $table->unsignedBigInteger('city_id')->nullable(false)->change();
            $table->unsignedBigInteger('country_id')->nullable(false)->change();
        });
    }
}

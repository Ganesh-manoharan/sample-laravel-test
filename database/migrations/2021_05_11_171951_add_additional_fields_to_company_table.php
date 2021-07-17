<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddAdditionalFieldsToCompanyTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('company', function (Blueprint $table) {
            $table->string('contact_number')->nullable()->after('company_name');
            $table->string('contact_email')->nullable()->after('contact_number');
            $table->text('regulatory_status')->nullable()->after('contact_email');
            $table->string('address_line_one')->nullable()->after('regulatory_status');
            $table->string('address_line_two')->nullable()->after('address_line_one');
            $table->string('address_line_three')->nullable()->after('address_line_two');
            $table->string('address_line_four')->nullable()->after('address_line_three');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('company', function (Blueprint $table) {
            $table->dropColumn('contact_number');
            $table->dropColumn('contact_email');
            $table->dropColumn('regulatory_status');
            $table->dropColumn('address_line_one');
            $table->dropColumn('address_line_two');
            $table->dropColumn('address_line_three');
            $table->dropColumn('address_line_four');
        });
    }
}

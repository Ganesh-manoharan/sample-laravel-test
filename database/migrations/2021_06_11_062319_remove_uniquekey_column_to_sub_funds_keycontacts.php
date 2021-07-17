<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class RemoveUniquekeyColumnToSubFundsKeycontacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('sub_funds_keycontacts', function (Blueprint $table) {
            $table->dropUnique('sub_funds_keycontacts_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('sub_funds_keycontacts', function (Blueprint $table) {
            $table->dropUnique('sub_funds_keycontacts_email_unique');
        });
    }
}

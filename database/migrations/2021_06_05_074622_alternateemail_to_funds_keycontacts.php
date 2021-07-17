<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AlternateemailToFundsKeycontacts extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('funds_keycontacts', function (Blueprint $table) {
            //$table->string('email')->unique(false)->nullable()->change();
            $table->dropUnique('funds_keycontacts_email_unique');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('funds_keycontacts', function (Blueprint $table) {
            //$table->string('email')->nullable(false)->unique()->change();
            $table->dropUnique('funds_keycontacts_email_unique');
        });
    }
}

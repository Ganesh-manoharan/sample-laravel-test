<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\TraceModel;
class CreateFundsKeyContactTracesTable extends Migration
{
    use TraceModel;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('funds_key_contact_traces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fund_groups_id')->nullable();
            $table->unsignedBigInteger('funds_keycontact_id')->nullable();
            $table->timestamps();
            $table->foreign('fund_groups_id')->references('id')->on('fund_groups');
            $table->foreign('funds_keycontact_id')->references('id')->on('funds_keycontacts');
        });
        self::createTraceTable('funds_key_contact_traces');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('funds_key_contact_traces');
    }
}

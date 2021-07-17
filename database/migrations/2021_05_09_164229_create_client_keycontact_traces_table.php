<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\TraceModel;
class CreateClientKeycontactTracesTable extends Migration
{
    use TraceModel;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('client_keycontact_traces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('client_id')->nullable();
            $table->unsignedBigInteger('client_keycontacts_id')->nullable();
            $table->timestamps();
            $table->foreign('client_id')->references('id')->on('clients');
            $table->foreign('client_keycontacts_id')->references('id')->on('client_keycontacts');
        });
        self::createTraceTable('client_keycontact_traces');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('client_keycontact_traces');
    }
}

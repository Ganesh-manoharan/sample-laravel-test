<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\TraceModel;
class CreateFundGroupsTracesTable extends Migration
{
    use TraceModel;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('fund_groups_traces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('fund_groups_id')->nullable();
            $table->timestamps();
            $table->foreign('fund_groups_id')->references('id')->on('fund_groups');
        });
        self::createTraceTable('fund_groups_traces');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('fund_groups_traces');
    }
}

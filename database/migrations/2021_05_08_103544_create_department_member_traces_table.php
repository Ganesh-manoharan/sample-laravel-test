<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Traits\TraceModel;
class CreateDepartmentMemberTracesTable extends Migration
{
    use TraceModel;
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('department_member_traces', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('department_id')->nullable();
            $table->unsignedBigInteger('department_members_id')->nullable();
            $table->timestamps();
            $table->foreign('department_id')->references('id')->on('departments');
            $table->foreign('department_members_id')->references('id')->on('department_members');
        });
        self::createTraceTable('department_member_traces');
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('department_member_traces');
    }
}

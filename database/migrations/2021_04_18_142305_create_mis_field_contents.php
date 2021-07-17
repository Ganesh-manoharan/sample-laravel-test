<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMisFieldContents extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mis_field_contents', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->unsignedBigInteger('task_mis_field_id');
            $table->foreign('task_mis_field_id')->references('id')->on('task_mis_fields');
            $table->string('options')->nullable();
            $table->string('min_value')->nullable();
            $table->string('max_value')->nullable();
            $table->string('is_required')->nullable();
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
        Schema::dropIfExists('mis_field_contents');
    }
}

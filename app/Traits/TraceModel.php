<?php
namespace App\Traits;

use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;

trait TraceModel
{
    public static function createTraceTable($tableName)
    {
        Schema::table($tableName, function (Blueprint $table) {
            $table->unsignedBigInteger('modified_by')->nullable();
            $table->string('action',10);
            $table->longText('modified_columns');
            $table->foreign('modified_by')->references('id')->on('users');
        });
    }
}

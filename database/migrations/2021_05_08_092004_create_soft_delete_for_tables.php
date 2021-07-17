<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateSoftDeleteForTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('departments', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('department_members', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('fund_groups', function (Blueprint $table) {
            $table->softDeletes();
        });
        Schema::table('clients', function (Blueprint $table) {
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
       
        if (Schema::hasColumn('departments', 'deleted_at'))
        {
            Schema::table('departments', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
        if (Schema::hasColumn('department_members', 'deleted_at'))
        {
            Schema::table('department_members', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
        if (Schema::hasColumn('fund_groups', 'deleted_at'))
        {
            Schema::table('fund_groups', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
        if (Schema::hasColumn('clients', 'deleted_at'))
        {
            Schema::table('clients', function (Blueprint $table) {
                $table->dropColumn('deleted_at');
            });
        }
    }
}

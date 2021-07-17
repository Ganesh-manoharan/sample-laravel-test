<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddDocumentNameColumnToClientFtpDocuments extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('client_ftp_documents', function (Blueprint $table) {
            $table->string('document_name')->after('client_id');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('client_ftp_documents', function (Blueprint $table) {
            $table->dropColumn('document_name');
        });
    }
}

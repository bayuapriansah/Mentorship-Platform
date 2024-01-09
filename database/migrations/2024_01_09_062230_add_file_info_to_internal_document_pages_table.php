<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('internal_document_pages', function (Blueprint $table) {
            $table->longText('files_header_info')->nullable()->after('files');
            $table->longText('files_footer_info')->nullable()->after('files_header_info');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('internal_document_pages', function (Blueprint $table) {
            $table->dropColumn(['files_header_info', 'files_footer_info']);
        });
    }
};

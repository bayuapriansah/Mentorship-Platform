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
        Schema::table('project_sections', function (Blueprint $table) {
            $table->string('file1')->after('file_type')->nullable();
            $table->string('file2')->after('file1')->nullable();
            $table->string('video_link')->after('file2')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('project_sections', function (Blueprint $table) {
            $table->dropColumn('file1');
            $table->dropColumn('file2');
            $table->dropColumn('video_link');
        });
    }
};

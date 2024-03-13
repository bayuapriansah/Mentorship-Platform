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
            $table->longText('dataset_label')->after('description')->nullable();
            $table->string('assigned_to')->after('duration')->nullable();
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
            $table->dropColumn('dataset_label');
            $table->dropColumn('assigned_to');
        });
    }
};

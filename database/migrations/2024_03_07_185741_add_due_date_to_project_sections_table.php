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
            // Add 'due_date' column, nullable, with a default value of today's date plus one day
            $table->date('due_date')->nullable()->default(now()->addDay())->after('duration');
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
            $table->dropColumn('due_date');
        });
    }
};

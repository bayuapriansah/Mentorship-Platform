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
        Schema::table('enrolled_projects', function (Blueprint $table) {
            $table->string('mentorshipType')->nullable()->default('skill')->after('flag_checkpoint');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('enrolled_projects', function (Blueprint $table) {
            $table->dropColumn('mentorshipType');
        });
    }
};

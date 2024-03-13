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
            $table->string('team_name')->nullable()->default('global_track')->after('mentorshipType');
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
            $table->dropColumn('team_name');
        });
    }
};

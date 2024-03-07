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
        Schema::table('projects', function (Blueprint $table) {
            $table->integer('order')->nullable()->after('institution_id'); // Add 'order' field after 'institution_id'
            $table->string('team_name')->nullable()->after('order'); // Add 'team_name' field, nullable, after 'order'
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('projects', function (Blueprint $table) {
            $table->dropColumn('order');
            $table->dropColumn('team_name');
        });
    }
};

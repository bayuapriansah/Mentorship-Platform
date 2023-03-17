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
        Schema::table('read_notifications', function (Blueprint $table) {
            $table->string('submission_id')->after('notifications_id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('read_notifications', function (Blueprint $table) {
            $table->dropColumn('submission_id');
        });
    }
};

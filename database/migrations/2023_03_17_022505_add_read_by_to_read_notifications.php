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
            $table->string('user_id')->after('notifications_id')->nullable();
            $table->string('mentor_id')->after('notifications_id')->nullable();
            $table->string('customer_id')->after('notifications_id')->nullable();
            $table->string('type')->after('notifications_id')->nullable();
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
            $table->dropColumn('user_id');
            $table->dropColumn('mentor_id');
            $table->dropColumn('customer_id');
            $table->dropColumn('type');
        });
    }
};

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
        Schema::table('students', function (Blueprint $table) {
            // Add join_date field after staff_id
            $table->date('join_date')->nullable()->after('staff_id');

            // Add switch_skill field after end_date with values 0 or 1
            $table->boolean('switch_skill')->default(0)->after('end_date');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('students', function (Blueprint $table) {
            $table->dropColumn('join_date');
            $table->dropColumn('switch_skill');
        });
    }
};

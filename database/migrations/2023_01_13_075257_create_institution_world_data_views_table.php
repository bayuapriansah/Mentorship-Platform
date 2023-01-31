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
        // Schema::create('institution_world_data_views', function (Blueprint $table) {
        //     $table->id();
        //     $table->timestamps();
        // });
        \DB::statement("
        CREATE VIEW institution_world_data_views 
        AS
        SELECT
            institutions.id, 
            institutions.name AS institutions, 
            countries.name AS countries, 
            states.name AS states
        FROM
            institutions,
            countries,
            states
        WHERE
            institutions.country = countries.id AND
            countries.id = states.country_id AND
            institutions.state = states.id
        ");
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('institution_world_data_views');
    }
};

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
        Schema::create('project_sections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_id');
            $table->integer('section');
            $table->integer('subsection');
            $table->string('description_section');
            $table->string('file_1');
            $table->string('file_2');
            $table->string('file_3');
            $table->string('video_link');
            $table->string('submit_assignment');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('project_sections');
    }
};

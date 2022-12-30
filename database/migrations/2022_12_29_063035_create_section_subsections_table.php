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
        Schema::create('section_subsections', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('project_section_id');
            $table->string('file1');
            $table->string('file2')->nullable();
            $table->string('file3')->nullable();
            $table->string('video_link')->nullable();
            $table->boolean('is_submit');
            $table->timestamps();

            $table->foreign('project_section_id')
                ->references('id')
                ->on('project_sections')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('section_subsections');
    }
};

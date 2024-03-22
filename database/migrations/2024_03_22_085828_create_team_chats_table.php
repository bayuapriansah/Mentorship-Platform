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
        Schema::create('team_chats', function (Blueprint $table) {
            $table->id();
            $table->string('team_name');
            $table->string('message')->nullable();
            $table->string('sender_id');
            $table->string('sender_type');
            $table->string('type')->default("text");
            $table->text('attachment')->nullable();
            $table->string('status')->nullable();
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
        Schema::dropIfExists('team_chats');
    }
};

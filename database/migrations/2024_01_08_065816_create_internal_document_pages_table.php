<?php

use App\Models\InternalDocumentGroupSection;
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
        Schema::create('internal_document_pages', function (Blueprint $table) {
            $table->id();
            $table->foreignIdFor(InternalDocumentGroupSection::class);
            $table->string('title', 1000);
            $table->string('subtitle', 1000)->nullable();
            $table->boolean('is_draft')->default(false);
            $table->longText('description')->nullable();
            $table->json('files')->nullable();
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
        Schema::dropIfExists('internal_document_pages');
    }
};

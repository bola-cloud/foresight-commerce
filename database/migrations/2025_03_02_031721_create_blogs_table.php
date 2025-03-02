<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('blogs', function (Blueprint $table) {
            $table->id();
            $table->string('ar_title'); // Arabic title
            $table->string('en_title'); // English title
            $table->string('slug')->unique(); // Unique slug for URLs
            $table->text('ar_content'); // Arabic content
            $table->text('en_content'); // English content
            $table->string('image')->nullable(); // Optional image
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('blogs');
    }
};

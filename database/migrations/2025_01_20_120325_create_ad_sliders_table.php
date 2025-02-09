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
        Schema::create('ad_sliders', function (Blueprint $table) {
            $table->id();
            $table->string('image'); // Ad image
            $table->string('brand'); // Brand name
            $table->string('ar_title'); // Arabic title
            $table->string('en_title'); // English title
            $table->text('ar_description')->nullable(); // Arabic description
            $table->text('en_description')->nullable(); // English description
            $table->decimal('price', 10, 2)->nullable(); // Price (nullable)
            $table->timestamps(); // Created at and Updated at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ad_sliders');
    }
};

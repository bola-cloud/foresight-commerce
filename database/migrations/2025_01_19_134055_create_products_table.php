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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('ar_name'); // Arabic product name
            $table->string('en_name'); // English product name
            $table->decimal('price', 10, 2); // Product price (number)
            $table->text('ar_description')->nullable(); // Arabic product description
            $table->text('en_description')->nullable(); // English product description
            $table->integer('quantity')->default(0); // Product quantity (number)
            $table->json('ar_features')->nullable(); // Arabic product features
            $table->json('en_features')->nullable(); // English product features
            $table->string('ar_manufacturer')->nullable(); // Arabic manufacturer
            $table->string('en_manufacturer')->nullable(); // English manufacturer
            $table->json('images')->nullable(); // Product images
            $table->unsignedBigInteger('category_id')->nullable(); // Foreign key for category
            $table->foreign('category_id')->references('id')->on('categories')
                ->onUpdate('CASCADE')->onDelete('SET NULL');
            $table->timestamps(); // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};

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
        Schema::create('products', function(Blueprint $table){
            $table->id();
            $table->string('code')->unique();
            $table->enum('status', ['draft', 'trash', 'published'])->default('draft');
            $table->timestamp('imported_t');
            $table->text('url')->nullable();
            $table->text('creator')->nullable();
            $table->datetime('created_t')->nullable();
            $table->text('last_modified_t')->nullable();
            $table->text('product_name');
            $table->text('quantity')->nullable();
            $table->text('brands')->nullable();
            $table->text('categories')->nullable();
            $table->text('labels')->nullable();
            $table->text('cities', 500)->nullable();
            $table->text('purchase_places', 500)->nullable();
            $table->text('stores', 500)->nullable();
            $table->text('ingredients_text')->nullable();
            $table->text('traces')->nullable();
            $table->text('serving_size', 100)->nullable();
            $table->text('serving_quantity')->nullable();
            $table->text('nutriscore_score')->nullable();
            $table->text('nutriscore_grade', 2)->nullable();
            $table->text('main_category', 255)->nullable();
            $table->text('image_url')->nullable();
            $table->timestamps();
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

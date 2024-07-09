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
        Schema::create('books', function (Blueprint $table) {
            $table->id(); 
            $table->string('title');
            $table->string('isbn')->unique();
            $table->string('publisher');
            $table->integer('year');
            $table->unsignedBigInteger('author_id'); 
            $table->string('cover_image')->nullable();
            $table->text('summary')->nullable();
            $table->timestamps(); 
            $table->foreign('author_id')->references('id')->on('authors')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('books');
    }
};

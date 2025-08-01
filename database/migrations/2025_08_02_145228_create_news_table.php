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
        Schema::create('news', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('slug')->unique(); // Untuk URL yang rapi
            $table->longText('content');
            $table->string('image_path')->nullable(); // Path gambar thumbnail
            $table->foreignId('user_id')->constrained('users')->onDelete('restrict'); // Penulis berita
            $table->timestamp('published_at')->nullable(); // Tanggal publikasi
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('news');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('komentar', function (Blueprint $table) {
            $table->id();
            $table->foreignId('artikel_id')
                  ->constrained('artikel')
                  ->onDelete('cascade');
            $table->foreignId('users_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->text('isi');
            $table->timestamps();
            $table->softDeletes(); // Untuk fitur soft delete
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('komentar');
    }
};
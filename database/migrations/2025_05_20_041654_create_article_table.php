<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('artikel', function (Blueprint $table) {
            $table->id();
            $table->foreignId('users_id')
                  ->constrained()
                  ->onDelete('cascade');
            $table->string('judul');
            $table->text('isi');
            $table->enum('tag', ['penyakit', 'perawatan', 'budidaya']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('artikel');
    }
};
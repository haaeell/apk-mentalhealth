<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('symptoms', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // G001, G002, dst
            $table->string('name');
            $table->text('description');
            $table->text('question'); // Pertanyaan yang ditampilkan ke user
            $table->string('category')->default('umum'); // emosi, perilaku, fisik, kognitif
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('symptoms');
    }
};

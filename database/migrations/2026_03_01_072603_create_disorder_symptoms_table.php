<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('disorder_symptoms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('mental_disorder_id')->constrained()->onDelete('cascade');
            $table->foreignId('symptom_id')->constrained()->onDelete('cascade');
            $table->decimal('mb', 4, 3); // Measure of Belief 0.0 - 1.0
            $table->decimal('md', 4, 3); // Measure of Disbelief 0.0 - 1.0
            $table->timestamps();

            $table->unique(['mental_disorder_id', 'symptom_id']);
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('disorder_symptoms');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('diagnoses', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->json('answers'); // {"symptom_id": confidence_value, ...}
            $table->json('results'); // {"disorder_id": cf_value, ...}
            $table->foreignId('primary_disorder_id')->nullable()->constrained('mental_disorders');
            $table->decimal('cf_final', 5, 4)->nullable();
            $table->enum('status', ['completed', 'pending'])->default('completed');
            $table->text('notes')->nullable(); // catatan tambahan
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('diagnoses');
    }
};

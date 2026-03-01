<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('mental_disorders', function (Blueprint $table) {
            $table->id();
            $table->string('code')->unique(); // P001, P002, dst
            $table->string('name');
            $table->text('description');
            $table->text('recommendation');
            $table->enum('severity', ['ringan', 'sedang', 'berat']);
            $table->string('color_code')->default('#6366f1'); // untuk UI badge
            $table->boolean('is_active')->default(true);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('mental_disorders');
    }
};

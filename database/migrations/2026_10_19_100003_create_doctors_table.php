<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates doctors profile table and its translations table (Astrotomic Translatable).
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('section_id')->nullable()->constrained('sections')->nullOnDelete();

            $table->string('license_number', 50)->unique()->nullable();
            $table->unsignedSmallInteger('experience_years')->default(0);
            $table->decimal('consultation_fee', 8, 2)->default(0.00);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->boolean('is_available')->default(true);
            $table->unsignedInteger('appointments_per_day')->default(20);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('doctor_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('doctor_id')->constrained('doctors')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name')->nullable();
            $table->string('title')->nullable();
            $table->text('bio')->nullable();

            $table->unique(['doctor_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctor_translations');
        Schema::dropIfExists('doctors');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates doctors profile table linked to users.
     */
    public function up(): void
    {
        Schema::create('doctors', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();
            $table->foreignId('specialization_id')->nullable()->constrained('specializations')->nullOnDelete();
            $table->string('name_en')->nullable();

            $table->string('license_number', 50)->unique()->nullable();
            $table->string('title')->default('Specialist'); // Consultant, Specialist, Professor, etc.
            $table->text('bio')->nullable();
            $table->unsignedSmallInteger('experience_years')->default(0);
            $table->decimal('consultation_fee', 8, 2)->default(0.00);
            $table->decimal('rating', 3, 2)->default(5.00);
            $table->boolean('is_available')->default(true);
            $table->unsignedInteger('appointments_per_day')->default(20);
            $table->unsignedInteger('sort_order')->default(0);

            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('doctors');
    }
};

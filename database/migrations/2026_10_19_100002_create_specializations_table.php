<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the specializations table and its translations table (Astrotomic Translatable).
     */
    public function up(): void
    {
        Schema::create('specializations', function (Blueprint $table) {
            $table->id();
            $table->string('icon')->nullable(); // FontAwesome or svg icon name
            $table->boolean('is_active')->default(true);
            $table->unsignedInteger('sort_order')->default(0);
            $table->timestamps();
        });

        // To Create specialization's translations table in database
        Schema::create('specialization_translations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('specialization_id')->constrained('specializations')->cascadeOnDelete();
            $table->string('locale')->index();
            $table->string('name');
            $table->text('description')->nullable();

            $table->unique(['specialization_id', 'locale']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('specialization_translations');
        Schema::dropIfExists('specializations');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Creates the patients profile table linked to users.
     */
    public function up(): void
    {
        Schema::create('patients', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->unique()->constrained()->cascadeOnDelete();

            // Personal information
            $table->string('national_id', 20)->unique()->nullable();
            $table->enum('gender', ['male', 'female'])->nullable();
            $table->date('date_of_birth')->nullable();
            $table->string('blood_type', 5)->nullable(); // A+, B-, etc.
            $table->string('marital_status')->nullable();
            $table->string('nationality')->nullable()->default('Egyptian');

            // Address
            $table->string('city')->nullable();
            $table->string('address')->nullable();

            // Emergency contact
            $table->string('emergency_contact_name')->nullable();
            $table->string('emergency_contact_phone', 20)->nullable();
            $table->string('emergency_contact_relation')->nullable();

            // Medical
            $table->text('allergies')->nullable();
            $table->text('chronic_diseases')->nullable();
            $table->string('insurance_provider')->nullable();
            $table->string('insurance_number')->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('patients');
    }
};

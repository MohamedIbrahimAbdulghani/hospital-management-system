<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('specializations', function (Blueprint $table) {
            if (! Schema::hasColumn('specializations', 'description_en')) {
                $table->text('description_en')->nullable()->after('description');
            }
            if (! Schema::hasColumn('specializations', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('is_active');
            }
        });

        Schema::table('doctors', function (Blueprint $table) {
            if (! Schema::hasColumn('doctors', 'sort_order')) {
                $table->unsignedInteger('sort_order')->default(0)->after('appointments_per_day');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('specializations', function (Blueprint $table) {
            $table->dropColumn(['description_en', 'sort_order']);
        });

        Schema::table('doctors', function (Blueprint $table) {
            $table->dropColumn(['sort_order']);
        });
    }
};

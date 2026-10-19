<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * Adds extra columns required by the HMS to the users table.
     */
    public function up(): void
    {
        Schema::table('users', function (Blueprint $table) {
            // is_active instead of hard-delete
            $table->boolean('is_active')->default(true)->after('remember_token');

            // Force password change on first login (for staff created by admin)
            $table->boolean('must_change_password')->default(false)->after('is_active');

            // Soft deletes
            $table->softDeletes()->after('updated_at');

            // Phone number
            $table->string('phone', 20)->nullable()->after('name');

            // Avatar / profile picture
            $table->string('avatar')->nullable()->after('phone');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'is_active',
                'must_change_password',
                'deleted_at',
                'phone',
                'avatar',
            ]);
        });
    }
};

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
        // First create the branches table if it doesn't exist
        if (!Schema::hasTable('branches')) {
            Schema::create('branches', function (Blueprint $table) {
                $table->id();
                $table->string('name');
                $table->timestamps();
            });
        }

        Schema::create('users', function (Blueprint $table) {
            $table->id();                      // Auto-incrementing primary key
            $table->string('name');            // User's name
            $table->string('email')->unique();  // Email with unique constraint
            $table->string('password');         // Hashed password
            $table->string('role')->default('admin'); // Role with default as 'admin'
            $table->unsignedBigInteger('branch_id')->nullable(); // Branch reference without foreign key
            $table->rememberToken();            // Remember me functionality
            $table->timestamps();               // created_at & updated_at

            // Removed the foreign key constraint
        });

        // Sessions table (for tracking active logins)
        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignId('user_id')->nullable()->index()->constrained()->onDelete('cascade');
            $table->string('ip_address', 45)->nullable();
            $table->text('user_agent')->nullable();
            $table->longText('payload');
            $table->integer('last_activity')->index();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sessions');
        Schema::dropIfExists('users');
        Schema::dropIfExists('branches');

        // Removed the foreign key drop since we're not using it anymore
    }
};

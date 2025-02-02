<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     * php artisan migrate:refresh --path=/database/migrations/create_users_table.php
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->rememberToken();
            $table->timestamps();
            $table->boolean('super')->default(false);
            $table->string('avatar')->nullable();
            $table->json('preferences')->nullable();
            $table->timestamp('last_login')->nullable();
        });
        
        Schema::create('role_user', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');  
            $table->string('role_id');
        });
         
        Schema::create('group_user', function (Blueprint $table) {
            $table->increments('id');
            $table->uuid('user_id');  
            $table->string('group_id');
        });

        Schema::create('password_activation_tokens', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('password_reset_tokens', function (Blueprint $table) {
            $table->string('email')->index();
            $table->string('token');
            $table->timestamp('created_at')->nullable();
        });

        Schema::create('sessions', function (Blueprint $table) {
            $table->string('id')->primary();
            $table->foreignUuid('user_id')->nullable()->constrained('users')->nullOnDelete();
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
        Schema::dropIfExists('password_reset_tokens');
        Schema::dropIfExists('password_activation_tokens');
        Schema::dropIfExists('group_user');
        Schema::dropIfExists('role_user');
    
        // Ensure the table exists before altering it
        if (Schema::hasTable('users')) {
            Schema::table('users', function (Blueprint $table) {
                $table->dropColumn(['super', 'avatar', 'preferences', 'last_login']);
            });
    
            Schema::dropIfExists('users');
        }
    }    
};

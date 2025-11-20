<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use App\Enums\Roles;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('phone_number', 10)->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->enum('role', ['parent', 'student', 'teacher', 'admin',]);
            $table->string('centy_plus_id')->nullable();
            $table->string('centy_plus_otp')->nullable();
            $table->string('centy_plus_otp_verified')->default(0);
            $table->timestamp('centy_plus_otp_sent_at')->nullable();
            $table->timestamp('centy_plus_otp_verified_at')->nullable();
            $table->string('password');
            $table->rememberToken();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{

    public function up(): void
    {
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('avatar')->nullable();
            $table->string('name');
            $table->string('email')->unique()->nullable();
            $table->string('country_code')->nullable();
            $table->string('phone')->nullable();
            $table->string('notify_by')->nullable();
            $table->string('signup_by')->nullable();
            $table->integer('provider_id')->nullable();
            $table->string('provider')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password')->nullable();
            $table->text('two_factor_secret')->nullable();
            $table->text('two_factor_recovery_codes')->nullable();
            $table->string('verification_code')->nullable();
            $table->string('facebook_id')->nullable();
            $table->string('google_id')->nullable();   
            //ADDITIONAL_COLUMN
            $table->integer('is_active')->default(1);
            $table->rememberToken();
            $table->foreignId('current_team_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
        });
    }


    public function down(): void
    {
        Schema::dropIfExists('users');
    }
};

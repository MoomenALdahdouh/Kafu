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
        Schema::create('users', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('last_name')->nullable();
            $table->string('image')->nullable();
            $table->string('email')->unique()->index();
            $table->string('mobile')->nullable();
            $table->string('mobile_code')->nullable();
            $table->timestamp('email_verified_at')->nullable();
            $table->timestamp('mobile_verified_at')->nullable();
            $table->string('password');
            $table->tinyInteger('type')->default(2)->comment('0: incubator, 1: company, 2 admin');
            $table->tinyInteger('status')->default(1)->comment('0:not active, 1:active, 2:blocked')->index();
            $table->tinyInteger('condition')->default(0)->comment('0:not approved, 1:approved');
            $table->softDeletes();
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

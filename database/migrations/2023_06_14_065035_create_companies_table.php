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
        Schema::create('companies', function (Blueprint $table) {
            $table->id();
            $table->string('key')->unique();
            $table->string('incubator_key');
            $table->foreignId('incubator_id')->constrained('incubators');
            $table->foreignId('user_id')->constrained('users');
            $table->string('name');
            $table->string('name_officer')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->foreignId('country_code_id')->nullable()->constrained('country_codes');
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->tinyInteger('condition')->default(0)->comment('0:not approved, 1:approved');
            $table->tinyInteger('status')->default(0)->comment('0:not published, 1:published, 2:blocked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('companies');
    }
};

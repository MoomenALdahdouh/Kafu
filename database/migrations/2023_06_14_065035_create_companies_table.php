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
            $table->foreignId('incubator_id')->constrained('incubators');
            $table->string('name');
            $table->string('name_officer');
            $table->string('email')->unique();
            $table->string('mobile');
            $table->foreignId('country_code_id')->constrained('country_codes');
            $table->foreignId('country_id')->constrained('countries');
            $table->string('password');
            $table->tinyInteger('condition')->default(0)->comment('0:not approved, 1:approved');
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

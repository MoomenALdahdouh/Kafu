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
        Schema::create('incubators', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->string('key')->unique();
            $table->string('name');
            $table->string('logo')->nullable();
            $table->string('image')->nullable();
            $table->string('name_officer')->nullable();
            $table->string('email')->unique();
            $table->string('mobile')->nullable();
            $table->double('projects')->default(0);
            $table->foreignId('country_code_id')->nullable()->constrained('country_codes');
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->text('message')->nullable();
            $table->tinyInteger('condition')->default(0)->comment('0:not approved, 1:approved');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('incubators');
    }
};

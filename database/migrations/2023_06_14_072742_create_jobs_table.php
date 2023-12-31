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
        Schema::create('jobs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained('users');
            $table->foreignId('company_id')->constrained('companies');
            $table->string('incubator_key');
            $table->string('name');
            $table->text('description')->nullable();
            $table->string('image')->nullable();
            $table->text('tags')->nullable();
            $table->double('budget')->default(50);
            $table->double('salary')->nullable();
            $table->foreignId('country_id')->nullable()->constrained('countries');
            $table->tinyInteger('status')->default(0)->comment('0:not published, 1:published, 2:blocked');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('jobs');
    }
};

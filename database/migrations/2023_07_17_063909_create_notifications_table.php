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
        Schema::create('notifications', function (Blueprint $table) {
            $table->id();
            $table->string('model')->nullable();
            $table->unsignedBigInteger('model_id')->nullable();
            $table->string('title')->nullable();
            $table->text('message')->nullable();
            $table->text('description')->nullable();
            $table->string('button')->nullable();
            $table->string('button_link')->nullable();
            $table->text('path')->nullable();
            $table->text('status')->default(0)->comment('0:not seen, 1:seen');
            $table->text('sender')->nullable();
            $table->text('receiver')->nullable();
            $table->text('email')->nullable();
            $table->tinyInteger('type')->default(0)->comment("0:default, 1:");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};

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
        Schema::create('plans', function (Blueprint $table) {
            $table->id();
            $table->text('name')->unique()->comment('must be unique');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->double('price')->default(0);
            $table->integer('days')->default(0);
            $table->text('features')->nullable();
            $table->double('budget')->default(0);
            $table->tinyInteger('recharge')->default(0)->comment('0: not auto recharge, 1: auto recharge');
            $table->tinyInteger('free')->default(0)->comment('0: not free, 1: free')->index();
            $table->tinyInteger('type')->default(1)->comment('0: new, 1: default')->index();
            $table->tinyInteger('status')->default(1)->comment('0:not active, 1:active')->index();
            $table->integer('sort')->default(0)->index();
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('plans');
    }
};

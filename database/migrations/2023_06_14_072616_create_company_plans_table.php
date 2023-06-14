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
        Schema::create('company_plans', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained('companies');
            $table->foreignId('plan_id')->constrained('plans');
            $table->text('name')->unique()->comment('must be unique');
            $table->text('description')->nullable();
            $table->text('image')->nullable();
            $table->double('price')->default(0);
            $table->integer('days')->default(0);
            $table->tinyInteger('recharge')->default(0)->comment('0: not auto recharge, 1: auto recharge');
            $table->tinyInteger('free')->default(0)->comment('0: not free, 1: free')->index();
            $table->tinyInteger('type')->default(1)->comment('0: yearly, 1: monthly')->index();
            $table->tinyInteger('status')->default(1)->comment('0:not active, 1:active')->index();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('company_plans');
    }
};

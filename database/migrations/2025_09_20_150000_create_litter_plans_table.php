<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('litter_plans', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->unsignedSmallInteger('planned_year')->nullable();
            $table->timestamps();
        });

        Schema::create('litter_plan_pairs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('litter_plan_id')->constrained()->cascadeOnDelete();
            $table->foreignId('female_id')->constrained('animals')->cascadeOnDelete();
            $table->foreignId('male_id')->constrained('animals')->cascadeOnDelete();
            $table->timestamps();
            $table->unique(['litter_plan_id', 'female_id', 'male_id'], 'litter_plan_pair_unique');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('litter_plan_pairs');
        Schema::dropIfExists('litter_plans');
    }
};

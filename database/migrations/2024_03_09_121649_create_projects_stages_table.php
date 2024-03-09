<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class() extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('projects_stages', function (Blueprint $table) {
            $table->id();
            $table->integer('season');
            $table->foreignId('project_id')->constrained('projects')->cascadeOnDelete();
            $table->foreignId('parent_male_id')->nullable()->constrained('animals')->onDelete('set null');
            $table->string('parent_male_name')->nullable();
            $table->foreignId('parent_female_id')->nullable()->constrained('animals')->onDelete('set null');
            $table->string('parent_female_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_stages');
    }
};

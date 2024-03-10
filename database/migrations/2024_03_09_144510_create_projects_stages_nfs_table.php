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
        Schema::create('projects_stages_nfs', function (Blueprint $table) {
            $table->id();
            $table->foreignId('stage_id')->constrained('projects_stages')->cascadeOnDelete();
            $table->integer('percent');
            $table->string('title');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects_stages_nfs');
    }
};

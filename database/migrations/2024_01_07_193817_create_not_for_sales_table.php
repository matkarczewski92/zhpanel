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
        Schema::create('not_for_sales', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pairing_id')->constrained('litters_pairings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->integer('sex');
            $table->text('annotations')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('not_for_sales');
    }
};

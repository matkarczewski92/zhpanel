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
        Schema::create('litters_pairings_summary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('pairings_id')->constrained('litters_pairings');
            $table->foreignId('litter_id')->constrained('litters');
            $table->integer('vis_amount');
            $table->integer('het_amount');
            $table->boolean('scaleless');
            $table->boolean('tessera');
            $table->boolean('stripe');
            $table->boolean('motley');
            $table->boolean('okeetee');
            $table->boolean('extreme_okeetee');
            $table->double('multiplier', 1, 1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
    }
};

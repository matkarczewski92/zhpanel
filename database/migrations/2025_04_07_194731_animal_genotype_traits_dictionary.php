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
        Schema::create('animal_genotype_traits_dictionary', function (Blueprint $table) {
            $table->id();
            $table->foreignId('trait_id')->constrained('animal_genotype_traits')->onDelete('cascade');
            $table->foreignId('category_id')->constrained('animal_genotype_category')->onDelete('cascade');
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

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
        Schema::create('litters_pairings', function (Blueprint $table) {
            $table->id();
            $table->integer('percent');
            $table->string('title_vis');
            $table->string('title_het')->nullable();
            $table->foreignId('litter_id')->nullable()->constrained('litters')->onDelete('cascade');
            $table->text('img_url')->nullable();
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

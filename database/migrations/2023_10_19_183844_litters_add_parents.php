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
        Schema::table('litters', function (Blueprint $table) {
            $table->foreignId('parent_male')->nullable()->references('id')->on('animals')->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('parent_female')->nullable()->references('id')->on('animals')->nullOnDelete()->cascadeOnUpdate();
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

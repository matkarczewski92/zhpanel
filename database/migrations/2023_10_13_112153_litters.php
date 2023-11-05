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
        Schema::create('litters', function (Blueprint $table) {
            $table->id();
            $table->integer('category')->comment('0-miot, 1-planowane, 2-możliwe, 3-zrealizowane');
            $table->string('litter_code');
            $table->date('connection_date')->nullable();
            $table->date('laying_date')->nullable();
            $table->date('hatching_date')->nullable();
            $table->integer('laying_eggs_total')->nullable();
            $table->integer('laying_eggs_ok')->nullable();
            $table->integer('hatching_eggs')->nullable();
            $table->integer('season')->nullable();
            $table->text('adnotations')->nullable();
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

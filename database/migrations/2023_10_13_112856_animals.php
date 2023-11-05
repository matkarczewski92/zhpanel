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
        Schema::create('animals', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->integer('sex');
            $table->date('date_of_birth');
            $table->foreignId('animal_type_id')->nullable()->constrained('animal_type')->onUpdate('cascade');
            $table->foreignId('litter_id')->nullable()->constrained('litters')->onDelete('set null')->onUpdate('cascade');
            $table->foreignId('feed_id')->nullable()->constrained('feeds')->onDelete('set null')->onUpdate('cascade');
            $table->integer('feed_interval')->nullable();
            $table->foreignId('animal_category_id')->nullable()->constrained('animal_category')->onUpdate('cascade');
            $table->integer('public_profile')->default(0);
            $table->string('public_profile_tag')->nullable();
            $table->integer('web_gallery')->nullable();
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

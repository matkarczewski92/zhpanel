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
        Schema::create('animal_offer_reservations', function (Blueprint $table) {
            $table->id();
            $table->foreignId('offer_id')->constrained('animal_offers')->onDelete('cascade');
            $table->double('deposit', 8, 2)->nullable();
            $table->string('booker')->nullable();
            $table->text('adnotations')->nullable();
            $table->date('expiration_date')->nullable();
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

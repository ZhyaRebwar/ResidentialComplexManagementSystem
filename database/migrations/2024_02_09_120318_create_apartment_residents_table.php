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
        Schema::create('apartment_residents', function (Blueprint $table) {
            $table->id();
            $table->foreignId('apartment_id')->references('id')->on('apartments')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('resident_id')->references('id')->on('users')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['apartment_id','resident_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartment_residents');
    }
};

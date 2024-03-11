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
        Schema::create('house_residents', function (Blueprint $table) {
            $table->id();
            $table->foreignID('house_id')->references('id')->on('houses')->constrained()->cascadeOnDelete()->cascadeOnDelete();
            $table->foreignID('resident_id')->references('id')->on('users')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['house_id','resident_id']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('house_residents');
    }
};

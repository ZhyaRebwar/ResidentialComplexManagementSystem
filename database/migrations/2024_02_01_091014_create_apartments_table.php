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
        Schema::create('apartments', function (Blueprint $table) {
            $table->id();
            $table->integer('floor');
            $table->string('name');
            $table->integer('electricity_unit')->unsigned();
            $table->foreignId('building_id')->references('id')->on('buildings')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('owner_id')->nullable()->references('id')->on('users')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            // composite primary key for id, floor & building_id
            $table->unique(['floor', 'name', 'building_id']);
            $table->timestamps();


        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('apartments');
    }
};

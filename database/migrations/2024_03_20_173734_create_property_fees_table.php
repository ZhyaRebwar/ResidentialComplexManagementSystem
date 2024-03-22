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
        Schema::create('property_fees', function (Blueprint $table) {
            $table->id();
            $table->foreignId('fee_id')->constrained('fees');
            $table->string('property');
            $table->timestamps();
            $table->unique(['fee_id', 'property']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();

        Schema::dropIfExists('property_fees');

        Schema::enableForeignKeyConstraints();
    }
};

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
        Schema::create('fees', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount', 10,2);
            $table->enum('fee_type', ['house fee', 'electricity', 'security', 'water', 'cleaning']);
            $table->timestamps();
            $table->enum('property_type', ['houses', 'apartments']);
            $table->unique(['fee_type', 'property_type']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('fees');
        Schema::enableForeignKeyConstraints();
    }
};

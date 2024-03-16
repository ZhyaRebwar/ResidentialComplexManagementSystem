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
            $table->date('start_date');
            $table->date('end_date')->nullable();
            $table->timestamps();
            $table->text('property');
            $table->unique(['fee_type', 'property']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fees');
    }
};

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
        Schema::create('protests', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->longText('description');
            $table->enum('compliant',['outdoor', 'indoor'])->default('indoor');
            $table->string('picture')->nullable();
            $table->enum('status',['pending', 'rejected', 'approved', 'completed'])->default('pending');
            $table->timestamps();
            $table->foreignId('made_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->string('location'); //for this it will be like this type-id    => houses-23
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('protests');
        Schema::enableForeignKeyConstraints();
    }
};

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
        Schema::create('repairments', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->string('repairment_components')->default('electronic wires');
            $table->longText('description');
            $table->string('picture')->nullable();
            $table->enum('status', ['pending', 'rejected', 'approved', 'completed'])->default('pending');
            $table->timestamp('request_date');
            $table->timestamp('expiration_date')->nullable();
            $table->boolean('completed_user')->default(false);
            $table->boolean('is_viewed')->default(false);
            $table->timestamps();
            $table->foreignId('requested_by')->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('accepted_by')->nullable()->constrained('users');
            $table->string('location'); //for this it will be like this type-id    => houses-23
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('repairments');
        Schema::enableForeignKeyConstraints();
    }
};

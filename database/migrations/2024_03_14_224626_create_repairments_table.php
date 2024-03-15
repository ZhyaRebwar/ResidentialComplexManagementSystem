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
            $table->enum('repairment_components', ['pluming', 'electronic wires', 'electronic devices', 'indoor building'])->default('electronic wires');
            $table->string('picture')->nullable();
            $table->enum('status', ['pending', 'rejected', 'approved', 'completed'])->default('pending');
            $table->timestamp('request_date');
            $table->timestamp('expiration_date')->nullable();
            $table->boolean('completed_user')->default(false);
            $table->timestamps();
            $table->foreignId('requested_by')->constrained('users');
            $table->foreignId('accepted_by')->constrained('users');
            $table->string('location'); //for this it will be like this type-id    => houses-23
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('repairments', function (Blueprint $table) {
            $table->dropForeign(['requested_by']);
            $table->dropForeign(['accepted_by']);
        });
    
        Schema::dropIfExists('repairments');
    }
};

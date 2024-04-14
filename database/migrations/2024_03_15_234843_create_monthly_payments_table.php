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
        Schema::disableForeignKeyConstraints();

        Schema::create('monthly_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date')->nullable()->format('Y-m')->between(date('Y-01-01'), date('Y-12-31'));
            $table->enum('payment_method', ['cash', 'fib'])->default('fib');
            $table->boolean('is_paid')->default(0);
            $table->timestamps();
            $table->foreignId('property_fee_id')->constrained('property_fees')->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('paid_by')->nullable()->constrained('users')->cascadeOnDelete()->cascadeOnUpdate();
            $table->unique(['property_fee_id', 'payment_date']);
        });

        Schema::enableForeignKeyConstraints();
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::disableForeignKeyConstraints();
        Schema::dropIfExists('monthly_payments');
        Schema::enableForeignKeyConstraints();
    }
};

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
        Schema::create('monthly_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount_paid', 10, 2);
            $table->date('payment_date')->format('Y-m')->between(date('Y-01-01'), date('Y-12-31'));
            $table->enum('payment_method', ['cash', 'fib'])->default('fib');
            $table->boolean('paid');
            $table->timestamps();
            $table->foreignId('fee_id')->constrained('fees');
            $table->foreignId('paid_by')->constrained('users');
            $table->unique(['fee_id', 'payment_date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('monthly_payments');
    }
};

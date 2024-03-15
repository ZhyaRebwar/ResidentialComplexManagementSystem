<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('house_service_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount');
            $table->timestamp('payment_date')->nullable();
            $table->enum('service_type', ['electricity', 'water', 'security', 'property fee'])->default('electricity');
            $table->year('year');
            $table->unsignedTinyInteger('month');
            $table->boolean('payment_status')->default(false);
            $table->timestamps();
            $table->foreignId('payed_by')->nullable()->constrained('users');
            $table->foreignId('house_id')->constrained('houses');
        });

        DB::statement('ALTER TABLE house_service_payments ADD CONSTRAINT check_month_range CHECK (month >= 1 and month <= 12)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('house_service_payments', function (Blueprint $table) {
            $table->dropForeign(['payed_by']);
            $table->dropForeign(['house_id']);
        });
    
        Schema::dropIfExists('house_service_payments');
    }
};

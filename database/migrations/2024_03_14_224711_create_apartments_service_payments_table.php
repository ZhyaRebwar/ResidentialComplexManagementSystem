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
        Schema::create('apartment_service_payments', function (Blueprint $table) {
            $table->id();
            $table->decimal('amount');
            $table->timestamp('payment_date')->nullable();
            $table->enum('service_type', ['electricity', 'water', 'security', 'property fee'])->default('electricity');
            $table->year('year');
            $table->unsignedTinyInteger('month');
            $table->boolean('payment_status')->default(false);
            $table->timestamps();
            $table->foreignId('payed_by')->nullable()->constrained('users');
            $table->foreignId('apartment_id')->constrained('apartments');
        });

        DB::statement('ALTER TABLE apartment_service_payments ADD CONSTRAINT check_month_range CHECK (month >= 1 and month <= 12)');
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('apartment_service_payments', function (Blueprint $table) {
            $table->dropForeign(['payed_by']);
            $table->dropForeign(['apartment_id']);
        });
    
        Schema::dropIfExists('apartment_service_payments');
    }
};

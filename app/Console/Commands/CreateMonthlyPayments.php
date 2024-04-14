<?php

namespace App\Console\Commands;

use App\Models\MonthlyPayment;
use App\Models\PropertyFees;
use Carbon\Carbon;
use Illuminate\Console\Command;

class CreateMonthlyPayments extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'app:create-monthly-payments';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Create monthly payment records for the new month payments to be paid by each property';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $current_time = Carbon::now();
        $incompletePayments = PropertyFees::join('fees', 'property_fees.fee_id', '=', 'fees.id')
                                ->where('property_fees.start_date', '<=', $current_time )
                                ->where(function ($query) use ($current_time) {
                                    $query->whereNull('property_fees.end_date')
                                          ->orWhere('property_fees.end_date', '>', $current_time);
                                })
                                ->select('fees.*','property_fees.*')
                                ->get();


        foreach($incompletePayments as $payments)
        {
            $start_date = Carbon::parse($payments->start_date);
            $end_date = Carbon::parse($payments->end_date);

            $diffInMonths = $start_date->diffInMonths($end_date);

            $payment_price = $payments->amount/$diffInMonths;

            MonthlyPayment::create([
                'amount_paid' => $payment_price,
                'property_fee_id' => $payments->id,
            ]);
        }
    }
}

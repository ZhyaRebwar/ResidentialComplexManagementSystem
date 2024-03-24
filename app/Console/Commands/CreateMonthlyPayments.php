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
        $feeIds = [1];

        $current_time = Carbon::now();
        $incompletePayments = PropertyFees::join('fees', 'property_fees.fee_id', '=', 'fees.id')
                                ->where('fees.start_date', '<=', $current_time )
                                ->where(function ($query) use ($current_time) {
                                    $query->whereNull('fees.end_date')
                                          ->orWhere('fees.end_date', '>', $current_time);
                                })
                                ->whereIn('property_fees.fee_id', $feeIds)
                                ->select('fees.*','property_fees.*')
                                ->get();


        foreach($incompletePayments as $payments)
        {
            MonthlyPayment::create([
                'amount_paid' => 53431.21,
                'property_fee_id' => $payments->id,
            ]);
        }
    }
}

<?php

namespace App\Console\Commands;

use App\Models\Transaction;
use Carbon\Carbon;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;

class TransactionStatusCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'transaction:status';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'change transactions status the Overdue';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        DB::table('transactions')
            ->select('transactions.*')
            ->selectRaw('SUM(payments.amount) AS total_payments')
            ->leftJoin('payments', 'transactions.id', '=', 'payments.transaction_id')
            ->groupBy('transactions.id')
            ->havingRaw('SUM(payments.amount) < transactions.amount')
            ->whereDate('transactions.due_on', '<', Carbon::now())
            ->where('status', Transaction::STATUS_OUTSTANDING)
            ->update(['status' => Transaction::STATUS_OVERDUE]);
    }
}

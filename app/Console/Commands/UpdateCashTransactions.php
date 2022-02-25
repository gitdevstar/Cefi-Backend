<?php

namespace App\Console\Commands;

use App\Repositories\OrderRepository;
use Illuminate\Console\Command;

class UpdateCashTransactions extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'everymin:check_cash_transactions';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Update cash transactions every minute';

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

    }
}

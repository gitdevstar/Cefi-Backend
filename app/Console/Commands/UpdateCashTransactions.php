<?php

namespace App\Console\Commands;

use App\Repositories\BankChargeRepository;
use App\Repositories\MobileChargeRepository;
use Illuminate\Console\Command;

class UpdateCashTransactions extends Command
{
    /** @var  MobileChargeRepository */
    private $mobileChargeRepo;

    /** @var  BankChargeRepository */
    private $bankChargeRepo;

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
    public function __construct(MobileChargeRepository $mobileChargeRepo, BankChargeRepository $bankChargeRepo)
    {
        parent::__construct();
        $this->mobileChargeRepo = $mobileChargeRepo;
        $this->bankChargeRepo = $bankChargeRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->mobileChargeRepo->updateStatus();
        $this->bankChargeRepo->updateStatus();
    }
}

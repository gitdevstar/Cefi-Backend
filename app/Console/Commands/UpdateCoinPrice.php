<?php

namespace App\Console\Commands;

use App\Libs\Coingecko\Coingecko;
use App\Models\Coin;
use App\Repositories\CoinRepository;
use Illuminate\Console\Command;

class UpdateCoinPrice extends Command
{
    /** @var  CoinRepository */
    private $coinRepo;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'everymin:set_coin_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set coin data realtime';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(CoinRepository $coinRepo)
    {
        parent::__construct();
        $this->coinRepo = $coinRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->coinRepo->updatePrices();
    }
}

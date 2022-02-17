<?php

namespace App\Console\Commands;

use App\Repositories\OrderRepository;
use Illuminate\Console\Command;

class UpdateOrders extends Command
{
    /** @var  OrderRepository */
    private $orderRepo;

    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'everymin:set_order_data';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Set order data realtime';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct(OrderRepository $orderRepo)
    {
        parent::__construct();
        $this->orderRepo = $orderRepo;
    }

    /**
     * Execute the console command.
     *
     * @return int
     */
    public function handle()
    {
        $this->orderRepo->updateStatus();
    }
}

<?php

namespace App\Repositories;

use Illuminate\Container\Container as Application;

abstract class CoinSummaryRepository
{
    protected $api;

    /**
     * @var Application
     */
    protected $app;

    /**
     * @param  Application  $app
     *
     * @throws \Exception
     */
    public function __construct(Application $app)
    {
        $this->app = $app;
        $this->setupApi();
    }

    public function setupApi()
    {
        $api = $this->app->make($this->api());

        return $this->api = $api;
    }


    abstract public function api();
    abstract public function generateAddress();
    abstract public function order();
    abstract public function swap();
    abstract public function withdraw();
}

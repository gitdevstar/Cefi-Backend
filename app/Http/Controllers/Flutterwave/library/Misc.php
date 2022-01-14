<?php

use Unirest\Request;
use Unirest\Request\Body;

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Flutterwave\library\Rave;

class Misc
{
    function __construct()
    {
        $this->misc = new Rave(Config::get('flutterwave.secret_key'));
    }

    function getBalances()
    {
        $this->misc->setEndPoint("v3/balances");//set the endpoint for the api call


        return $this->misc->getTransferBalance($array);
    }

    function getBalance($array)
    {

        if (!isset($array['currency'])) {
            $array['currency'] = 'NGN';
        }


        //set the payment handler
        $this->misc->setEndPoint("v3/balances/" . $array['currency']);


        return $this->misc->getTransferBalance($array);

    }

    function verifyAccount($array)
    {

        //set the payment handler
        $this->misc->setEndPoint("v3/accounts/resolve");


        return $this->misc->verifyAccount($array);

    }
}

<?php

namespace App\Libs\Flutterwave\library;

require_once('raveEventHandlerInterface.php');

use Illuminate\Support\Facades\Config;
use App\Libs\Flutterwave\library\Rave;
use App\Libs\Flutterwave\library\EventTracker;


class virtualAccountEventHandler implements EventHandlerInterface
{
    use EventTracker;

    /**
     * This is called only when a transaction is successful
     * */
    function onSuccessful($transactionData)
    {
        // Get the transaction from your DB using the transaction reference (txref)
        // Check if you have previously given value for the transaction. If you have, redirect to your successpage else, continue
        // Comfirm that the transaction is successful
        // Confirm that the chargecode is 00 or 0
        // Confirm that the currency on your db transaction is equal to the returned currency
        // Confirm that the db transaction amount is equal to the returned amount
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // Give value for the transaction
        // Update the transaction to note that you have given value for the transaction
        // You can also redirect to your success page from here
        self::sendAnalytics("Virtual-Account");
    }

    /**
     * This is called only when a transaction failed
     * */
    function onFailure($transactionData)
    {
        // Get the transaction from your DB using the transaction reference (txref)
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // You can also redirect to your failure page from here
        self::sendAnalytics("Virtual-Account-error");
    }

    /**
     * This is called when a transaction is requeryed from the payment gateway
     * */
    function onRequery($transactionReference)
    {
        // Do something, anything!
    }

    /**
     * This is called a transaction requery returns with an error
     * */
    function onRequeryError($requeryResponse)
    {
        // Do something, anything!
    }

    /**
     * This is called when a transaction is canceled by the user
     * */
    function onCancel($transactionReference)
    {
        // Do something, anything!
        // Note: Somethings a payment can be successful, before a user clicks the cancel button so proceed with caution

    }

    /**
     * This is called when a transaction doesn't return with a success or a failure response. This can be a timedout transaction on the Rave server or an abandoned transaction by the customer.
     * */
    function onTimeout($transactionReference, $data)
    {
        // Get the transaction from your DB using the transaction reference (txref)
        // Queue it for requery. Preferably using a queue system. The requery should be about 15 minutes after.
        // Ask the customer to contact your support and you should escalate this issue to the flutterwave support team. Send this as an email and as a notification on the page. just incase the page timesout or disconnects

    }
}

class VirtualAccount
{

    function __construct()
    {
        $this->va = new Rave(Config::get('api.flutterwave.secret_key'));
    }

    /**
     * Creating the VirtualAccount
     */

    function createvirtualAccount($userdata)
    {

        if (!isset($userdata['email']) || !isset($userdata['duration']) || !isset($userdata['frequency'])
            || !isset($userdata['amount'])) {
            return '<div class="alert alert-danger" role="alert"> <b>Error:</b>
            The following body params are required:  <b> email, duration, frequency, or amount </b>
          </div>';
        }


        $this->va->eventHandler(new virtualAccountEventHandler)
            //set the endpoint for the api call
            ->setEndPoint("v3/virtual-account-numbers");

        //returns the value of the result.
        ussdEventHandler::startRecording();
        $response = $this->va->createVirtualAccount($userdata);
        ussdEventHandler::sendAnalytics('Create-Virtual-Account');

        return $response;


    }

    function createBulkAccounts($array)
    {

        $this->va->eventHandler(new virtualAccountEventHandler)
            //set the endpoint for the api call
            ->setEndPoint("v3/bulk-virtual-account-numbers");

        //returns the value of the result.
        ussdEventHandler::startRecording();
        $response = $this->va->createBulkAccounts($array);
        ussdEventHandler::sendAnalytics('Create-Bulk-Virtual-Account');

        return $response;
    }

    function getBulkAccounts($array)
    {
        if (!isset($array['batch_id'])) {
            return '<div class="alert alert-danger" role="alert"> <b>Error:</b>
        The following body params are required:  <b> batch_id </b>
      </div>';
        }

        $this->va->eventHandler(new virtualAccountEventHandler)
            //set the endpoint for the api call
            ->setEndPoint("v3/bulk-virtual-account-numbers/" . $array['batch_id']);

        //returns the value of the result.
        ussdEventHandler::startRecording();
        $response = $this->va->getBulkAccounts($array);
        ussdEventHandler::sendAnalytics('Get-Bulk-Virtual-Account');

        return $response;

    }

    function getAccountNumber($array)
    {

        if (!isset($array['order_ref'])) {
            return '<div class="alert alert-danger" role="alert"> <b>Error:</b>
            The following body params are required:  <b> order_ref </b>
          </div>';
        }

        $this->va->eventHandler(new virtualAccountEventHandler)
            //set the endpoint for the api call
            ->setEndPoint("v3/virtual-account-numbers/" . $array['order_ref']);

        //returns the value of the result.
        ussdEventHandler::startRecording();
        $response = $this->va->getvAccountsNum();
        ussdEventHandler::sendAnalytics('Get-Virtual-Account-number');

        return $response;
    }


}





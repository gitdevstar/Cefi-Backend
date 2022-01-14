<?php
namespace App\Http\Controllers\Flutterwave\library;

require_once('raveEventHandlerInterface.php');

use Illuminate\Support\Facades\Config;
use App\Http\Controllers\Flutterwave\library\Rave;
use App\Http\Controllers\Flutterwave\library\EventTracker;

class ussdEventHandler implements EventHandlerInterface
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

        self::sendAnalytics("Initiate-USSD-transfer");
    }

    /**
     * This is called only when a transaction failed
     * */
    function onFailure($transactionData)
    {
        self::sendAnalytics("Initiate-USSD-transfer-error");
        // Get the transaction from your DB using the transaction reference (txref)
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // You can also redirect to your failure page from here

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

class Ussd
{
    protected $ussd;

    function __construct()
    {
        $this->payment = new Rave(Config::get('flutterwave.secret_key'));
        $this->type = "ussd";
    }

    function ussd($array)
    {

        $this->payment->type = 'ussd';

        //add tx_ref to the paylaod
        if (!isset($array['tx_ref']) || empty($array['tx_ref'])) {
            $array['tx_ref'] = $this->payment->txref;
        }


        //set the payment handler
        $this->payment->eventHandler(new ussdEventHandler)
            //set the endpoint for the api call
            ->setEndPoint("v3/charges?type=" . $this->payment->type);
        //returns the value from the results
        ussdEventHandler::startRecording();
        $response= $this->payment->chargePayment($array);
        ussdEventHandler::sendAnalytics('Initiate-USSD-Transfer');

        return $response;

    }

    function verifyTransaction($id)
    {
        //verify the charge
        return $this->payment->verifyTransaction($id);//Uncomment this line if you need it
    }

}

?>

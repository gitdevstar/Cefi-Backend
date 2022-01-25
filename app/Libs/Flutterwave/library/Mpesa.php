<?php

namespace App\Libs\Flutterwave\library;

require("raveEventHandlerInterface.php");

use Illuminate\Support\Facades\Config;
use App\Libs\Flutterwave\library\Rave;
use App\Libs\Flutterwave\library\EventTracker;

class mpesaEventHandler implements EventHandlerInterface{
    use EventTracker;
    /**
     * This is called only when a transaction is successful
     * @param array
     * */
    function onSuccessful($transactionData){
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
        if($transactionData["data"]["chargecode"] === '00' || $transactionData["data"]["chargecode"] === '0'){
            self::sendAnalytics("Initiate-Mpesa");
            echo "Transaction Completed";

        }else{

          $this->onFailure($transactionData);

      }
    }

    /**
     * This is called only when a transaction failed
     * */
    function onFailure($transactionData){
        self::sendAnalytics("Initiate-Mpesa-error");
        // Get the transaction from your DB using the transaction reference (txref)
        // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
        // You can also redirect to your failure page from here

    }

    /**
     * This is called when a transaction is requeryed from the payment gateway
     * */
    function onRequery($transactionReference){
        // Do something, anything!
    }

    /**
     * This is called a transaction requery returns with an error
     * */
    function onRequeryError($requeryResponse){
        // Do something, anything!
    }

    /**
     * This is called when a transaction is canceled by the user
     * */
    function onCancel($transactionReference){
        // Do something, anything!
        // Note: Somethings a payment can be successful, before a user clicks the cancel button so proceed with caution

    }

    /**
     * This is called when a transaction doesn't return with a success or a failure response. This can be a timedout transaction on the Rave server or an abandoned transaction by the customer.
     * */
    function onTimeout($transactionReference, $data){
        // Get the transaction from your DB using the transaction reference (txref)
        // Queue it for requery. Preferably using a queue system. The requery should be about 15 minutes after.
        // Ask the customer to contact your support and you should escalate this issue to the flutterwave support team. Send this as an email and as a notification on the page. just incase the page timesout or disconnects

    }
}

class Mpesa {
    function __construct(){
        $this->payment = new Rave(Config::get('api.flutterwave.secret_key'));
        $this->type = "mpesa";
    }

    function mpesa($array){

        //add tx_ref to the paylaod
        if(!isset($array['tx_ref']) || empty($array['tx_ref'])){
            $array['tx_ref'] = $this->payment->txref;
        }


        $this->payment->type = 'mpesa';

        //set the payment handler
        $this->payment->eventHandler(new mpesaEventHandler)
        //set the endpoint for the api call
        ->setEndPoint("v3/charges?type=".$this->payment->type);
        //returns the value from the results

        mpesaEventHandler::startRecording();
        $response= $this->payment->chargePayment($array);
        mpesaEventHandler::sendAnalytics('Initiate-Mpesa');

        return $response;
    }

     /**you will need to verify the charge
         * After validation then verify the charge with the txRef
         * You can write out your function to execute when the verification is successful in the onSuccessful function
     ***/
    function verifyTransaction(){
        //verify the charge
        return $this->payment->verifyTransaction($this->payment->txref);//Uncomment this line if you need it
    }


}




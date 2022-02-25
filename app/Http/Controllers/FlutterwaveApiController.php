<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Flutterwave\library\MobileMoney;
use App\Libs\Flutterwave\library\Mpesa;
use App\Libs\Flutterwave\library\Ussd;
use App\Libs\Flutterwave\library\Account;
use App\Libs\Flutterwave\library\Transfer;
use App\Libs\Flutterwave\library\Misc;
use App\Libs\Flutterwave\library\momoEventHandler;
use App\Models\User;
use App\Models\MobileCharge;
use App\Repositories\MobileChargeRepository;
use Illuminate\Support\Facades\Log;

class FlutterwaveApiController extends Controller
{
    //
    public function mobileCharge(Request $request)
    {
        $this->validate($request, [
            'currency' => 'required',
            'network' => 'required|in:mobile_money_rwanda,mobile_money_uganda,mobile_money_zambia,mobile_money_ghana,mobile_money_franco,mpesa',
            'amount' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'fullname' => 'required',
        ]);

        $currency = $request->currency;
        $network = $request->network;

        $data = array(
            "amount" => $request->amount,
            "type" => $network,
            "currency" => $currency,
            "email" => $request->email,
            "phone_number" => $request->phone_number,
            "fullname" => $request->fullname,
        );

        if($network == "mpesa")
        {
            $payment = new Mpesa();
            $result = $payment->mpesa($data);
        } else {
            $payment = new MobileMoney();
            $result = $payment->mobilemoney($data);
        }

        return response()->json(['result' => $result]);

        // $id = $result['data']['id'];
        // $verify = $payment->verifyTransaction($id);

        // return response()->json(['result' => $result, 'verify' => $verify]);
    }

    public function bankCharge(Request $request)
    {
        $this->validate($request, [
            'currency' => 'required_if:network,ussd|in:NGN|in:NGN,GBP',
            'network' => 'required|in:ussd,bank',
            'type' => 'required_if:network,bank|in:debit_ng_account,debit_uk_account',
            'account_bank' => 'required_if:network,ussd|in:044,050,070,011,214,058,030,082,221,232,032,033,215,090110,035,057',
            'account_number' => 'required_if:network,bank',
            'amount' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'fullname' => 'required',
        ]);

        $currency = $request->currency;
        $network = $request->network;

        if($network == "ussd")
        {
            $data = array(
                "amount" => $request->amount,
                "account_bank" => $request->account_bank,
                "currency" => $currency,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "fullname" => $request->fullname,
            );

            $payment = new Ussd();
            $result = $payment->ussd($data);
        } else {
            $data = array(
                "amount" => $request->amount,
                "type" => $request->type,
                "account_bank" => $request->account_bank,
                "account_number" => $request->account_number,
                "currency" => $currency,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "fullname" => $request->fullname,
            );

            $payment = new Account();
            $result = $payment->accountCharge($data);
        }


        if(isset($result['data'])){
            $id = $result['data']['id'];
            $verify = $payment->verifyTransaction($id);
            return response()->json(['result' => $result, 'verify' => $verify]);
        } else {
            return response()->json(['error' => $result['message'], 'result' => $result]);
        }

    }

    public function mobilePayout(Request $request)
    {
        $this->validate($request, [
            'currency' => 'required',
            'amount' => 'required',
            'type' => 'in:MTN,TIGO,VODAFONE,AIRTEL',
            'email' => 'required|email',
            'phone_number' => 'required',
            'fullname' => 'required',
        ]);

        $type = $request->type;
        $data = array(
            "account_bank"=> $type ?? "MPS",
            "account_number"=> $request->phone_number,
            "amount"=> $request->amount,
            "currency"=> $request->currency,
            "debit_currency"=> "USD"
        );

        $getdata = array(
            //"reference"=>"edf-12de5223d2f32434753432"
             "id"=>"BIL136",
             "product_id"=>"OT150"
        );

        $listdata = array(
            'status'=>'failed'
        );

        $feedata = array(
            'currency'=> $request->currency, //if currency is omitted. the default currency of NGN would be used.
            'amount'=> 1000
        );

        $payment = new Transfer();
        $result = $payment->singleTransfer($data);//initiate single transfer payment
        // $getTransferFee = $payment->getTransferFee($feedata);
        $verify = null;
        if(isset($result['data'])){
            $id = $result['data']['id'];
            $verify = $payment->verifyTransaction($id);
        }

        return response()->json(['result' => $result, 'verify' => $verify]);
    }

    public function bankPayout(Request $request)
    {
        $this->validate($request, [
            'account_bank' => 'required|in:044,050,070,011,214,058,030,082,221,232,032,033,215,090110,035,057',
            'account_number' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'email' => 'required|email',
            'fullname' => 'required',
        ]);

        $type = $request->type;
        $data = array(
            "account_bank"=> $request->account_bank,
            "account_number"=> $request->account_number,
            "amount"=> $request->amount,
            "currency"=> $request->currency,
            "debit_currency"=> $request->currency
        );

        $getdata = array(
            //"reference"=>"edf-12de5223d2f32434753432"
             "id"=>"BIL136",
             "product_id"=>"OT150"
        );

        $listdata = array(
            'status'=>'failed'
        );

        $feedata = array(
            'currency'=> $request->currency, //if currency is omitted. the default currency of NGN would be used.
            'amount'=> 1000
        );

        $payment = new Transfer();
        $result = $payment->singleTransfer($data);//initiate single transfer payment
        // $getTransferFee = $payment->getTransferFee($feedata);
        $verify = null;
        if(isset($result['data'])){
            $id = $result['data']['id'];
            $verify = $payment->verifyTransaction($id);
        }

        return response()->json(['result' => $result, 'verify' => $verify]);
    }

    public function rate(Request $request)
    {
        $this->validate($request, [
            'from' => 'required',
            'to' => 'required'
        ]);

        $data = array(
            'from' => $request->from,
            'to' => $request->to
        );

        $misc = new Misc();
        $result = $misc->rate($data);

        return response()->json(['result' => $result]);
    }

    public function payoutFee(Request $request)
    {
        $this->validate($request, [
            'amount' => 'required',
            'currency' => 'required',
            'type' => 'required|in:mobilemoney,account'
        ]);

        $data = array(
            'amount' => $request->amount,
            'currency' => $request->currency,
            'type' => $request->type
        );

        $payout = new Transfer();
        $result = $payout->getTransferFee($data);

        return response()->json(['result' => $result]);
    }

    public function webhook(Request $request)
    {

    }

    public function mobileChargeWebhook(Request $request)
    {
        Log::info('flutter mobile charge: '.json_encode($request));
        $id = $request->id;
        $data = $request->data;
        $charge = MobileCharge::find($id);
        $charge->status = $data['status'];
        $charge->save();
        if ($data->status == 'SUCCESSFUL') {
            $user = User::find($charge->user_id);
            $user->balance += $data['amount'];
            $user->save();
        }
    }

    public function verifyTransaction(Request $request, MobileChargeRepository $repo)
    {
        $transaction = $repo->verifyTransaction($request->txn_id);
        return response()->json($transaction);
    }
}

// class MobileChargeEventHandler extends momoEventHandler {
//     function onSuccessful($transactionData)
//     {
//         Log::info('mobilecharge momo event: '.json_encode($transactionData));
//         if ($transactionData["data"]["chargecode"] === '00' || $transactionData["data"]["chargecode"] === '0') {
//             self::sendAnalytics("Initiate-Mobile-Money-charge");
//             echo "Transaction Completed";
//         } else {
//             $this->onFailure($transactionData);
//         }
//     }

//     /**
//      * This is called only when a transaction failed
//      * */
//     function onFailure($transactionData)
//     {
//         Log::info('mobilecharge momo failure event: '.json_encode($transactionData));
//         self::sendAnalytics("Initiate-Mobile-Money-error");
//         // Get the transaction from your DB using the transaction reference (txref)
//         // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
//         // You can also redirect to your failure page from here

//     }

//     /**
//      * This is called when a transaction is requeryed from the payment gateway
//      * */
//     function onRequery($transactionReference)
//     {
//         // Do something, anything!
//     }

//     /**
//      * This is called a transaction requery returns with an error
//      * */
//     function onRequeryError($requeryResponse)
//     {
//         // Do something, anything!
//     }

//     /**
//      * This is called when a transaction is canceled by the user
//      * */
//     function onCancel($transactionReference)
//     {
//         // Do something, anything!
//         // Note: Somethings a payment can be successful, before a user clicks the cancel button so proceed with caution

//     }

//     /**
//      * This is called when a transaction doesn't return with a success or a failure response. This can be a timedout transaction on the Rave server or an abandoned transaction by the customer.
//      * */
//     function onTimeout($transactionReference, $data)
//     {
//         // Get the transaction from your DB using the transaction reference (txref)
//         // Queue it for requery. Preferably using a queue system. The requery should be about 15 minutes after.
//         // Ask the customer to contact your support and you should escalate this issue to the flutterwave support team. Send this as an email and as a notification on the page. just incase the page timesout or disconnects

//     }
// }

// class MpesaEventHandler extends mpesaEventHandler {
//     function onSuccessful($transactionData)
//     {
//         Log::info('mobilecharge mpesa event: '.json_encode($transactionData));
//         if ($transactionData["data"]["chargecode"] === '00' || $transactionData["data"]["chargecode"] === '0') {
//             // self::sendAnalytics("Initiate-Mobile-Money-charge");
//             echo "Transaction Completed";
//         } else {
//             $this->onFailure($transactionData);
//         }
//     }

//     /**
//      * This is called only when a transaction failed
//      * */
//     function onFailure($transactionData)
//     {
//         Log::info('mobilecharge mpesa failure event: '.json_encode($transactionData));
//         // self::sendAnalytics("Initiate-Mobile-Money-error");
//         // Get the transaction from your DB using the transaction reference (txref)
//         // Update the db transaction record (includeing parameters that didn't exist before the transaction is completed. for audit purpose)
//         // You can also redirect to your failure page from here

//     }

//     /**
//      * This is called when a transaction is requeryed from the payment gateway
//      * */
//     function onRequery($transactionReference)
//     {
//         // Do something, anything!
//     }

//     /**
//      * This is called a transaction requery returns with an error
//      * */
//     function onRequeryError($requeryResponse)
//     {
//         // Do something, anything!
//     }

//     /**
//      * This is called when a transaction is canceled by the user
//      * */
//     function onCancel($transactionReference)
//     {
//         // Do something, anything!
//         // Note: Somethings a payment can be successful, before a user clicks the cancel button so proceed with caution

//     }

//     /**
//      * This is called when a transaction doesn't return with a success or a failure response. This can be a timedout transaction on the Rave server or an abandoned transaction by the customer.
//      * */
//     function onTimeout($transactionReference, $data)
//     {
//         // Get the transaction from your DB using the transaction reference (txref)
//         // Queue it for requery. Preferably using a queue system. The requery should be about 15 minutes after.
//         // Ask the customer to contact your support and you should escalate this issue to the flutterwave support team. Send this as an email and as a notification on the page. just incase the page timesout or disconnects

//     }
// }

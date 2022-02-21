<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Libs\Flutterwave\library\MobileMoney;
use App\Libs\Flutterwave\library\Mpesa;
use App\Libs\Flutterwave\library\Ussd;
use App\Libs\Flutterwave\library\Account;
use App\Libs\Flutterwave\library\Transfer;
use App\Libs\Flutterwave\library\Misc;
use App\Models\MobileCharge;
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
        $charge->status = $data->status;
        $charge->save();
    }
}

<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

use Flutterwave\MobileMoney;
use Flutterwave\Mpesa;
use Flutterwave\Ussd;
use Flutterwave\Transfer;

class FlutterwaveApiController extends Controller
{
    //
    public function mobileCharge(Request $request)
    {
        $this->validate($request, [
            'currency' => 'required',
            'network' => 'required|in:mobile_money_rwanda,mobile_money_uganda,mobile_money_zambia,mobile_money_ghana,mobile_money_franco,mpesa',
            // 'bank' => 'required_if:network,ussd|in:044,050,070,011,214,058,030,082,221,232,032,033,215,090110,035,057',
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
                "account_bank" => $request->bank,
                "currency" => $currency,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "fullname" => $request->fullname,
            );
        } else {
            $data = array(
                // "order_id" => "USS_URG_89245453s2323",
                "amount" => $request->amount,
                "type" => $network,
                "currency" => $currency,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "fullname" => $request->fullname,
            );
        }

        if($network == "mpesa")
        {
            $payment = new Mpesa();
            $result = $payment->mpesa($data);
        } else {
            $payment = new MobileMoney();
            $result = $payment->mobilemoney($data);
        }


        $id = $result['data']['id'];
        $verify = $payment->verifyTransaction($id);

        return response()->json(['result' => $result, 'verify' => $verify]);
    }

    public function bankCharge(Request $request)
    {
        $this->validate($request, [
            'currency' => 'required',
            'type' => 'required|in:ussd',
            'account_bank' => 'required_if:type,ussd|in:044,050,070,011,214,058,030,082,221,232,032,033,215,090110,035,057',
            'amount' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'fullname' => 'required',
        ]);

        $currency = $request->currency;
        $type = $request->type;

        if($type == "ussd")
        {
            $data = array(
                "amount" => $request->amount,
                "account_bank" => $request->account_bank,
                "currency" => $currency,
                "email" => $request->email,
                "phone_number" => $request->phone_number,
                "fullname" => $request->fullname,
            );
        }

        $payment = new Ussd();
        $result = $payment->ussd($data);

        if(isset($result['data'])){
            $id = $result['data']['id'];
            $verify = $payment->verifyTransaction($id);
            return response()->json(['result' => $result, 'verify' => $verify]);
        } else {
            return response()->json(['error' => 'Network error']);
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

    public function webhook(Request $request)
    {

    }
}

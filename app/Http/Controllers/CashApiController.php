<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\BankCharge;
use App\Models\BankPayout;
use App\Models\MobileCharge;
use App\Models\MobilePayout;

use App\Libs\Flutterwave\library\MobileMoney;
use App\Libs\Flutterwave\library\Mpesa;
use App\Libs\Flutterwave\library\Ussd;
use App\Libs\Flutterwave\library\Account;
use App\Libs\Flutterwave\library\Transfer;
use App\Libs\Flutterwave\library\Misc;
use App\Models\PayHistory;
use App\Models\User;
use App\Models\Withdraw;
use App\Repositories\UserRepository;
use Illuminate\Support\Facades\Log;

class CashApiController extends Controller
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

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

        $charge = MobileCharge::create([
            'user_id' => Auth::id(),
            'currency' => $currency,
            'network' => $network,
            'amount' => $request->amount,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'full_name' => $request->fullname,
            'txn_id' => '',
        ]);

        if($network == "mpesa")
        {
            $payment = new Mpesa();
            $result = $payment->mpesa($data);
        } else {
            if($network != 'mobile_money_franco')
                $data['redirect_url'] = 'http://52.14.18.78/api/flutter/mobilecharge/webhook/'.$charge->id;
            $payment = new MobileMoney();
            $result = $payment->mobilemoney($data);
        }

        $charge->txn_id = $result['data']['tx_ref'] ?? '';
        $charge->redirect_url = isset($result['meta']) ? $result['meta']['authorization']['redirect']: null;
        $charge->save();

        return response()->json(['result' => $result]);

        // $id = $result['data']['id'];
        // $verify = $payment->verifyTransaction($id);

        // return response()->json(['result' => $result, 'verify' => $verify]);
    }

    public function bankCharge(Request $request)
    {
        $this->validate($request, [
            'type' => 'required|in:debit_ng_account,debit_uk_account,ussd',
            // 'account_bank' => 'required_if:type,ussd|in:044,050,070,011,214,058,030,082,221,232,032,033,215,035,057',
            'account_bank' => 'required',
            // 'account_number' => 'required_unless:type,ussd',
            'currency' => 'required',//'required_if:type,ussd|in:NGN|in:NGN,GBP',
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

            $payment = new Ussd();
            $result = $payment->ussd($data);
        } else {
            $data = array(
                "amount" => $request->amount,
                "type" => $type,
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

        BankCharge::create([
            'user_id' => Auth::user()->id,
            'currency' => $currency,
            'network' => $type,
            'account_bank' => $request->account_bank,
            'account_number' => $request->account_number ?? null,
            'amount' => $request->amount,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'full_name' => $request->fullname,
            'txn_id' => $result['tx_ref']
        ]);


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
            'type' => 'in:MPS,MTN,TIGO,VODAFONE,AIRTEL',
            'email' => 'required|email',
            'phone_number' => 'required',
            'fullname' => 'required',
        ]);

        $type = $request->type ?? "MPS";
        $data = array(
            "account_bank"=> $type,
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
            MobilePayout::create([
                'user_id' => Auth::user()->id,
                'currency' => $request->currency,
                'type' => $type,
                'amount' => $request->amount,
                'email' => $request->email,
                'phone' => $request->phone_number,
                'full_name' => $request->fullname,
                'fee' => 0,
                'txn_id' => $id
            ]);
            $verify = $payment->verifyTransaction($id);
            return response()->json(['result' => $result, 'verify' => $verify]);
        } else {
            return response()->json(['error' => $result], 500);
        }

    }

    public function bankPayout(Request $request)
    {
        $this->validate($request, [
            'account_bank' => 'required',
            'account_number' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'email' => 'required|email',
            'fullname' => 'required',
        ]);

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
            BankPayout::create([
                'user_id' => Auth::user()->id,
                'currency' => $request->currency,
                'account_bank' => $request->account_bank,
                'account_number' => $request->account_number,
                'amount' => $request->amount,
                'email' => $request->email,
                'full_name' => $request->fullname,
                'fee' => 0,
                'txn_id' => $id
            ]);
            $verify = $payment->verifyTransaction($id);
            return response()->json(['result' => $result, 'verify' => $verify]);
        } else {
            return response()->json(['error' => $result], 500);
        }

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
        $result['data']['fee'] = 8;

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

    public function pay(Request $request)
    {
        $this->validate($request, [
            'receiver' => 'required|email',
            'amount' => 'required'
        ]);

        $amount = $request->amount;

        try {
            $users = $this->userRepository->all(
                [ 'email' => $request->receiver ]);
            if (count($users) == 0) {
                return response()->json(['status' => false, 'error' => 'Can\'t find receiver.']);
            }
            $receiver = $users[0];
            $this->userRepository->pay($amount, $receiver);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
        }

        return response()->json(['status' => true]);
    }

    public function withdrawFee()
    {
        $fee = 25; // %

        return response()->json(['fee' => $fee]);
    }

    public function withdraw(Request $request)
    {
        $this->validate($request, [
            'to' => 'required|email',
            'amount' => 'required'
        ]);

        $user = Auth::user();
        $amount = $request->amount;
        if($amount == 0)
            return response()->json(['status' => false, 'error' => 'Invalidate amount.'], 500);
        if($user->balance < $amount)
            return response()->json(['status' => false, 'error' => 'Insufficient amount.'], 500);

        Withdraw::create([
            'user_id' => $user->id,
            'to' => $request->to,
            'kind' => 'Cash',
            'amount' => $amount,
        ]);

        return response()->json(['status' => true, 'message' => 'Sent your withdraw request. It will take 2 or 3 business days.']);
    }

    public function mobileChargeHistory()
    {
        $user = Auth::user();
        $charges = $user->mobileCharges;

        return response()->json(['result' => $charges]);
    }

    public function bankChargeHistory()
    {
        $user = Auth::user();
        $charges = $user->bankCharges;

        return response()->json(['result' => $charges]);
    }

    public function mobilePayoutHistory()
    {
        $user = Auth::user();
        $payouts = $user->mobilePayouts;

        return response()->json(['result' => $payouts]);
    }

    public function bankPayoutHistory()
    {
        $user = Auth::user();
        $payouts = $user->bankPayouts;

        return response()->json(['result' => $payouts]);
    }

    public function payHistory()
    {
        $userId = Auth::id();
        $pays = PayHistory::where('sender_id', $userId)->orWhere('receiver_id', $userId)->get();

        return response()->json(['result' => $pays]);
    }
}

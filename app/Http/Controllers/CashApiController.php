<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use anlutro\LaravelSettings\Facade as Setting;

use App\Libs\Flutterwave\library\Transfer;
use App\Libs\Flutterwave\library\Misc;
use App\Models\PayHistory;
use App\Models\User;
use App\Repositories\BankChargeRepository;
use App\Repositories\BankPayoutRepository;
use App\Repositories\MobileChargeRepository;
use App\Repositories\MobilePayoutRepository;
use App\Repositories\UserRepository;
use App\Repositories\WithdrawRepository;

class CashApiController extends Controller
{
    /** @var  UserRepository */
    private $userRepository;

    public function __construct(UserRepository $userRepository)
    {
        $this->userRepository = $userRepository;
    }

    public function mobileCharge(Request $request, MobileChargeRepository $moileChargeRepo)
    {
        $this->validate($request, [
            'currency' => 'required',
            'network' => 'required|in:mobile_money_rwanda,mobile_money_uganda,mobile_money_zambia,mobile_money_ghana,mobile_money_franco,mpesa',
            // 'type' => 'required_if:network,mobile_money_ghana|in:MTN,VODAFONE,TIGO',
            'amount' => 'required',
            'email' => 'required|email',
            'phone_number' => 'required',
            'fullname' => 'required',
        ]);

        try {
            $result = $moileChargeRepo->charge($request);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(['result' => $result]);
    }

    public function bankCharge(Request $request, BankChargeRepository $repo)
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

        try {
            $result = $repo->charge($request);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(['result' => $result]);

    }

    public function mobilePayout(Request $request, MobilePayoutRepository $moilePayoutRepo)
    {
        $this->validate($request, [
            'currency' => 'required',
            'amount' => 'required',
            'type' => 'in:MPS,MTN,TIGO,VODAFONE,AIRTEL',
            'email' => 'required|email',
            'phone_number' => 'required',
            'fullname' => 'required',
        ]);

        try {
            $result = $moilePayoutRepo->payout($request);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(['result' => $result]);
    }

    public function bankPayout(Request $request, BankPayoutRepository $bankPayoutRepo)
    {
        $this->validate($request, [
            'account_bank' => 'required',
            'account_number' => 'required',
            'currency' => 'required',
            'amount' => 'required',
            'email' => 'required|email',
            'fullname' => 'required',
        ]);

        try {
            $result = $bankPayoutRepo->payout($request);
        } catch (\Throwable $th) {
            return response()->json(['error' => $th->getMessage()], 500);
        }

        return response()->json(['result' => $result]);

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
        $result['data']['fee'] = Setting::get('cash_conversation_fee', 8);

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
        $fee = Setting::get('paypal_withdraw_fee', 25);

        return response()->json(['fee' => $fee]);
    }

    public function withdraw(Request $request, WithdrawRepository $repo)
    {
        $this->validate($request, [
            'to' => 'required|email',
            'amount' => 'required'
        ]);

        try {
            $result = $repo->request($request);
        } catch (\Throwable $th) {
            return response()->json(['status' => false, 'error' => $th->getMessage()], 500);
        }

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

        foreach ($pays as $payment) {
            $payment['sender'] = User::find($payment->sender_id)->email;
            $payment['receiver'] = User::find($payment->receiver_id)->email;
        }

        return response()->json(['result' => $pays]);
    }
}

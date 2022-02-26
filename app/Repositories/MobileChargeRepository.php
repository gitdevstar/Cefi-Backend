<?php

namespace App\Repositories;

use App\Libs\Flutterwave\library\MobileMoney;
use App\Libs\Flutterwave\library\Mpesa;
use App\Models\MobileCharge;
use App\Models\User;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

/**
 * Class MobileChargeRepository
 * @package App\Repositories
 * @version March 27, 2020, 5:16 pm EDT
*/

class MobileChargeRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'txn_id', 'status'
    ];

    /**
     * Return searchable fields
     *
     * @return array
     */
    public function getFieldsSearchable()
    {
        return $this->fieldSearchable;
    }

    /**
     * Configure the Model
     **/
    public function model()
    {
        return MobileCharge::class;
    }

    public function charge(Request $request)
    {
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

        $chargeData = [
            'user_id' => Auth::id(),
            'currency' => $currency,
            'network' => $network,
            'amount' => $request->amount,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'full_name' => $request->fullname,
            'txn_id' => '',
        ];

        $charge = $this->create($chargeData);

        if($network == "mpesa")
        {
            $payment = new Mpesa();
            try {
                $result = $payment->mpesa($data);
            } catch (\Throwable $th) {
                $this->delete($charge->id);
                $error = json_decode($th->getMessage(), true);
                throw new Exception($error['message']);
            }
        }
        else {
            if($network != 'mobile_money_franco')
                $data['redirect_url'] = 'https://okanewallet.com/api/flutter/mobilecharge/webhook/'.$charge->id;
            if($network == 'mobile_money_ghana')
                $data['network'] = $request->type ?? "MTN";
            $payment = new MobileMoney();
            try {
                $result = $payment->mobilemoney($data);
            } catch (\Throwable $th) {
                $this->delete($charge->id);
                $error = json_decode($th->getMessage(), true);
                throw new Exception($error['message']);
            }
        }

        if  ($result['status'] == 'error') {
            $this->delete($charge->id);
            throw new Exception($result['message']);
        }

        if (isset($result['data'])) {
            $charge->tx_ref = $result['data']['tx_ref'] ?? '';
            $charge->txn_id = $result['data']['id'] ?? '';
        }
        //     $charge->status = $result['data']['status'];
        $charge->redirect_url = isset($result['meta']) && $result['meta']['authorization']['mode'] == 'redirect' ? $result['meta']['authorization']['redirect']: null;
        $charge->save();

        return $result;
    }

    public function updateStatus()
    {
        $charges = MobileCharge::where('status', 'CREATED')->get();
        foreach($charges as $charge) {
            if($charge->txn_id != '') {
                if($charge->network == 'mpesa') {
                    $payment = new Mpesa();
                    $transaction = $payment->verifyTransaction($charge->txn_id);
                } else {
                    $payment = new MobileMoney();
                    $transaction = $payment->verifyTransaction($charge->txn_id);
                }

                if($transaction['status'] == 'success') {
                    $data = $transaction['data'];
                    $status = $data['status'];
                    if($status == 'successful') {
                        $amount = $data['amount_settled'];
                        $user = User::find($charge->user_id);
                        $user->balance += $amount;
                        $user->save();
                    }
                    $charge->status = $status;
                    $charge->save();
                }
            }
        }
    }

    public function verifyTransaction($txnId)
    {
        $payment = new MobileMoney();
        $transactions = $payment->verifyTransaction($txnId);
        return $transactions;
    }
}

<?php

namespace App\Repositories;

use App\Libs\Flutterwave\library\Account;
use App\Libs\Flutterwave\library\Ussd;
use App\Models\BankCharge;
use App\Models\User;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class BankChargeRepository
 * @package App\Repositories
 * @version March 27, 2020, 5:16 pm EDT
*/

class BankChargeRepository extends BaseRepository
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
        return BankCharge::class;
    }

    public function charge(Request $request)
    {

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
            try {
                $result = $payment->ussd($data);
            } catch (\Throwable $th) {
                $error = json_decode($th->getMessage(), true);
                throw new Exception($error['message']);
            }
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
            try {
                $result = $payment->accountCharge($data);
            } catch (\Throwable $th) {
                $error = json_decode($th->getMessage(), true);
                throw new Exception($error['message']);
            }
        }

        if($result['status'] == 'error') {
            throw new Exception($result['message']);
        }

        $data = array(
            'user_id' => Auth::id(),
            'currency' => $currency,
            'network' => $type,
            'account_bank' => $request->account_bank,
            'account_number' => $request->account_number ?? null,
            'amount' => $request->amount,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'full_name' => $request->fullname,
            'txn_id' => $result['data']['id'] ?? '',
            'tx_ref' => $result['data']['tx_ref'] ?? ''
        );
        $this->create($data);

        return $result;
    }

    public function updateStatus()
    {
        $charges = BankCharge::where('status', 'CREATED')->get();
        foreach($charges as $charge) {
            if($charge->txn_id != '') {
                if($charge->network == 'ussd') {
                    $payment = new Ussd();
                    $transaction = $payment->verifyTransaction($charge->txn_id);
                } else {
                    $payment = new Account();
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
}

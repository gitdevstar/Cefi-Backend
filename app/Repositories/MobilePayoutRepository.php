<?php

namespace App\Repositories;

use anlutro\LaravelSettings\Facade as Setting;

use App\Libs\Flutterwave\library\Transfer;
use App\Libs\Flutterwave\library\Mpesa;
use App\Libs\Flutterwave\library\Misc;
use App\Models\MobilePayout;
use App\Models\User;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

/**
 * Class MobilePayoutRepository
 * @package App\Repositories
 * @version March 27, 2020, 5:16 pm EDT
*/

class MobilePayoutRepository extends BaseRepository
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
        return MobilePayout::class;
    }

    public function payout(Request $request)
    {
        $user = Auth::user();
        $payable = 0;
        try {
            $misc = new Misc();
            $data = array(
                'from' => $request->currency,
                'to' => 'USD'
            );
            $result = $misc->rate($data);
            if($result['status'] == 'success') {
                $rate = $result['data']['rate'];
                $fee = 0;
                $payable = $request->amount * $rate * (100 - $fee) * 0.01;
                if($user->balance < $payable)
                    throw new Exception("Insufficient balance.");
            }
        } catch (\Throwable $th) {
            throw $th;
        }

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

        if($result['status'] == 'error') {
            throw new Exception($result['message']);
        }

        $id = $result['data']['id'];

        $payoutData = [
            'user_id' => $user->id,
            'currency' => $request->currency,
            'type' => $type,
            'amount' => $request->amount,
            'email' => $request->email,
            'phone' => $request->phone_number,
            'full_name' => $request->fullname,
            'fee' => 0,
            'txn_id' => $id
        ];

        $this->create($payoutData);

        $user->balance -= $payable;
        $user->save();

        return $result;

    }

    public function updateStatus()
    {
        $fee = Setting::get('cash_conversation_fee', 8);
        $charges = MobilePayout::whereIn('status', ['CREATED', 'pending'])->get();
        foreach($charges as $charge) {
            if($charge->txn_id != '') {
                if($charge->network == 'mpesa') {
                    $payment = new Mpesa();
                    $transaction = $payment->verifyTransaction($charge->txn_id);
                } else {
                    // $payment = new MobileMoney();
                    // $transaction = $payment->verifyTransaction($charge->txn_id);
                }

                if($transaction['status'] == 'success') {
                    $data = $transaction['data'];
                    $status = $data['status'];
                    if($status == 'successful') {
                        $amount = $data['amount_settled'];
                        $data = array(
                            'from' => $charge->currency,
                            'to' => 'USD'
                        );
                        try {
                            $misc = new Misc();
                            $result = $misc->rate($data);
                            if($result['status'] == 'success') {
                                $rate = $result['data']['rate'];
                                $value = $amount * $rate * (100 - $fee) * 0.01;
                                $user = User::find($charge->user_id);
                                $user->balance += $value;
                                $user->save();
                            }
                        } catch (\Throwable $th) {
                            //throw $th;
                        }
                    }
                    $charge->status = $status;
                    $charge->save();
                }
            }
        }
    }


}

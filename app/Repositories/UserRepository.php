<?php

namespace App\Repositories;

use App\Models\CoinCallbackAddress;
use App\Models\CoinDeposit;
use App\Models\CoinWallet;
use App\Models\User;
use App\Repositories\BaseRepository;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version March 27, 2020, 5:16 pm EDT
*/

class UserRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [

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
        return User::class;
    }

    public function updateCoinBalance($data)
    {
        $callback = CoinCallbackAddress::where('address', $data['address'])->first();
        if(isset($callback)) {

            $userId = $callback->user_id;

            if($data['confirmations'] == 1) {
                $coin = $data['currency'];

                $user = User::find($userId);
                // $user->updateBalance();
                $walletBalance = $user->coinwallet($coin) ? $user->coinwallet($coin)->balance : 0;
                CoinWallet::updateOrCreate(
                    ['user_id' => $userId, 'coin' => $coin],
                    ['balance' => $walletBalance + $data['amount']]
                );

                CoinDeposit::updateOrCreate(
                    ['txn_id'=> $data['txid']],
                    ['user_id' => $userId, 'address' => $data['address'], 'txn_id' => $data['txid'], 'symbol' => $data['currency'], 'confirms' => $data['confirmations'], 'amount' => $data['amount']]
                );

                $callback->delete();

            }
        }
    }
}

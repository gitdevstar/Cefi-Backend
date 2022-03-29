<?php

namespace App\Repositories;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Models\Withdraw;
use App\Repositories\BaseRepository;
use Exception;

/**
 * Class UserRepository
 * @package App\Repositories
 * @version March 27, 2020, 5:16 pm EDT
*/

class WithdrawRepository extends BaseRepository
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
        return Withdraw::class;
    }

    public function request(Request $request) {
        $user = Auth::user();
        $amount = $request->amount;
        if($amount == 0)
            throw new Exception("Invalidate amount.");
        if($user->balance < $amount)
            throw new Exception("Insufficient amount.");

        $this->create([
            'user_id' => $user->id,
            'to' => $request->to,
            'kind' => 'Cash',
            'amount' => $amount,
        ]);
    }

    public function unapprove($id)
    {
        $this->update(['status' => 2], $id);
    }

    public function approve($id)
    {
        $payment = Withdraw::find($id);
        $amount = $payment->amount;
        $user = User::find($payment->id);
        if($payment->kind == 'Cash') {
            if($amount > $user->balance)
            {
                $this->unapprove($id);
                throw new Exception("Insufficient balance");
            } else {
                $user->balance -= $amount;
                $user->save();
                $this->update(['status' => 1], $id);
            }
        } else {
            $coinwallet = $user->coinwallet('USDC');
            if($amount > $coinwallet->balance)
            {
                $this->unapprove($id);
                throw new Exception("Insufficient USDC balance");
            } else {
                $coinwallet->balance -= $amount;
                $coinwallet->save();
                $this->update(['status' => 1], $id);
            }
        }

    }
}

<?php

namespace App\Repositories;

use App\Models\Order;
use App\Repositories\BaseRepository;
use Exception;
use Illuminate\Support\Facades\Config;
use Lin\Coinbase\CoinbasePro;

/**
 * Class OrderRepository
 * @package App\Repositories
 * @version March 27, 2020, 5:16 pm EDT
*/

class OrderRepository extends BaseRepository
{
    /**
     * @var array
     */
    protected $fieldSearchable = [
        'txn_id', 'status'
    ];

    protected $coinbasePro;

    public function __construct()
    {
        $this->coinbasePro = new CoinbasePro(
            Config::get('api.coinbase_pro.api_key'),
            Config::get('api.coinbase_pro.secret_key'),
            Config::get('api.coinbase_pro.passphrase')
        );
    }

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
        return Order::class;
    }

    public function cancel($id)
    {
        try {
            $orders = $this->all(['txn_id' => $id]);
            if(count($orders) == 0)
                throw new Exception("No exist order");
            $orderId = $orders[0]->id;
            $this->coinbasePro->order()->delete(['id' => $id]);
        } catch (\Throwable $th) {
            $error = json_decode($th->getMessage(), true);
            throw new Exception($error['message']);
        }
        $this->update(['status' => 'Cancelled'], $orderId);
    }

    public function order($data)
    {
        try {

            $result = $this->coinbasePro->order()->post([
                'type' => $data["type"],
                'side' => $data["side"],
                'product_id' => $data["pair"],
                // 'price'=>$price,
                'size' => $data["amount"]
            ]);
        } catch (\Throwable $th) {
            $error = json_decode($th->getMessage(), true);
            throw new Exception($error['message']);
        }

        $data['txn_id'] = $result['id'];

        $this->create($data);

    }

    public function updateStatus()
    {
        $orders = $this->all(['status' => 'Created']);

        foreach($orders as $order) {
            try {
                $result = $this->coinbasePro->order()->get(['id' => $order->txn_id]);
                $order->status = $result['status'];
                $order->save();
            } catch (\Throwable $th) {
                //throw $th;
            }
        }
    }
}

<?php

namespace App\Repositories;

use App\Libs\Coingecko\Coingecko;
use App\Models\Coin;
use App\Repositories\BaseRepository;

class CoinRepository extends BaseRepository
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
        return Coin::class;
    }

    public function getIds()
    {
        $coins = $this->all();
        $ids = array_column(json_decode($coins), 'coingecko_id');
        return implode(',', $ids);
    }

    public function updatePrices()
    {
        try {
            $result = Coingecko::getCoinsMarkets($this->getIds());

            foreach($result as $item) {
                $coin = Coin::where('coingecko_id', $item['id'])->first();
                $this->update([
                    'image' => $item['image'],
                    'current_price' => $item['current_price'],
                    'price_change_24h' => $item['price_change_24h'],
                    'price_change_percentage_24h' => $item['price_change_percentage_24h'],
                    'high_24h' => $item['high_24h'],
                    'low_24h' => $item['low_24h'],
                ], $coin->id);
            }
        } catch (\Throwable $th) {

        }
    }
}

<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoinSeeder extends Seeder
{
    private $coins = array(
        [
            'symbol' => 'BTC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'LTC',
            'name' => 'Litecoin',
            'coingecko_id' => 'litecoin',
        ],
        [
            'symbol' => 'DASH',
            'name' => 'Dash',
            'coingecko_id' => 'dash',
        ],
        [
            'symbol' => 'DOGE',
            'name' => 'Dogecoin',
            'coingecko_id' => 'dogecoin',
        ],
        [
            'symbol' => 'BCH',
            'name' => 'Bitcoin Cash',
            'coingecko_id' => 'bitcoin-cash',
        ],
        [
            'symbol' => 'ETH',
            'name' => 'Ethereum',
            'coingecko_id' => 'ethereum',
        ],
        [
            'symbol' => 'ETC',
            'name' => 'Ethereum Classic',
            'coingecko_id' => 'ethereum-classic',
        ],
        [
            'symbol' => 'USDC',
            'name' => 'USD Coin',
            'coingecko_id' => 'usd-coin',
        ],
        [
            'symbol' => 'USDT',
            'name' => 'Tether',
            'coingecko_id' => 'tether',
        ],
        [
            'symbol' => 'AAVE',
            'name' => 'Aave',
            'coingecko_id' => 'aave',
        ],
        [
            'symbol' => 'ACH',
            'name' => 'Alchemy Pay',
            'coingecko_id' => 'alchemy-pay',
        ],
        [
            'symbol' => 'ADA',
            'name' => 'Cardano',
            'coingecko_id' => 'cardano',
        ],
        [
            'symbol' => 'AGLD',
            'name' => 'Adventure Gold',
            'coingecko_id' => 'adventure-gold',
        ],
        [
            'symbol' => 'ALCX',
            'name' => 'Alchemix',
            'coingecko_id' => 'alchemix',
        ],
        [
            'symbol' => 'ALGO',
            'name' => 'Algorand',
            'coingecko_id' => 'algorand',
        ],
        [
            'symbol' => 'AMP',
            'name' => 'Amp',
            'coingecko_id' => 'amp-token',
        ],
        [
            'symbol' => 'ANKR',
            'name' => 'Ankr',
            'coingecko_id' => 'ankr',
        ],
        [
            'symbol' => 'ARPA',
            'name' => 'ARPA Chain',
            'coingecko_id' => 'arpa-chain',
        ],
        [
            'symbol' => 'ATOM',
            'name' => 'Cosmos',
            'coingecko_id' => 'cosmos',
        ],
        [
            'symbol' => 'AVAX',
            'name' => 'Avalanche',
            'coingecko_id' => 'avalanche-2',
        ],
        [
            'symbol' => 'AXS',
            'name' => 'Axie Infinity',
            'coingecko_id' => 'axie-infinity',
        ],
        [
            'symbol' => 'BAL',
            'name' => 'Balancer',
            'coingecko_id' => 'balancer',
        ],
        [
            'symbol' => 'BAND',
            'name' => 'Band Protocol',
            'coingecko_id' => 'band-protocol',
        ],
        [
            'symbol' => 'BAT',
            'name' => 'Basic Attention Token',
            'coingecko_id' => 'basic-attention-token',
        ],
        [
            'symbol' => 'BLZ',
            'name' => 'Bluzelle',
            'coingecko_id' => 'bluzelle',
        ],
        [
            'symbol' => 'BNT',
            'name' => 'Bancor Network Token',
            'coingecko_id' => 'bancor',
        ],
        [
            'symbol' => 'BOND',
            'name' => 'BarnBridge',
            'coingecko_id' => 'barnbridge',
        ],
        [
            'symbol' => 'BTRST',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'CGLD',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'CHZ',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'CLV',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'COMP',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'COVAL',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'CRO',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'CRV',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'CTSI',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'CVC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'DAI',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'DASH',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'DDX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'DESO',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'DNT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'DOT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'ENJ',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'ENS',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'EOS',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],

        [
            'symbol' => 'FARM',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'FET',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'FIL',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'FORTH',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'FOX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'FX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'GALA',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'GFI',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'GNT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'GODS',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'GRT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'GTC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'GYEN',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'ICP',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'IDEX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'IMX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'INV',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'IOTX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'JASMY',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'KNC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'KRL',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'LCX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'LINK',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'LOOM',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'LPT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'LQTY',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'LRC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'MANA',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'MASK',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'MATIC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'MDT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'MIR',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'MKR',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'MLN',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'MUSD',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'NCT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'NKN',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'NMR',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'NU',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'OGN',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'OMG',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'ORN',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'OXT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'PAX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'PERP',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'PLA',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'POLS',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'POLY',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'POWR',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'PRO',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'QNT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'QUICK',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'RAD',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'RAI',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'RARI',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'RBN',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'REN',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'REP',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'REQ',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'RGT',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'RLC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'RLY',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'SHIB',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'SKL',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'SNX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'SOL',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'STORJ',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'UMA',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'UNI',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'VGX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'WBTC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'XLM',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'XRP',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'XTZ',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'ZEC',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'ZEN',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
        [
            'symbol' => 'ZRX',
            'name' => 'Bitcoin',
            'coingecko_id' => 'bitcoin',
        ],
    );
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        foreach($this->coins as $coin) {
            DB::table('coins')->insert([
                'symbol' => $coin['symbol'],
                'name' => $coin['name'],
                'coingecko_id' => $coin['coingecko_id'],
            ]);
        }
    }
}

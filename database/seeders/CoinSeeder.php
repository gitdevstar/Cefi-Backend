<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class CoinSeeder extends Seeder
{
    private $coins = array(
        [
            'symbol' => 'PEPE',
            'name' => 'PEPPER Token',
            'coingecko_id' => 'pepe',
        ],
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
            'symbol' => 'DAI',
            'name' => 'Dai',
            'coingecko_id' => 'dai',
        ],
        [
            'symbol' => 'DASH',
            'name' => 'Dash',
            'coingecko_id' => 'dash',
        ],
        [
            'symbol' => 'AAVE',
            'name' => 'Aave',
            'coingecko_id' => 'aave',
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
            'symbol' => 'MATIC',
            'name' => 'Polygon',
            'coingecko_id' => 'matic-network',
        ],
        [
            'symbol' => 'SOL',
            'name' => 'Solana',
            'coingecko_id' => 'solana',
        ],
        [
            'symbol' => 'STORJ',
            'name' => 'Storj',
            'coingecko_id' => 'storj',
        ],
        [
            'symbol' => 'WBTC',
            'name' => 'Wrapped Bitcoin',
            'coingecko_id' => 'wrapped-bitcoin',
        ],
        [
            'symbol' => 'XLM',
            'name' => 'Stellar',
            'coingecko_id' => 'stellar',
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
            'name' => 'Braintrust',
            'coingecko_id' => 'braintrust',
        ],
        [
            'symbol' => 'CHZ',
            'name' => 'Chiliz',
            'coingecko_id' => 'chiliz',
        ],
        [
            'symbol' => 'CLV',
            'name' => 'Clover',
            'coingecko_id' => 'clover',
        ],
        [
            'symbol' => 'COMP',
            'name' => 'Compound',
            'coingecko_id' => 'compound-governance-token',
        ],
        [
            'symbol' => 'COVAL',
            'name' => 'Circuits of Value',
            'coingecko_id' => 'circuits-of-value',
        ],
        [
            'symbol' => 'CRV',
            'name' => 'Curve DAO Token',
            'coingecko_id' => 'curve-dao-token',
        ],
        [
            'symbol' => 'CTSI',
            'name' => 'Cartesi',
            'coingecko_id' => 'cartesi',
        ],
        [
            'symbol' => 'CVC',
            'name' => 'Civic',
            'coingecko_id' => 'civic',
        ],
        [
            'symbol' => 'DDX',
            'name' => 'DerivaDAO',
            'coingecko_id' => 'derivadao',
        ],
        [
            'symbol' => 'DOT',
            'name' => 'Polkadot',
            'coingecko_id' => 'polkadot',
        ],
        [
            'symbol' => 'ENJ',
            'name' => 'Enjin Coin',
            'coingecko_id' => 'enjincoin',
        ],
        [
            'symbol' => 'EOS',
            'name' => 'EOS',
            'coingecko_id' => 'eos',
        ],

        [
            'symbol' => 'FARM',
            'name' => 'Harvest Finance',
            'coingecko_id' => 'harvest-finance',
        ],
        [
            'symbol' => 'FORTH',
            'name' => 'Ampleforth Governance Token',
            'coingecko_id' => 'ampleforth-governance-token',
        ],
        [
            'symbol' => 'FX',
            'name' => 'Function X',
            'coingecko_id' => 'fx-coin',
        ],
        [
            'symbol' => 'GALA',
            'name' => 'Gala',
            'coingecko_id' => 'gala',
        ],
        [
            'symbol' => 'GFI',
            'name' => 'GameFi Token',
            'coingecko_id' => 'gamefi-token',
        ],
        [
            'symbol' => 'GNT',
            'name' => 'GreenTrust',
            'coingecko_id' => 'greentrust',
        ],
        [
            'symbol' => 'IMX',
            'name' => 'Immutable X',
            'coingecko_id' => 'immutable-x',
        ],
        [
            'symbol' => 'IOTX',
            'name' => 'IoTeX',
            'coingecko_id' => 'iotex',
        ],
        [
            'symbol' => 'JASMY',
            'name' => 'JasmyCoin',
            'coingecko_id' => 'jasmycoin',
        ],
        [
            'symbol' => 'KNC',
            'name' => 'Kyber Network Crystal',
            'coingecko_id' => 'kyber-network-crystal',
        ],
        [
            'symbol' => 'KRL',
            'name' => 'Kart Racing League',
            'coingecko_id' => 'kart-racing-league',
        ],
        [
            'symbol' => 'LCX',
            'name' => 'LCX',
            'coingecko_id' => 'lcx',
        ],
        [
            'symbol' => 'LINK',
            'name' => 'LINK',
            'coingecko_id' => 'link',
        ],
        [
            'symbol' => 'LPT',
            'name' => 'Livepeer',
            'coingecko_id' => 'livepeer',
        ],
        [
            'symbol' => 'LQTY',
            'name' => 'Liquity',
            'coingecko_id' => 'liquity',
        ],
        [
            'symbol' => 'LRC',
            'name' => 'Loopring',
            'coingecko_id' => 'loopring',
        ],
        [
            'symbol' => 'MANA',
            'name' => 'Decentraland',
            'coingecko_id' => 'decentraland',
        ],
        [
            'symbol' => 'MIR',
            'name' => 'Mirror Protocol',
            'coingecko_id' => 'mirror-protocol',
        ],
        [
            'symbol' => 'MLN',
            'name' => 'Enzyme',
            'coingecko_id' => 'melon',
        ],
        [
            'symbol' => 'NKN',
            'name' => 'NKN',
            'coingecko_id' => 'nkn',
        ],
        [
            'symbol' => 'NMR',
            'name' => 'Numeraire',
            'coingecko_id' => 'numeraire',
        ],
        [
            'symbol' => 'NU',
            'name' => 'NuCypher',
            'coingecko_id' => 'nucypher',
        ],
        [
            'symbol' => 'OMG',
            'name' => 'OMG Network',
            'coingecko_id' => 'omisego',
        ],
        [
            'symbol' => 'POLS',
            'name' => 'Polkastarter',
            'coingecko_id' => 'polkastarter',
        ],
        [
            'symbol' => 'POLY',
            'name' => 'Polymath',
            'coingecko_id' => 'polymath',
        ],
        [
            'symbol' => 'QNT',
            'name' => 'Quant',
            'coingecko_id' => 'quant-network',
        ],
        [
            'symbol' => 'QUICK',
            'name' => 'Quickswap',
            'coingecko_id' => 'quick',
        ],
        [
            'symbol' => 'RARI',
            'name' => 'Rarible',
            'coingecko_id' => 'rarible',
        ],
        [
            'symbol' => 'RBN',
            'name' => 'Ribbon Finance',
            'coingecko_id' => 'ribbon-finance',
        ],
        [
            'symbol' => 'REN',
            'name' => 'Rinnegan',
            'coingecko_id' => 'rinnegan',
        ],
        [
            'symbol' => 'REP',
            'name' => 'Augur',
            'coingecko_id' => 'augur',
        ],
        [
            'symbol' => 'SHIB',
            'name' => 'Shiba Inu',
            'coingecko_id' => 'shiba-inu',
        ],
        [
            'symbol' => 'SKL',
            'name' => 'SKALE',
            'coingecko_id' => 'skale',
        ],
        [
            'symbol' => 'UNI',
            'name' => 'UNICORN Token',
            'coingecko_id' => 'unicorn-token',
        ],
        [
            'symbol' => 'VGX',
            'name' => 'Voyager Token',
            'coingecko_id' => 'ethos',
        ],
        [
            'symbol' => 'XTZ',
            'name' => 'Tezos',
            'coingecko_id' => 'tezos',
        ],
        [
            'symbol' => 'ZEC',
            'name' => 'Zcash',
            'coingecko_id' => 'zcash',
        ],
        [
            'symbol' => 'ZEN',
            'name' => 'Horizen',
            'coingecko_id' => 'zencash',
        ],
        [
            'symbol' => 'NCT',
            'name' => 'PolySwarm',
            'coingecko_id' => 'polyswarm',
        ],
        [
            'symbol' => 'LQTY',
            'name' => 'Liquity',
            'coingecko_id' => 'liquity',
        ],
        [
            'symbol' => 'COVAL',
            'name' => 'Circuits of Value',
            'coingecko_id' => 'circuits-of-value',
        ],
        [
            'symbol' => 'INV',
            'name' => 'Inverse Finance',
            'coingecko_id' => 'inverse-finance',
        ],
        [
            'symbol' => 'GYEN',
            'name' => 'GYEN',
            'coingecko_id' => 'gyen',
        ],
        [
            'symbol' => 'PLU',
            'name' => 'Pluton',
            'coingecko_id' => 'pluton',
        ],
        [
            'symbol' => 'UPI',
            'name' => 'Pawtocol',
            'coingecko_id' => 'pawtocol',
        ],
        [
            'symbol' => 'PLAY',
            'name' => 'PLAY Token',
            'coingecko_id' => 'play-token',
        ],
        [
            'symbol' => 'GODS',
            'name' => 'Gods Unchained',
            'coingecko_id' => 'gods-unchained',
        ],
        [
            'symbol' => 'SNX',
            'name' => 'Synthetix Network Token',
            'coingecko_id' => 'havven',
        ],
        [
            'symbol' => 'POLS',
            'name' => 'Polkastarter',
            'coingecko_id' => 'polkastarter',
        ],
        [
            'symbol' => 'API3',
            'name' => 'API3',
            'coingecko_id' => 'api3',
        ],
        [
            'symbol' => 'LCX',
            'name' => 'LCX',
            'coingecko_id' => 'lcx',
        ],
        [
            'symbol' => 'GFI',
            'name' => 'GameFi Token',
            'coingecko_id' => 'gamefi-token',
        ],
        [
            'symbol' => 'RNDR',
            'name' => 'Render Token',
            'coingecko_id' => 'render-token',
        ],
        [
            'symbol' => 'ORCA',
            'name' => 'Orca',
            'coingecko_id' => 'orca',
        ],
        [
            'symbol' => 'XYO',
            'name' => 'XYO Network',
            'coingecko_id' => 'xyo-network',
        ],
        [
            'symbol' => 'FIDA',
            'name' => 'Bonfida',
            'coingecko_id' => 'bonfida',
        ],
        [
            'symbol' => 'MUSD',
            'name' => 'mStable USD',
            'coingecko_id' => 'musd',
        ],
        [
            'symbol' => 'FORTH',
            'name' => 'Ampleforth Governance Token',
            'coingecko_id' => 'ampleforth-governance-token',
        ],
    );
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('coins')->delete();

        foreach($this->coins as $coin) {
            DB::table('coins')->insert([
                'symbol' => $coin['symbol'],
                'name' => $coin['name'],
                'coingecko_id' => $coin['coingecko_id'],
            ]);
        }
    }
}

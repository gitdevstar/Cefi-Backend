<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class SettingsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        DB::table('settings')->delete();
        DB::table('settings')->insert([
            [
                'key' => 'site_title',
                'value' => 'Pepper Global'
            ],
            [
                'key' => 'admin_site_title',
                'value' => 'Pepper Global Admin'
            ],
            [
                'key' => 'coin_trade_fee',
                'value' => 4
            ],
            [
                'key' => 'usdc_withdraw_fee',
                'value' => 30
            ],
            [
                'key' => 'paypal_withdraw_fee',
                'value' => 25
            ],
            [
                'key' => 'cash_conversation_fee',
                'value' => 8
            ],
        ]);
    }
}

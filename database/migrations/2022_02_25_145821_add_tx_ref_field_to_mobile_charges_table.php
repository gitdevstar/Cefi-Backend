<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddTxRefFieldToMobileChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_charges', function (Blueprint $table) {
            $table->string('tx_ref')->after('txn_id')->nullable(false)->default('');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('mobile_charges', function (Blueprint $table) {
            $table->dropColumn('tx_ref');
        });
    }
}

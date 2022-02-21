<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldToBankChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('bank_charges', function (Blueprint $table) {
            $table->string('status')->after('txn_id')->nullable(false)->default('CREATED');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('bank_charges', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}

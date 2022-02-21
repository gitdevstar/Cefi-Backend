<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddStatusFieldToMobileChargesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('mobile_charges', function (Blueprint $table) {
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
        Schema::table('mobile_charges', function (Blueprint $table) {
            $table->dropColumn('status');
        });
    }
}

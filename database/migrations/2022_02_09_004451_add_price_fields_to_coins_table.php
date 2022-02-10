<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddPriceFieldsToCoinsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('coins', function (Blueprint $table) {
            $table->string('image')->nullable();
            $table->string('current_price')->default("0");
            $table->string('price_change_24h')->default("0");
            $table->string('price_change_percentage_24h')->default("0");
            $table->string('high_24h')->default("0");
            $table->string('low_24h')->default("0");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('coins', function (Blueprint $table) {
            $table->dropColumn('image');
            $table->dropColumn('current_price');
            $table->dropColumn('price_change_24h');
            $table->dropColumn('price_change_percentage_24h');
            $table->dropColumn('high_24h');
            $table->dropColumn('low_24h');
        });
    }
}

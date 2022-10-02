<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class AddColumnsToEcOrderAddresses extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('ec_order_addresses', function (Blueprint $table) {
            $table->string('provinceName')->nullable();
            $table->string('districtName')->nullable();
            $table->string('wardName')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('ec_order_addresses', function (Blueprint $table) {
            //
        });
    }
}
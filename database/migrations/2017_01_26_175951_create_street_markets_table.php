<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateStreetMarketsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('street_markets', function (Blueprint $table) {
            $table->increments('id');
            $table->char('registration_code', 6);
            $table->string('street_market_name');
            $table->string('street_name');
            $table->string('street_number');
            $table->string('neighborhood');
            $table->string('landmark')->nullable();
            $table->integer('latitude');
            $table->integer('longitude');
            $table->tinyInteger('district_code');
            $table->string('district_name');
            $table->tinyInteger('council_code');
            $table->string('council_name');
            $table->string('five_area_region');
            $table->string('eight_area_region');
            $table->bigInteger('census_tract');
            $table->bigInteger('census_tract_group');
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
        Schema::dropIfExists('street_markets');
    }
}
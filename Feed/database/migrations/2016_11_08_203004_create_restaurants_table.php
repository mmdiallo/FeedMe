<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRestaurantsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('retaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id');
            $table->foreign('account_id')->references('id')->on('accounts');
            $table->string('email');
            $table->string('name');
            $table->string('street_address');
            $table->string('city');
            $table->string('state');
            $table->integer('phone_number');
            $table->integer('hours_id');
            $table->foreign('hours_id')->references('id')->on('hours');
            $table->integer('menu_id');
            $table->foreign('menu_id')->references('id')->on('menus');
            $table->integer('cuisinetype_id');
            $table->foreign('cuisinetype_id')->references('id')->on('cuisinetypes');
            $table->integer('pricerating_id');
            $table->foreign('pricerating_id')->references('id')->on('priceratings');
            $table->string('websiteurl'); 
            $table->string('biopath');
            $table->string('profileimagepath');      
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
        Schema::dropIfExists('retaurants');
    }
}

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
        Schema::create('restaurants', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('account_id')->unsigned()->index();
            $table->text('email');
            $table->text('name');
            $table->text('street_address');
            $table->text('city');
            $table->text('state');
            $table->integer('phone_number');
            $table->integer('hours_id');
            $table->integer('menu_id');
            $table->integer('cuisinetype_id');
            $table->integer('pricerating_id');
            $table->text('websiteurl'); 
            $table->text('biopath');
            $table->text('profileimagepath');      
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
        Schema::dropIfExists('restaurants');
    }
}
